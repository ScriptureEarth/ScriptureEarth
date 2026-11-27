<?php
/*
	ZipStreamer.php

	Streams a ZIP archive straight to the browser (php://output) as it is built,
	so no temporary .zip is ever written to disk and there is nothing to clean up
	afterwards. Source files are read directly and are never copied.

	Entries are deflate-compressed by default (same as the old ZipArchive code).
	Because the compressed size of each entry is not known until it has been
	streamed, every entry is written with a data descriptor and the response has
	no exact Content-Length (browsers show an indeterminate progress bar). Files
	larger than 4 GB, and archives larger than 4 GB, are handled with Zip64.

	Usage:
		require_once('./include/ZipStreamer.php');
		$zip = new ZipStreamer('MyDownload.zip');           // download filename
		$zip->setComment('Downloaded from ScriptureEarth.org.');
		$zip->addFile($srcPath, $nameInZip);                // repeat as needed
		...
		$zip->finish();                                     // flushes the archive

	Requires PHP 7.1+ (pack 'P'/'J', incremental deflate, hash 'crc32b').
*/

class ZipStreamer {

	const CHUNK      = 1048576;          // 1 MB read/deflate chunk
	const MARK32     = 0xFFFFFFFF;       // sentinel written into 32-bit fields when Zip64 is used
	const ZIP64_LIMIT = 0xFFFFFFFF;      // 4 GB - 1: size/offset threshold for switching to Zip64

	private $downloadName;
	private $comment = '';
	private $compress;                   // true = deflate (method 8), false = store (method 0)

	private $central = array();          // collected central-directory records
	private $offset  = 0;                // bytes written to output so far
	private $started = false;

	/**
	 * @param string $downloadName  Filename offered to the browser.
	 * @param bool   $compress      true to deflate entries, false to store them.
	 */
	public function __construct($downloadName, $compress = true) {
		$this->downloadName = $downloadName;
		$this->compress     = $compress;
	}

	public function setComment($comment) {
		// The ZIP end-of-central-directory comment field is limited to 65535 bytes.
		$this->comment = substr($comment, 0, 0xFFFF);
	}

	/**
	 * Queue-free: each addFile streams immediately.
	 *
	 * @param string $sourcePath  Path to the file on disk to read.
	 * @param string $nameInZip   Name (and optional path) stored inside the archive.
	 * @return bool  false if the source file could not be opened (nothing written).
	 */
	public function addFile($sourcePath, $nameInZip) {
		if (!is_file($sourcePath) || !is_readable($sourcePath)) {
			return false;
		}
		$in = @fopen($sourcePath, 'rb');
		if ($in === false) {
			return false;
		}

		$this->sendHeadersOnce();

		$name     = $this->sanitizeName($nameInZip);
		$mtime    = @filemtime($sourcePath);
		if ($mtime === false) { $mtime = time(); }
		list($dosTime, $dosDate) = $this->dosTime($mtime);

		$uncompressed = 0;
		$compressed   = 0;
		$crc          = hash_init('crc32b');
		$method       = $this->compress ? 8 : 0;

		// A file may grow past 4 GB while streaming; we cannot know the final
		// size for certain up front, but filesize() is an accurate predictor for
		// choosing Zip64 for the local header / data descriptor width.
		$predicted = @filesize($sourcePath);
		$localZip64 = ($predicted !== false && $predicted >= self::ZIP64_LIMIT);

		$localHeaderOffset = $this->offset;
		$this->writeLocalHeader($name, $method, $dosTime, $dosDate, $localZip64);

		$deflate = null;
		if ($this->compress) {
			$deflate = deflate_init(ZLIB_ENCODING_RAW);   // raw stream = ZIP method 8
		}

		while (!feof($in)) {
			$data = fread($in, self::CHUNK);
			if ($data === false) { break; }
			if ($data !== '') {
				$uncompressed += strlen($data);
				hash_update($crc, $data);
				if ($this->compress) {
					$out = deflate_add($deflate, $data, ZLIB_NO_FLUSH);
				} else {
					$out = $data;
				}
				if ($out !== '') {
					$compressed += strlen($out);
					$this->write($out);
				}
			}
			$this->keepAlive();
		}
		fclose($in);

		if ($this->compress) {
			$out = deflate_add($deflate, '', ZLIB_FINISH);
			if ($out !== '') {
				$compressed += strlen($out);
				$this->write($out);
			}
		}

		$crc32 = hexdec(hash_final($crc));

		// If the file actually exceeded 4 GB (or predicted wrong), the descriptor
		// width is fixed by what we wrote in the local header ($localZip64).
		$this->writeDataDescriptor($crc32, $compressed, $uncompressed, $localZip64);

		$this->central[] = array(
			'name'     => $name,
			'method'   => $method,
			'dosTime'  => $dosTime,
			'dosDate'  => $dosDate,
			'crc'      => $crc32,
			'comp'     => $compressed,
			'unc'      => $uncompressed,
			'offset'   => $localHeaderOffset,
			'zip64'    => ($localZip64 || $compressed >= self::ZIP64_LIMIT
			               || $uncompressed >= self::ZIP64_LIMIT
			               || $localHeaderOffset >= self::ZIP64_LIMIT),
		);
		return true;
	}

	/**
	 * Write the central directory and end-of-central-directory records.
	 * Must be called exactly once, after all addFile() calls.
	 */
	public function finish() {
		$this->sendHeadersOnce();   // handles the zero-file edge case

		$cdStart = $this->offset;
		foreach ($this->central as $e) {
			$this->writeCentralHeader($e);
		}
		$cdSize = $this->offset - $cdStart;

		$this->writeEndRecords(count($this->central), $cdSize, $cdStart);

		$this->flushOutput();
	}

	// ---------------------------------------------------------------- internals

	private function sendHeadersOnce() {
		if ($this->started) { return; }
		$this->started = true;

		// Discard any buffering/compression so raw ZIP bytes reach the client.
		while (ob_get_level() > 0) { @ob_end_clean(); }
		if (ini_get('zlib.output_compression')) {
			@ini_set('zlib.output_compression', 'Off');
		}

		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="' . $this->downloadName . '"');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		// No Content-Length: the compressed size is unknown while streaming.
	}

	private function write($bytes) {
		echo $bytes;
		$this->offset += strlen($bytes);
	}

	private function keepAlive() {
		// Big archives can take a while; keep the request alive and push bytes out.
		set_time_limit(0);
		flush();
	}

	private function flushOutput() {
		flush();
	}

	private function sanitizeName($name) {
		// Store forward slashes, drop any leading slash / drive, collapse '..'.
		$name = str_replace('\\', '/', $name);
		$name = preg_replace('#/+#', '/', $name);
		$name = ltrim($name, '/');
		$name = str_replace('../', '', $name);
		return $name;
	}

	private function dosTime($mtime) {
		$t = getdate($mtime);
		$year = $t['year'];
		if ($year < 1980) { $year = 1980; }
		$dosTime = ($t['hours'] << 11) | ($t['minutes'] << 5) | ($t['seconds'] >> 1);
		$dosDate = (($year - 1980) << 9) | ($t['mon'] << 5) | $t['mday'];
		return array($dosTime & 0xFFFF, $dosDate & 0xFFFF);
	}

	private function writeLocalHeader($name, $method, $dosTime, $dosDate, $zip64) {
		// General purpose flags: bit 3 (data descriptor) + bit 11 (UTF-8 names).
		$flags   = 0x0008 | 0x0800;
		$version = $zip64 ? 45 : 20;

		$extra = '';
		if ($zip64) {
			// Zip64 extended info: sizes unknown now (data descriptor) -> zeros.
			$extra = pack('v', 0x0001) . pack('v', 16) . pack('P', 0) . pack('P', 0);
		}
		$sizeField = $zip64 ? self::MARK32 : 0;

		$header  = pack('V', 0x04034b50);   // local file header signature
		$header .= pack('v', $version);     // version needed to extract
		$header .= pack('v', $flags);       // general purpose bit flag
		$header .= pack('v', $method);      // compression method
		$header .= pack('v', $dosTime);     // last mod file time
		$header .= pack('v', $dosDate);     // last mod file date
		$header .= pack('V', 0);            // crc-32 (in data descriptor)
		$header .= pack('V', $sizeField);   // compressed size (in data descriptor)
		$header .= pack('V', $sizeField);   // uncompressed size (in data descriptor)
		$header .= pack('v', strlen($name));
		$header .= pack('v', strlen($extra));
		$header .= $name;
		$header .= $extra;

		$this->write($header);
	}

	private function writeDataDescriptor($crc, $comp, $unc, $zip64) {
		$dd  = pack('V', 0x08074b50);       // data descriptor signature (optional but common)
		$dd .= pack('V', $crc);
		if ($zip64) {
			$dd .= pack('P', $comp);        // 8-byte compressed size
			$dd .= pack('P', $unc);         // 8-byte uncompressed size
		} else {
			$dd .= pack('V', $comp);        // 4-byte compressed size
			$dd .= pack('V', $unc);         // 4-byte uncompressed size
		}
		$this->write($dd);
	}

	private function writeCentralHeader($e) {
		$zip64 = $e['zip64'];

		// Build the Zip64 extra field with only the fields that overflow, in the
		// order the spec requires: uncompressed, compressed, local header offset.
		$extra = '';
		$uncField    = $e['unc'];
		$compField   = $e['comp'];
		$offsetField = $e['offset'];
		if ($zip64) {
			$z = '';
			if ($e['unc'] >= self::ZIP64_LIMIT) {
				$z .= pack('P', $e['unc']);   $uncField  = self::MARK32;
			}
			if ($e['comp'] >= self::ZIP64_LIMIT) {
				$z .= pack('P', $e['comp']);  $compField = self::MARK32;
			}
			if ($e['offset'] >= self::ZIP64_LIMIT) {
				$z .= pack('P', $e['offset']); $offsetField = self::MARK32;
			}
			if ($z === '') {
				// Marked zip64 but nothing actually overflows: include sizes so
				// the local-header zip64 field stays consistent.
				$z = pack('P', $e['unc']) . pack('P', $e['comp']);
				$uncField = self::MARK32; $compField = self::MARK32;
			}
			$extra = pack('v', 0x0001) . pack('v', strlen($z)) . $z;
		}

		$version = $zip64 ? 45 : 20;
		$flags   = 0x0008 | 0x0800;

		$header  = pack('V', 0x02014b50);   // central file header signature
		$header .= pack('v', 0x031E);       // version made by (3 = Unix, 0x1E = 3.0)
		$header .= pack('v', $version);     // version needed to extract
		$header .= pack('v', $flags);       // general purpose bit flag
		$header .= pack('v', $e['method']); // compression method
		$header .= pack('v', $e['dosTime']);
		$header .= pack('v', $e['dosDate']);
		$header .= pack('V', $e['crc']);
		$header .= pack('V', $compField);
		$header .= pack('V', $uncField);
		$header .= pack('v', strlen($e['name']));
		$header .= pack('v', strlen($extra));
		$header .= pack('v', 0);            // file comment length
		$header .= pack('v', 0);            // disk number start
		$header .= pack('v', 0);            // internal file attributes
		$header .= pack('V', 0);            // external file attributes
		$header .= pack('V', $offsetField); // relative offset of local header
		$header .= $e['name'];
		$header .= $extra;

		$this->write($header);
	}

	private function writeEndRecords($count, $cdSize, $cdOffset) {
		$needZip64 = ($count >= 0xFFFF
		              || $cdSize   >= self::ZIP64_LIMIT
		              || $cdOffset >= self::ZIP64_LIMIT);

		if ($needZip64) {
			// Zip64 end of central directory record.
			$z64  = pack('V', 0x06064b50);
			$z64 .= pack('P', 44);              // size of remainder of this record
			$z64 .= pack('v', 0x031E);          // version made by
			$z64 .= pack('v', 45);              // version needed to extract
			$z64 .= pack('V', 0);               // number of this disk
			$z64 .= pack('V', 0);               // disk with start of central dir
			$z64 .= pack('P', $count);          // entries on this disk
			$z64 .= pack('P', $count);          // total entries
			$z64 .= pack('P', $cdSize);
			$z64 .= pack('P', $cdOffset);
			$this->write($z64);

			// Zip64 end of central directory locator.
			$loc  = pack('V', 0x07064b50);
			$loc .= pack('V', 0);               // disk with zip64 EOCD
			$loc .= pack('P', $cdOffset + $cdSize);
			$loc .= pack('V', 1);               // total number of disks
			$this->write($loc);
		}

		// End of central directory record.
		$cnt      = $needZip64 ? 0xFFFF : $count;
		$size     = $needZip64 ? self::MARK32 : $cdSize;
		$off      = $needZip64 ? self::MARK32 : $cdOffset;
		$comment  = $this->comment;

		$eocd  = pack('V', 0x06054b50);
		$eocd .= pack('v', 0);              // number of this disk
		$eocd .= pack('v', 0);              // disk with start of central directory
		$eocd .= pack('v', $cnt);          // entries on this disk
		$eocd .= pack('v', $cnt);          // total entries
		$eocd .= pack('V', $size);         // size of central directory
		$eocd .= pack('V', $off);          // offset of central directory
		$eocd .= pack('v', strlen($comment));
		$eocd .= $comment;

		$this->write($eocd);
	}
}
