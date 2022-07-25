<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Bijbelse materialen in duizenden talen'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00d-Bijbel_Indice.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" 					content="
    Deze site geeft toegang tot de Bijbel (Heilige Schrift in het Oude Testament en Nieuwe Testament)
    in de tekst (PDF), audio (MP3), kijk (de Jezus film, enz.), kopen (print-on-demand),
    studie (The Word), andere boeken en links in de inheemse talen van Zuid-Amerika.
" />
<meta name="Keywords" 						content="
    moderne inheemse languagess, Amerika, hart taal, moedertaal, tekst, PDF, audio, MP3, horloge,
    Jezus film, kopen, print-on-demand, online kopen, boekhandel, studie, The Word, de Bijbel,
    Nieuwe Testament, NT, Oude Testament, OT
" />
<style type="text/css">
    /* this version of classes are for English only! */
    div.topBannerImage {
        background-image: url(images/00i-topBanerComp.png);
        height: 136px;
        text-align: right;
    }
</style>
<?php
// Start the session
session_start();
?>
<script type="text/javascript" language="javascript">
	var MajorLang = "Nld";
</script>
	<?php
        $st = 'nld';
        if (isset($_GET['st'])) {
            $st = $_GET['st'];
            $test = preg_match('/^[a-z]{3}/', $st);
            if ($test === 0) {
                die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
            }
        }
        
        $Variant_major = 'Variant_Dut';
        $MajorLanguage = "LN_Dutch";
        $SpecificCountry = "Dutch";
        $counterName = "Dutch";
        //$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
        $Scriptname = basename($_SERVER["SCRIPT_NAME"]);
        $FacebookCountry = "nl_NL";
        $MajorCountryAbbr = "nl";
        
        define ("OT_EngBook", 7);							// Dutch Bible book names
        define ("NT_EngBook", 7);
    
        include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
    ?>

</body>
</html>