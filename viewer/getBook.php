<?php 

/******************************************************************************/
/* get book text from paratext file -convert to html -called from views.php   */
/******************************************************************************/
/*  Developed by:  Ken Sladaritz                                              */
/*                 Marshall Computer Service                                  */
/*                 2660 E End Blvd S, Suite 122                               */
/*                 Marshall, TX 75672                                         */
/*                 ken@marshallcomputer.net                                   */
/*                                                                            */
/*  Modified by:   Scott Starker                                              */
/*                 scott_starker@sil.org                                      */
/******************************************************************************/

include "config.php";
include "../translate/functions.php";

$text = '';
$tag = '';
$verseB =  [];
$output = '';

if (isset($_GET['st'])) {
	$st = $_GET['st'];
	$st = preg_replace('/^([a-z]{3})/', '$1', $st);
	if ($st == NULL) {
		die('Hack!');
	}
}
else {
	 die('Hack!');
}

if (isset($_GET['rtl'])) {
	$rtl = $_GET['rtl'];
	$rtl = preg_replace('/^(0|1)/', '$1', $rtl);
	if ($rtl != '0' && $rtl != '1' && $rtl != NULL) {
		die('Hack!');
	}
}
else {
	 die('Hack!');
}

if (isset($_GET["iso"])) {
	$ISO = $_GET["iso"];
	$ISO = preg_replace('/^([a-z]{3})/', '$1', $ISO);
	if ($ISO == NULL) {
		die('Hack!');
	}
}
else {
	die('Hack!');
}

if (isset($_GET['book'])) {
	$Book = $_GET['book'];
}
else {
	die('Hack!');
}

//echo '../data/'.$ISO.'/viewer/'.$Book . "<br />";

if (file_exists('../data/'.$ISO.'/viewer/'.$Book)) {
 $index = [];
 $subjects = [];
 $s = 0;
 $table = '';

// $originalText = file_get_contents('../data/'.$ISO.'/viewer/'.$Book);
 $details = explode("\r\n\\", file_get_contents('../data/'.$ISO.'/viewer/'.$Book));

 foreach($details as $detail) {																// $Book line by line
/** 2011-05-12 ***********************************/
  $detail = str_replace("//", " ", $detail);
/*************************************************/
  str_replace("\r\n", " ", $detail);
  $detail .= ' ';  // add space for tags without data
  $tag   = trim(substr($detail, 0, strpos($detail,' ')));									// SFM tags
  $data  = trim(substr($detail, strpos($detail,' ')));										// the rest of the data

  // skip tags
  if($tag=='id')  {$tag = ''; $text = ''; $data = '';} 
  if($tag=='\id') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='rem') {$tag = ''; $text = ''; $data = '';} 
  // 2012-10-4 Scott Starker
  if($tag=='toc1') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='toc2') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='toc3') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='TOC1') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='TOC2') {$tag = ''; $text = ''; $data = '';} 
  if($tag=='TOC3') {$tag = ''; $text = ''; $data = '';} 

  if($tag!='tr' and $table) {
   $text .= "</table>"; 
    $table = '';
  }

/******************************************************************************
	if $tag = 'tr' (<table>)
******************************************************************************/
  if($tag=='tr') {
   if(!$table) {
    $text .= "<table>";
    $table = 'on';
   }
   $text .= "<tr>";

   $tag   = trim(substr($detail, 1, strpos($data,' ')));
   $data  = trim(substr($detail, strpos($data,' ')));
   
   $s = array('\th1','\th2','\th3','\th4','th5');
   $data = str_replace($s,'<th>',$data);
   
   $s = array('\tc1','\tc2','\tc3','\tc4','tc5');
   $data = str_replace($s,'<td>',$data);


   // extract embedded verse
   $r=0;
   if(strpos($data,'\v ')!==false) {
    $p1 = strpos($data,'\v ')+3;
    $p2 = strpos($data, ' ',$p1);
    $verse = trim(str_replace($search,'',substr($data,$p1,($p2-$p1))));
    $data = substr($data,0,strpos($data,'\v '))."<span class=\"v\"> ".$verse."</span>".substr($data,$p2); 

    $r++; 
    if($r>5) {echo "<hr>".$data."<hr>"; break;}
   }

   $text .= $data;
   $data = '';
   $tag = '';
  }
/******************************************************************************
	end $tag = 'tr'
*******************************************************************************/

  if(substr($tag,0,2)=="li") {
   $text .= "<br />"; 
  } 

  // chapter
  if($tag=='c') {
   $chapter=$data;
   $text .= "<a name=\"".$chapter.":1"."\"></a>";
  }

  // verse
  if($tag=='v') {
   $verse  = substr($data, 0, strpos($data,' '));
//echo 'verse = #'.$verse.'#<br >';
   $verseB = explode('-', $verse);
//echo 'verseB[0] = #'.$verseB[0].'#<br >';
   $index[$chapter] = $verseB[0];  
   $text .= "<a name=\"".$chapter.":".$verseB[0]."\" onclick=\"setVerse(".$chapter.",".$verseB[0].")\" class=\"v\"> ".$verse."</a>";
   $data  = trim(substr($data, strpos($data,' ')));
   $tag = 'vtext';
  }

  // extract bold
  $r=0;
  while(strpos($data,'\bd')!==false) {
   $p1 = strpos($data,'\bd')+4;
   $bd = substr($data,$p1,(strpos($data, '\bd*')-$p1));
   $data = substr($data,0,strpos($data, '\bd'))."<span class=\"bd\">(".$bd.")</span>".substr($data,(strpos($data, '\bd*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // small cap text
  $r=0;
  while(strpos($data,'\sc')!==false) {
   $p1 = strpos($data,'\sc')+4;
   $sc = substr($data,$p1,(strpos($data, '\sc*')-$p1));
   $data = substr($data,0,strpos($data, '\sc'))."<span class=\"sc\">".$sc."</span>".substr($data,(strpos($data, '\sc*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract bold
  $r=0;
  while(strpos($data,'\add')!==false) {
   $p1 = strpos($data,'\add')+5;
   $add = substr($data,$p1,(strpos($data, '\add*')-$p1));
   $data = substr($data,0,strpos($data, '\add'))."<span class=\"add\">(".$add.")</span>".substr($data,(strpos($data, '\add*')+5)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; exit;}
  }

  // extract cross reference
  $r=0;
  while(strpos($data,'\x')!==false) {
   $p1 = strpos($data,'\xo')+4;
   if($p1) {$xo = "<span class=\"xo\">(".substr($data,$p1,(strpos($data, '\x', $p1)-$p1)).")</span>";} else {$xo='';}
   $p1 = strpos($data,'\xt')+4;
   if($p1) {$xt = "<span class=\"xt\">(".substr($data,$p1,(strpos($data, '\x', $p1)-$p1)).")</span>";} else {$xt='';}
   $data = substr($data,0,strpos($data, '\x')).$xo.$xt.substr($data,(strpos($data, '\x*')+3));

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract cross reference
  $r=0;
  while(strpos($data,'\fm')!==false) {
   $p1 = strpos($data,'\fm')+4;
   $fm = substr($data,$p1,(strpos($data, '\fm*')-$p1));
   $data = substr($data,0,strpos($data, '\fm'))."<a href=\"\" class=\"xt\" title=\"".$fm."\">[&#134;]</a>".substr($data,(strpos($data, '\fm*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract picture - not used, tag discarded
  $r=0;
  while(strpos($data,'\fig')!==false) {
   $p1 = strpos($data,'\fig')+5;
   $fm = substr($data,$p1,(strpos($data, '\fig*')-$p1));
   $data = substr($data,0,strpos($data, '\fig')).substr($data,(strpos($data, '\fig*')+5)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract footnote
  $r=0;
  while(strpos($data,'\f')!==false) {
   $p1 = strpos($data,'\f')+3;
   $search = array('\fr','\fk','\ft','+');
   $footnote = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\f*')-$p1))));		// delete $search
   if(strpos($data, '\f*')) {
	   $data = substr($data,0,strpos($data,'\f'))."<a href=\"\" class=\"xt\" title=\"".$footnote."\">[&#134;]</a>".substr($data,(strpos($data, '\f*')+3));
	} 
	else {
	   $data = substr($data,0,strpos($data,'\f'))."<a href=\"\" class=\"xt\" title=\"".$footnote."\">[&#134;]</a>";
	} 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract key term
  $r=0;
  while(strpos($data,'\k')!==false) {
   $p1 = strpos($data,'\k')+3;
   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\k*')-$p1))));
   $data = substr($data,0,strpos($data,'\k'))."<span class=\"k\">".$phrase." - </span>".substr($data,(strpos($data, '\k*')+3)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

  // extract nd
  $r=0;
  while(strpos($data,'\nd')!==false) {
   $p1 = strpos($data,'\nd')+4;
   $phrase = trim(str_replace('\nd','',substr($data,$p1,(strpos($data, '\nd*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\nd*')-$p1))));
   $data = substr($data,0,strpos($data,'\nd'))."<span class=\"nd\">".$phrase."</span>".substr($data,(strpos($data, '\nd*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }

/** 2011-05-12 ***********************************/
  // extract ior
  $r=0;
  while(strpos($data,'\ior')!==false) {
   $p1 = strpos($data,'\ior')+5;
   $phrase = trim(str_replace('\ior','',substr($data,$p1,(strpos($data, '\ior*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\ior*')-$p1))));
   $data = substr($data,0,strpos($data,'\ior'))."<span class=\"ior\">".$phrase."</span>".substr($data,(strpos($data, '\ior*')+5)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2011-08-24 ***********************************/
  // extract s1 (by Scott Starker)
  $r=0;
  while(strpos($data,'\s1')!==false) {
   $p1 = strpos($data,'\s1')+4;
   $phrase = trim(str_replace('\sl','',substr($data,$p1,(strpos($data, '\s1*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\s1*')-$p1))));
   $data = substr($data,0,strpos($data,'\s1'))."<div class=\"s1\">".$phrase."</div>".substr($data,(strpos($data, '\s1*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2011-07-01 ***********************************/
  // extract imt (by Scott Starker) \imt, \imt1, \imt2, \imt3
  $r=0;
  while(strpos($data,'\im')!==false) {
	  if (strpos($data,'\imt ')!==false) {
		$p1 = strpos($data,'\imt')+5;
		$title = trim(str_replace('\imt','',substr($data,$p1,(strpos($data, '\imt*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\imt*')-$p1))));
		$data = substr($data,0,strpos($data,'\imt'))."<div class=\"imt\">".$title."</div>".substr($data,(strpos($data, '\imt*')+5)); 
	  }
	  if (strpos($data,'\imt1')!==false) {
		$p1 = strpos($data,'\imt1')+5;
		$title = trim(str_replace('\imtl','',substr($data,$p1,(strpos($data, '\imt*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\imt1*')-$p1))));
		$data = substr($data,0,strpos($data,'\imt1'))."<div class=\"imt1\">".$title."</div>".substr($data,(strpos($data, '\imt1*')+6)); 
	  }
	  if (strpos($data,'\imt2')!==false) {
		$p1 = strpos($data,'\imt2')+6;
		$title = trim(str_replace('\im2','',substr($data,$p1,(strpos($data, '\imt*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\imt2*')-$p1))));
		$data = substr($data,0,strpos($data,'\imt2'))."<div class=\"imt2\">".$title."</div>".substr($data,(strpos($data, '\imt2*')+6)); 
	  }
	  if (strpos($data,'\imt3')!==false) {
		$p1 = strpos($data,'\imt3')+6;
		$title = trim(str_replace('\imt3','',substr($data,$p1,(strpos($data, '\imt*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\imt3*')-$p1))));
		$data = substr($data,0,strpos($data,'\imt3'))."<div class=\"imt3\">".$title."</div>".substr($data,(strpos($data, '\imt3*')+6)); 
	  }

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/*************************************************/
  // extract is (by Scott Starker) \is, \is1, \is2, \is3
  $r=0;
  while(strpos($data,'\is')!==false) {
	  if (strpos($data,'\is ')!==false) {
		$p1 = strpos($data,'\is')+4;
		$title = trim(str_replace('\is','',substr($data,$p1,(strpos($data, '\is*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\is*')-$p1))));
		$data = substr($data,0,strpos($data,'\is'))."<span class=\"is\">".$title."</span>".substr($data,(strpos($data, '\is*')+4));
	  }
	  if (strpos($data,'\is1')!==false) {
		$p1 = strpos($data,'\is1')+5;
		$title = trim(str_replace('\is1','',substr($data,$p1,(strpos($data, '\is1*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\is1*')-$p1))));
		$data = substr($data,0,strpos($data,'\is1'))."<span class=\"is1\">".$title."</span>".substr($data,(strpos($data, '\is1*')+5));
	  }
	  if (strpos($data,'\is2')!==false) {
		$p1 = strpos($data,'\is2')+5;
		$title = trim(str_replace('\is2','',substr($data,$p1,(strpos($data, '\is2*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\is2*')-$p1))));
		$data = substr($data,0,strpos($data,'\is2'))."<span class=\"is2\">".$title."</span>".substr($data,(strpos($data, '\is2*')+5));
	  }
	  if (strpos($data,'\is3')!==false) {
		$p1 = strpos($data,'\is3')+5;
		$title = trim(str_replace('\is3','',substr($data,$p1,(strpos($data, '\is3*')-$p1))));
//		$title = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\is3*')-$p1))));
		$data = substr($data,0,strpos($data,'\is3'))."<span class=\"is3\">".$title."</span>".substr($data,(strpos($data, '\is3*')+5));
	  }

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2013-08-02 ***********************************/
  // extract it (by Scott Starker)
  $r=0;
  while(strpos($data,'\it')!==false) {
   $p1 = strpos($data,'\it')+4;
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\it*')-$p1))));
   $phrase = trim(str_replace('\it','',substr($data,$p1,(strpos($data, '\it*')-$p1))));
   $data = substr($data,0,strpos($data,'\it'))."<span class=\"it\">".$phrase."</span>".substr($data,(strpos($data, '\it*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2013-06-18 ***********************************/
  // extract rq (by Scott Starker)
  $r=0;
  while(strpos($data,'\rq')!==false) {
   $p1 = strpos($data,'\rq')+4;
   $phrase = trim(str_replace('\rq','',substr($data,$p1,(strpos($data, '\rq*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\rq*')-$p1))));
   $data = substr($data,0,strpos($data,'\rq'))."<span class=\"rq\">".$phrase."</span>".substr($data,(strpos($data, '\rq*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2013-08-02 ***********************************/
  // extract ip (by Scott Starker)
  $r=0;
  while(strpos($data,'\ip')!==false) {
   $p1 = strpos($data,'\ip')+4;
   $phrase = trim(str_replace('\ip','',substr($data,$p1,(strpos($data, '\ip*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\ip*')-$p1))));
   $data = substr($data,0,strpos($data,'\ip'))."<div class=\"ip\">".$phrase."</div>".substr($data,(strpos($data, '\ip*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2013-06-18 ***********************************/
  // extract ms (by Scott Starker)
  $r=0;
  while(strpos($data,'\ms')!==false) {
   $p1 = strpos($data,'\ms')+4;
   $phrase = trim(str_replace('\ms','',substr($data,$p1,(strpos($data, '\ms*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\ms*')-$p1))));
   $data = substr($data,0,strpos($data,'\ms'))."<div class=\"ms\">".$phrase."</div>".substr($data,(strpos($data, '\ms*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

/** 2013-06-18 ***********************************/
  // extract mr (by Scott Starker)
  $r=0;
  while(strpos($data,'\mr')!==false) {
   $p1 = strpos($data,'\mr')+4;
   $phrase = trim(str_replace('\mr','',substr($data,$p1,(strpos($data, '\mr*')-$p1))));
//   $phrase = trim(str_replace($search,'',substr($data,$p1,(strpos($data, '\mr*')-$p1))));
   $data = substr($data,0,strpos($data,'\mr'))."<div class=\"mr\">".$phrase."</div>".substr($data,(strpos($data, '\mr*')+4)); 

   $r++; 
   if($r>5) {echo "<hr>".$data."<hr>"; break;}
  }
/*************************************************/

	if($tag=='s') {
		$s++;
		// php.ini will display error messages
		ini_set("display_errors", 0);
		
		if (empty($verseB)) {
			$text .= "<a name='".$chapter.":1'></a>";
			$subjects[$chapter.":1"] = $data;
		}
		else {
			$text .= "<a name='".$chapter.":".$verseB[0]."'></a>";
			$subjects[$chapter.":".$verseB[0]] = $data;
		}
		// php.ini will display error messages
		ini_set("display_errors", 1);
	}

	if($tag) {
		$text .= "<span class='$tag'>$data</span>";
	}  
 }
}
else {
	$text = translate('Book not available', $st, 'sys');
}

$chapter_options = '<span class="selectBoxTitle">'.translate('Select chapter', $st, 'sys').'</span> &nbsp&nbsp; ';
$chapterVerses = '0,';
foreach ($index as $chapter=>$verses) {
 $chapter_options .= "<a onclick=\"setChapter('".$chapter."');\">".$chapter."</a>&nbsp; ";
 $chapterVerses .= $verses.",";
}
$chapterVerses = rtrim($chapterVerses,",");

/*
$subject_options = '';
foreach($subjects as $s=>$subject) 
{$subject_options .= "<option value=\"".$s."\">".$subject;}

if(count($subjects)>0)
{
 $output .= "
<br />
<span class=\"selectTitle\">".translate('Subject', $st, 'sys')."</span>
<select class=\"subjectSelect\" id=\"subject\" name=\"subject\" onchange=\"setVerseLocation(this.value);\">
 ".$subject_options."
</select>
";
}
else {$ouput .= "<input id=\"subject\" name=\"subject\" type=\"hidden\">";}
<input id=\"subject\" name=\"subject\" type=\"hidden\">
*/

$output .= "
<input name=\"chapterVerses\" type=\"hidden\" value=\"".$chapterVerses."\">

<p />";

if ($rtl == 0) {
	$output .= "<div class=\"book\">".$text."</div>";
}
else {
	$output .= "<div class=\"book\" style=\"font-size: 150%; direction: rtl; \">".$text."</div>";
}

$output .= "</div>
";

echo $output;

?>