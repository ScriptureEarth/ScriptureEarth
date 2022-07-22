<?php
/*
input:
	var title = $('#title').val();
	var reference = $('#reference').val();
	var image = $('#image').val();
	var video = $('#video').val();
	var text = $('#text').text();
output:
	devotion table:
		titulo
		lectura
		texto
		imagen
		video
	titulos:
		titulo
		video (boolen)
*/

require_once '../include/conn.ini.MSL.php';								// connect to the database named 'dbs43253'
$db = get_my_db();

if (isset($_POST["indx"])) {
	$indx = $_POST["indx"];
	preg_match('/^([0-9]*$)/', $indx, $matches);
	if ($indx != $matches[1]) {
		die('¡Hackeado!</body></html>');
	}
}
else {
	die('1 Die!');
}
if (isset($_POST["titulo"])) {
	$titulo = $_POST["titulo"];
	if (trim($titulo) == '') {
//		die('Die! titulo is empty!');
	}
}
else {
	die('Die! titulo is empty!');
}
if (isset($_POST["mes"])) {
	$mes = $_POST["mes"];
}
else {
	die('1.2 Die!');
}
if (isset($_POST["ano"])) {
	$año = $_POST["ano"];
}
else {
	die('1.1 Die!');
}

if (isset($_POST["lectura"])) {
	$lectura = $_POST["lectura"];
}
else {
	die('3 Die!');
}
if (isset($_POST["lecturaHTML"])) {
	$lecturaHTML = $_POST["lecturaHTML"];
}
else {
	die('4 Die!');
}
if (isset($_POST["texto"])) {
	$texto = $_POST["texto"];
}
else {
	die('5 Die!');
}
if (isset($_POST["InOrUp"])) {
	$InOrUp = $_POST["InOrUp"];
	preg_match('/^([A-Z]{6}$)/', $InOrUp, $matches);
	if ($InOrUp != $matches[1]) {
		die('¡Hackeado!</body></html>');
	}
}
else {
	die('6 Die!');
}
if (isset($_POST["hrjpeg"])) {
	$hrjpeg = $_POST["hrjpeg"];
}
else {
	die('7 Die!');
}
if (isset($_POST["cuadro"])) {
	$cuadro = $_POST["cuadro"];
}
else {
	die('8 Die!');
}
if (isset($_POST["imagen"])) {
	$imagen = $_POST["imagen"];
}
else {
	die('9 Die!');
}
if (isset($_POST["video"])) {
	$video = $_POST["video"];
}
else {
	die('10 Die!');
}

/*$imageFileContent = $_POST["imageFileContent"];
if ($imageFileContent !== '') {
	$handle = fopen('../_Media/'.$año.'/'.$mes.'/miniatura/'.$hrjpeg, "wb");
	//file_put_contents('../_Media/'.$año.'/'.$mes.'/miniatura/'.$hrjpeg, $imageFileContent, FILE_USE_INCLUDE_PATH);
	fwrite($handle, $imageFileContent, strlen($imageFileContent));
	fclose($handle);
}*/

if ($InOrUp == 'INSERT') {
	/*
	titulo
	lectura
	texto
	cuadro
	video
	imagen
	*/
	$query='INSERT INTO devocion (`index`, titulo, lectura, lecturaHTML, texto, cuadro, video, imagen) VALUES ('.$indx.', "'.$titulo.'", "'.$lectura.'", "'.$lecturaHTML.'", "'.$texto.'", "'.$cuadro.'", "'.$video.'", "'.$imagen.'")';
}
else {
	$query='UPDATE devocion SET titulo="'.$titulo.'", lectura="'.$lectura.'", lecturaHTML="'.$lecturaHTML.'", texto="'.$texto.'", cuadro="'.$cuadro.'", video="'.$video.'", imagen="'.$imagen.'" WHERE `index` = '.$indx;
}
$db->query($query);

//echo '#' . $video . '#<br />';

$query="UPDATE titulos SET titulo='$titulo', hrjpeg='$hrjpeg', video=" . (($video ==  '') ? 0 : 1) . " WHERE `index` = $indx";
$db->query($query);

echo $titulo;
?>
