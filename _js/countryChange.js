/*****************************************************************************************************************
	countryChange.js: fetch - allCountry.php (ChartTwo - pie), fetch - countryChange.php (<select> <option>)
*****************************************************************************************************************/

function countryChange(cChange, month, year) {								// change the country
 	const fullCountry = cChange.substring(0, (cChange.length)-3);
	const CCode = cChange.substring((cChange.length)-2);
	
	// Destroy exiting Chart.js instance to reuse <canvas> element.
	document.getElementById('barChartTwo').innerHTML = '&nbsp;';
	$('#barChartTwo').append('<canvas id="ChartTwo"><canvas>');
	
	document.getElementById('barChartISO').innerHTML = '&nbsp;';
	$('#barChartISO').append('<canvas id="ChartISO"><canvas>');

	document.getElementById("idCountry").innerHTML = "";

    //let Scriptname = window.location.href;
    //Scriptname = Scriptname.substr(0, Scriptname.indexOf('?'));     		// my computer localhost? Not used yet.

    /****************************************************************************************************************
    	fetch - allCountry.php
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseAllCountry = await fetch("allCountry.php?cc="+CCode+"&m="+month+"&y="+year);
			const textAllCountry = await responseAllCountry.text();
console.log(textAllCountry);
			if (textAllCountry == "@none" || textAllCountry == "none") {
				const elem = document.getElementById("idCountry");
				elem.innerHTML = "No country was found."; 
			}
			else {
				let onlyTwo = 0;
				let resultsTwo = [];
				let resultsTwoLength = 0;
				
				const tempArray = textAllCountry.split("@");
				let results = JSON.parse(tempArray[0]);						// parse string into JSON array
				let resultsLength = Object.keys(results).length;
				
				let xValues = [];
				let yValues = [];
				
				let extension = '';
				let numOfHits = '';
				
				let description = '';
				let extensionTwo = '';
				let sumView = 0;
				
				if (tempArray[1] !== undefined) {							// if tempArray[1] does not exist
					resultsTwo = JSON.parse(tempArray[1]);					// parse string into JSON array
					resultsTwoLength = Object.keys(resultsTwo).length;
					onlyTwo = 1;
				}
				
				// m = month
				// y = year
				
				const barColors = [
					"#b91d47",
					"#00aba9",
					"#2b5797",
					"#e8c3b9",
					"#1e7145",
					"#ffadad",
					"#ffd6a5",
					"#fdffb6",
					"#caffbf",
					"#9bf6ff",
					"#a0c4ff",
					"#bdb2ff",
					"#ffc6ff"
				];
				
				//const xValues = ["Italy", "France", "Spain", "USA", "Argentina", "UK"];
				//const yValues = [55, 49, 44, 24, 15, 9];
				for (let i in results) {
					extension = results[i]['extension'];
					if (extension.trim() == '') {
						continue;
					}
					numOfHits = results[i]['numOfHits'];
					//numOfBandwidth = results[i]['numOfBandwidth'];
					switch(extension) {
						case 'htm':
							description = 'SE.org map file';
							break;
						case 'pdf':
							description = 'PDF file';
							break;
						case 'txt':
							description = 'Playlist (audio/video) file';
							break;
						case 'apk':
							description = 'Android app';
							break;
						case 'srt':
							description = 'Subtitles for video file';
							break;
						case 'mp3':
						case 'pkf':
							description = 'Audio file';
							break;
						case 'mp4':
							description = 'Video file';
							break;
						case 'sfm':
							description = 'Standard Format Marker (viewer)';
							break;
						case 'exe':
							description = 'theWord app download';
							break;
						case 'twm':
						case 'ont':
						case 'ot':
						case 'nt':
						case 'ontx':
						case 'otx':
						case 'ntx':
						case 'twzip':
							description = 'theWord app download';
							break;
						case 'jad':
							description = 'MySword (Android) app download';
							break;
						case 'jar':
							description = 'GoBible (Java) app download';
							break;
						case 'map':
							description = 'Progressive web apps (PWAs) file';
							break;
						case '3gp':
							description = 'Audio file';
							break;
						default:
					}
					extension = description + ' (' + extension + ')';
					xValues.push(extension);
					yValues.push(numOfHits);
				}
				if (onlyTwo == 1) {
					for (let i in resultsTwo) {
						extensionTwo = resultsTwo[i]['extension'];
						sumView = resultsTwo[i]['sumView'];
						extensionTwo = 'Only Read/Listen/View' + ' (' + extensionTwo + ')';
						xValues.push(extensionTwo);
						yValues.push(sumView);
					}
				}
				
				new Chart("ChartTwo", {
					type: "pie",
					data: {
						labels: xValues,
						datasets: [{
							backgroundColor: barColors,
							data: yValues
						}]
					},
					options: {
						plugins: {
							title: {
								display: true,
								text: fullCountry,
								color: 'white',
								font: {
									family: 'Arial',
									size: 24,      
									style: 'normal',
									weight: 'normal',  
									lineHeight: 1.2 
								}
							},
							legend: {
								display: true,
								position: 'right',
								labels: {
									color: 'white',
									font: {
										size: 13
									}
								}
							}
						}
					}
				});
			}
		}
		catch (error) {
			console.log(error);
		}
	} ) ();	
	
    /****************************************************************************************************************
    	fetch - countryChange.php
    ****************************************************************************************************************/
    (async function () {
		let url = "countryChange.php?cc=" + CCode + "&m=" + month + "&y=" + year;
		try {
			const responseCountryChange = await fetch(url);
			const results = await responseCountryChange.json();
			if (results == "none") {
				document.getElementById("idISO").innerHTML = "No ISOs were found for " + month.toString() + "/" + year.toString() + "."; 
			}
			else {
				//let resultsLength = Object.keys(results).length;
				// country = full country
				// CCode = country code
				// m = month
				// y = year
				
				let iso = "";
				let rod = "";
				let variant = "";
				let idx = "";
				let LN = "";
				let para = '<select id="iso" onchange="isoChange(document.getElementById(\'iso\').options[document.getElementById(\'iso\').selectedIndex].value, '+month+', '+year+')"><br />';

				para = para + "<option value='Choose a language...' selected='selected'>Choose a language...</option><br />";
				for (let i in results) {
					iso = results[i]['iso'];
					rod = results[i]['rod'];
					variant = results[i]['var'];
					idx = results[i]['idx'];
					LN = results[i]['LN'];
					para = para + "<option value='" + LN + ':' + idx + ' ' + iso + ' ' + rod + ' ' + variant + "'>" + LN + ' [' + iso + '] (' + rod + ') ' + variant + '</option>';
				}

				para = para + '</select>';

				document.getElementById("idISO").innerHTML = para;
			}
        }
		catch (error) {
			console.log(error);
		}
	} ) ();	
}
