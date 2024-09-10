<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Bijbelse materialen in duizenden talen'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00nld.php" />
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
<style>
    div.nld-header {
        /* Netherlands (Dutch) */
        background-image: url('./images/00nld-BackgroundFistPage.jpg');
    }
    ul.ulDutch {
        /*padding-left: 230px;*/
        /* use padding-left and width to make the words correct position */
        /*display: block;
        display: inline;*/
        text-align: center;
        font-size: .86em;
        font-weight: bold;
        /*margin-top: -180px;*/
        /*clear: both;*/
        margin-left: -40px;
    }
    @media only screen and (max-width: 480px) {
        /* (max-width: 412px) for Samsung S8+ 2/20/2019 */
        div.nld-header {
            background-position: center;
            position: relative;
            top: -54px;
        }
        div.nld-header {
            background-image: url('./images/00nld-BackgroundFistPage-mobile.jpg');
        }
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Nld";
    const Major_OT_array = ["Genesis", "Exodus", "Leviticus", "Numberi", "Deuteronomium", "Jozua", "Richtere", "Ruth", "1 Samuel", "2 Samuel", "1 Koningen", "2 Koningen", "1 Kronieken", "2 Kronieken", "Ezra", "Nehemia", "Esther", "Job", "Psalmen", "Spreuken", "Prediker", "Hooglied", "Jesaja", "Jeremia", "Klaagliederen", "Ezechiël", "Daniël", "Hosea", "Joël", "Amos", "Obadja", "Jona", "Micha", "Nahum", "Habakuk", "Zefanja", "Haggaï", "Zacharia", "Maleachi"];
    const Major_NT_array = ["Mattheüs", "Markus", "Lukas", "Johannes", "Handelingen", "Romeinen", "1 Corinthiërs", "2 Corinthiërs", "Galaten", "Efeziërs", "Filippenzen", "Colossenzen", "1 Thessalonicenzen", "2 Thessalonicenzen", "1 Timotheüs", "2 Timotheüs", "Titus", "Filémon", "Hebreeën", "Jakobus", "1 Petrus", "2 Petrus", "1 Johannes", "2 Johannes", "3 Johannes", "Judas", "Openbaring"];
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