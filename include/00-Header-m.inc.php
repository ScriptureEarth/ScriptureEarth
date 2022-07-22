<?php
?>
<div style="width: 100%; background-color: white; margin-bottom: 15px; height: 170px; ">
	<div style="margin-right: auto; margin-left: auto; text-align: center; cursor: pointer; " onClick="history.back();">
    	<?php
			switch ($st) {
				case "eng":
					echo '<img src="./images/00i-mobile-top-baner.jpg" />';
					break;
				case "spa":
					echo '<img src="./images/00e-mobile-top-baner.jpg" />';
					break;
				case "por":
					echo '<img src="./images/00p-mobile-top-baner.jpg" />';
					break;
				case "fre":
					echo '<img src="./images/00f-mobile-top-baner.jpg" />';
					break;
				case "dut":
					echo '<img src="./images/00d-mobile-top-baner.jpg" />';
					break;
				default:
					echo 'This isn’t suppossed to happen (mobile - switch code). Spanish language is selected.';
					echo '<img src="./images/00e-mobile-top-baner.jpg" />';
			}
		?>
	</div>
	<div style="display: inline; vertical-align: middle; color: #080860; font-weight: bold; ">
		<!-- Google search box -->
		<div class='googleSearch'>
			<form action="http://www.scriptureearth.org/results.htm" id="cse-search-box">
				<input type="hidden" name="cx" value="009521864724919836289:uld5pgdocle" />
				<input type="hidden" name="cof" value="FORID:10" />
				<input type="hidden" name="ie" value="UTF-8" />
				<input type="text" name="q" size="20" />
				<input type="submit" name="sa" value="<?php echo translate('Search', $st, 'sys') ?>" />
			</form>
			<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=<?php echo $MajorCountryAbbr; ?>"></script>
		</div>
	</div>
	<div id="manualTranslation">
		<form class="languageChoices">
        	<?php
				if (isset($_GET["sortby"]) && $_GET["sortby"] == "lang") {
					?>
					<select class="languageChoiceSelected" onchange="langSend(this, '<?php echo $ISO; ?>', '<?php echo $ROD_Code; ?>', '<?php echo $Variant_Code; ?>')">
					<?php
				}
				else if (!isset($_GET["sortby"])) {
					?>
					<select class="languageChoiceSelected" onchange="sendCountries_m(this)">
					<?php
				}
				else {		// isset($_GET["sortby"]) && $_GET["sortby"] == "country"
					?>
					<select class="languageChoiceSelected" onchange="sendCountry_m(this, '<?php echo $GetName; ?>')">
                    <?php
				}
				include './include/00-MajorLanguageChoiceSelected.inc.php';			// connect to the database named 'scripture'
				?>
			</select>
		</form>
	</div>
	<!-- http://translate.google.com/translate_tools -->
	<div id="google_translate_element"></div>
	<script>
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({
			pageLanguage: '<?php echo $MajorCountryAbbr; ?>'
		  }, 'google_translate_element');
		}
	</script>
	<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>
<?php
?>