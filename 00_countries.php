<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href='_css/CountryLangIndivlang-m.css' rel='stylesheet' type='text/css' />
</head>
	<body>
		<div class="gridContainer clearfix">
			<div id="div1" class="fluid">
            	<?PHP
					switch ($st) {
						case "eng":
								$MajorLanguage = "LN_English";
								$SpecificCountry = "countries.English";
								break;
						case "spa":
								$MajorLanguage = "LN_Spanish";
								$SpecificCountry = "countries.Spanish";
								break;
						case "por":
								$MajorLanguage = "LN_Portuguese";
								$SpecificCountry = "countries.Portuguese";
								break;
						case "fre":
								$MajorLanguage = "LN_French";
								$SpecificCountry = "countries.French";
								break;
						case "dut":
								$MajorLanguage = "LN_Dutch";
								$SpecificCountry = "countries.Dutch";
								break;
						default:
								echo 'This isn’t suppossed to happen (mobile - switch code). Spanish language is selected.';
								$st = "spa";										// Variables for the specific major languages
								$MajorLanguage = "LN_Spanish";
								$SpecificCountry = "countries.Spanish";
								$Scriptname = end(explode('/',$_SERVER['SCRIPT_NAME']));
								$counterName = "Spanish";
								$FacebookCountry = "es_MX";
								$MajorCountryAbbr = "es";
								define ("OT_EngBook", 3);							// Spanish Bible book names
								define ("NT_EngBook", 3);
								$MajorLanguage = "LN_Spanish";
								$SpecificCountry = "countries.Spanish";
					}
					/*
						*************************************************************************************
								Get the list of all countries to display.
						*************************************************************************************
					*/
					$query="SELECT DISTINCT $SpecificCountry, ISO_countries.ISO_countries FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO_ROD_index = scripture_main.ISO_ROD_index ORDER BY $SpecificCountry";
					$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
					$num=$result->num_rows;
					if ($result && $num > 0) {
						$countryTemp = $SpecificCountry;
						if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);					// In case there's a "." in the "country"
						while ($r = $result->fetch_array()) {
							$country=trim($r["$countryTemp"]);
							$country = str_replace(' ', '&nbsp;', $country); 
							$ISO_Country=$r['ISO_countries'];
							?>
							<p>
							<?php
							echo "<a class='country' href='$Scriptname?sortby=country&name=$ISO_Country' target='_top'>$country</a>";
							?>
							</p>
							<?php
						}
					}
					else {
						die (translate('The countries are not found.', $st, 'sys') . '</body></html>');
					}
				?>
            </div>
		</div>
	</body>
</html>
