// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025

// first js!

// yearMonthChange(year, month)
// isoChange(langData, month, year)

/*****************************************************************************************************************
	yearMonthChange.js:
					    => fecth - selectCountries.php (<select> <option>)
					    => fetch - yearMonthChange.php (ChartFileType (pie))
					    => fetch - localesChange.php (ChartLocales (bar))
*****************************************************************************************************************/
function yearMonthChange(year, month) {										// change the year/month
	// Destroy exiting Chart.js instance to reuse <canvas> element.
	let pieFileType = document.getElementById('pieChartFileType');			// <!-- pie -->
	pieFileType.innerHTML = "";
	$('#pieChartFileType').append('<canvas id="ChartFileType"><canvas>');

	let barLocales = document.getElementById("barChartLocales");			// <!-- bar -->
	barLocales.innerHTML = "";
	$('#barChartLocales').append('<canvas id="ChartLocales"><canvas>');
	
	let barTwo = document.getElementById("barChartTwo");					// <!-- pie -->
	barTwo.innerHTML = "";
	$('#barChartTwo').append('<canvas id="ChartTwo"><canvas>');

	let barOne = document.getElementById("barChartISO");					// <!-- pie -->
	barOne.innerHTML = "";
	$('#barChartISO').append('<canvas id="ChartISO"><canvas>');
	
	document.getElementById("idCountry").innerHTML = "";
	
	document.getElementById("idISO").innerHTML = "";
	
	const elem = document.getElementById("firstLine");
	elem.innerHTML = "";

  	const sLine = document.getElementById("selectLine");
	sLine.innerHTML = "";

	if (year == "Choose a year...") {
		return;
	}
	if (month == "Choose a month...") {
		return;
	}
	if (month == 13) {														// Year
	}
	else {
		if (year == 2020 && month < 8) {
			alert("The InMotion Hosting server for SE.org has no dates before August, 2020.");
			return;
		}
		/*
			JavaScript:
				new Date().getFullYear()      // Get the four digit year (yyyy)
				new Date().getMonth()         // Get the month (0-11)
				new Date().getDate()          // Get the day as a number (1-31)
				new Date().getDay()           // Get the weekday as a number (0-6)
				new Date().getHours()         // Get the hour (0-23)
				new Date().getMinutes()       // Get the minutes (0-59)
				new Date().getSeconds()       // Get the seconds (0-59)
				new Date().getMilliseconds()  // Get the milliseconds (0-999)
				new Date().getTime()          // Get the time (milliseconds since January 1, 1970)
			
			PHP: date("year/month/day]", date("l jS \of F Y h:i:s A"), etc.):
				Y - A four digit representation of a year
				m - A numeric representation of a month (from 01 to 12)
				M - A short textual representation of a month (three letters)
				n - A numeric representation of a month, without leading zeros (1 to 12)
				d - The day of the month (from 01 to 31)
				D - A textual representation of a day (three letters)
				j - The day of the month without leading zeros (1 to 31)
				l (lowercase 'L') - A full textual representation of a day
				
			JavaScript is PHP minus 1!!!!! So,
				PHP code:
					$formatted_date = $newticket['DateCreated'] = date('Y/m/d H:i:s');
				Javascript code:
					var javascript_date = new Date("<?php echo $formatted_date; ?>");
		*/
		let dateTime = new Date();
		if (year > dateTime.getFullYear()) {
			alert("The InMotion Hosting server for SE.org can't go beyond "+year+".");
			return;
		}
		if (year == dateTime.getFullYear() && (month - 1) == -1) {
			alert("The InMotion Hosting server for SE.org can't go beyond December, "+year-1+".");
			return;
		}
		else if (year == dateTime.getFullYear() && dateTime.month > (month - 2)) {			// PHP and JS months!!
			alert("The InMotion Hosting server for SE.org can't go beyond "+month+".");
			return;
		}
	}
	
    /****************************************************************************************************************
    	fecth - selectCountries.php => <select> <option>
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseOne = await fetch("selectCountries.php?m="+month+"&y="+year);
			const jsonOne = await responseOne.text();
			if (jsonOne == "none") {
				sLine.innerHTML = "No " + month.toString() + "/" + year.toString() + " were found."; 
			}
			else {
				let result = jsonOne;
				let results = result.split('|');
				let para = '<select id="countries" onchange="countryChange(document.getElementById(\'countries\').options[document.getElementById(\'countries\').selectedIndex].value, '+month+', '+year+')">';
				para = para + "<option value='Choose a country...' selected='selected'>Choose a country...</option>";
				let fields = [];
				let field = [];
				for (let items of results.values()) {
					fields = items.split("^");
					//field = fields.values();
					//country = fields[0];
					//countryCode = fields[1];
					para = para + "<option value='" + fields[0] + ' ' + fields[1] + "'>" + fields[0] + "</option>";
				}
				para = para + '</select>';
				sLine.innerHTML = para;
			}
		}
		catch (error) {
			console.log(error);
		}
	} ) ();

    /****************************************************************************************************************
    	fetch - yearMonthChange.php => ChartFileType (pie) (unique visitors, number of visits, pages) & ChartTwo (bar)
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
		alert("Fetching yearMonthChange.php...");
		alert(month + ' ' + year);
			const responseTwo = await fetch("yearMonthChange.php?m="+month+"&y="+year);
		alert("2 Fetching yearMonthChange.php...");
			const jsonTwo = await responseTwo.text();
			if (jsonTwo == "@none") {
				const elem = document.getElementById("firstLine");
				elem.innerHTML = "No " + month.toString() + "/" + year.toString() + " were found."; 
			}
			else {
				let onlyTwo = 0;
				let resultsTwo;
				let resultsTwoLength = 0;
				
				const tempArray = jsonTwo.split("@");
				let results = JSON.parse(tempArray[0]);						// parse string into JSON array
				let resultsLength = Object.keys(results).length;
				
				if (tempArray[1] !== undefined) {							// if tempArray[1] does not exist
					resultsTwo = JSON.parse(tempArray[1]);					// parse string into JSON array
					resultsTwoLength = Object.keys(resultsTwo).length;
					onlyTwo = 1;
				}
				
				const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

				uniqueVisitors = results[0]['uniqueVisitors'];
				numberOfVisits = results[0]['numberOfVisits'];
				pages = results[0]['pages'];
				let temp = pages/numberOfVisits;
				temp = temp.toLocaleString('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1, });
				let para = '<div class="lineOne" style="text-align: center; margin-left: auto; margin-right: auto; width: 100%; font-size: 14pt; ">';
				if (month == 13) {
					para = para + '<table style="border: 1px solid green; margin-bottom: 10px; text-align: center; margin-left: auto; margin-right: auto; width: 70%; "><thead><tr style="background-color: orange; color: white; font-size: 20pt; "><th colspan="4">' + year.toString()+' (this year)</th></tr></thead><tbody><tr style="background-color: gray; "><td style="width: 25%; ">Visitors</td><td>Number of Visits</td><td>Pages</td><td>Average number of pages per visit</td></tr>';
				}
				else {
					para = para + '<table style="border: 1px solid green; margin-bottom: 10px; text-align: center; margin-left: auto; margin-right: auto; width: 70%; "><thead><tr style="background-color: orange; color: white; font-size: 20pt; "><th colspan="4">' + monthNames[month-1] + ', ' + year.toString()+' (only this month)</th></tr></thead><tbody><tr style="background-color: gray; "><td style="width: 25%; ">Visitors</td><td>Number of Visits</td><td>Pages</td><td>Average number of pages per visit</td></tr>';
				}
				para = para + '<tr><td>'+uniqueVisitors.toLocaleString()+'</td><td>'+numberOfVisits.toLocaleString()+'</td><td>'+pages.toLocaleString()+'</td><td>'+temp+'</td></tr></tbody></table>';
				para = para + '</div>';
				elem.innerHTML = para;
				
				// resultsTwo
				let fileType = '';
				let description = '';
				let fTD = '';
				let hits = 0;
				
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
				let xValuesTwo = [];
				let yValuesTwo = [];
				for (let i in resultsTwo) {
					fileType = resultsTwo[i]['fileType'];
					description = resultsTwo[i]['description'];
					hits = resultsTwo[i]['hits'];
					switch(fileType) {
						case 'html':
							description = 'SAB HTML (PWA) Read/Listen/View';
							break;
						case 'htm':
							description = 'SE.org map files';
							break;
						case 'pdf':
							description = 'PDF files';
							break;
						case 'txt':
							description = 'SAB HTML (PWA) and Playlist (audio/video) files';
							break;
						case 'apk':
							description = 'Android app files';
							break;
						case 'srt':
							description = 'Subtitles for video files';
							break;
						case 'mp3':
						case 'pkf':
							description = 'Audio files';
							break;
						case 'mp4':
							description = 'Video files';
							break;
						case 'sfm':
							description = 'Standard Format Marker (Viewer)';
							break;
						case 'usfm':
							description = 'Unified Standard Format Marker (Viewer)';
							break;
						case 'exe':
							description = 'theWord app downloads';
							break;
						case 'twm':
						case 'ont':
						case 'ot':
						case 'nt':
						case 'ontx':
						case 'otx':
						case 'ntx':
						case 'twzip':
							description = 'theWord app downloads';
							break;
						case 'jad':
							description = 'MySword (Android) app downloads';
							break;
						case 'jar':
							description = 'GoBible (Java) app downloads';
							break;
						case 'map':
							description = 'Progressive web apps (PWAs) files';
							break;
						case '3gp':
							description = 'Audio files';
							break;
						case 'wasm':
							description = 'WebAssembly codes';
							break;
						default:
					}
					fTD = description + ' (' + fileType + ')';
					xValuesTwo.push(fTD);
					yValuesTwo.push(hits);
				}

				new Chart("ChartFileType", {
					type: "pie", 	 							/* doughnut */
					data: {
						labels: xValuesTwo,
						datasets: [{
							backgroundColor: barColors,
							// label: '# of votes',
							data: yValuesTwo
						}]
					},
					options: {
						plugins: {
							title: {
								display: true,
								text: 'File Types (extensions)',
								color: 'white',
								font: {
									family: 'Arial',
									size: 20,      
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
    	fetch - localesChange.phpp?m="+month+"&y="+year
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
	// locales, lPages, lBandwidth
	let locales = '';
	let pages = 0;
	let bandwidth = 0;

    (async function () {
		try {
			const responseThree = await fetch("localesChange.php?m="+month+"&y="+year);
			const jsonThree = await responseThree.json();
			if (jsonThree == "none") {
				const felem = document.getElementById("idCountry");
				felem.innerHTML = "No country was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
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
				let xValuesThree = [];
				let yValuesPages = [];
				let yValuesBandwidth = [];
				for (let i in jsonThree) {
					locales = jsonThree[i]['locales'];
					pages = jsonThree[i]['pages'];
					bandwidth = jsonThree[i]['bandwidth'];
					xValuesThree.push(locales);
					yValuesPages.push(pages);
					yValuesBandwidth.push(bandwidth);
				}
				
				Chart.defaults.color = 'white';							// color of axeses
				new Chart("ChartLocales", {
					type: "bar",
					data: {
						labels: xValuesThree,
						color: 'white',
						datasets: [
							{
								label: 'Pages',
								backgroundColor: ["#ff9999"],
								data: yValuesPages,
								borderWidth: 1
							},
							{
								label: 'Bandwidth',
								backgroundColor: ["#00aba9"],
								data: yValuesBandwidth,
								borderWidth: 1
							}
						]
					},
					options: {
						plugins: {
							title: {
							  display: true,
							  position: "top",
							  text: "Countries",
							  color: "white",							// color of title
							  font: {
								  size: 22
							  }
							},
							legend: {
								display: true,
								labels: {
									fontColor: "white",
									color: "white",						// color of labels
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
}
	

/*****************************************************************************************************************
	yearMonthChange.js => fetch - isoChange.php?i=[langArray[1]]&m=MM&y=YYYY
*****************************************************************************************************************/
function isoChange(langData, month, year) {
	// Destroy exiting Chart.js instance to reuse <canvas> element.
	let barOne = document.getElementById('barChartISO');
	barOne.innerHTML = '&nbsp;';
	$('#barChartISO').append('<canvas id="ChartISO"><canvas>');
		
	// Destroy exiting Chart.js instance to reuse <canvas> element.
	//var barTwo = document.getElementById('barChartTwo');
	//barTwo.innerHTML = '&nbsp;';
	//$('#barChartTwo').append('<canvas id="ChartTwo"><canvas>');
	
	if (langData == 'Choose a language...') {
		return;
	}
	
	//const elem = document.getElementById("idISO");
	//elem.innerHTML = "";
	
	let LN = "";
	let idx = "";
	let iso = "";
	let rod = "";
	let variant = "";
	
	let langArray = langData.split(":");									// langData = LN + ':' + idx + ' ' + iso + ' ' + rod + ' ' + variant
	LN = langArray[0];
	let isoArray = langArray[1].split(" ");
	idx = isoArray[0];
	iso = isoArray[1];
	rod = isoArray[2];
	if (isoArray.length == 4) {
		variant = isoArray[3];
	}

    /****************************************************************************************************************
    	fetch - isoChange.php?i="+langArray[1]+"&m="+month+"&y="+year)
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseTwo = await fetch("isoChange.php?i="+langArray[1]+"&m="+month+"&y="+year);
			const textTwo = await responseTwo.text();
			if (textTwo == "none") {
				//const elem = document.getElementById("");
				//elem.innerHTML = "No ISO were found for " + month.toString() + "/" + year.toString() + ".";
			}
			else {
				let onlyTwo = 0;
				let resultsTwo;
				let resultsTwoLength = 0;
				
				const tempArray = textTwo.split("@");
				let results = JSON.parse(tempArray[0]);						// parse string into JSON array
				let resultsLength = Object.keys(results).length;
				
				if (tempArray[1] !== undefined) {							// if tempArray[1] does not exist
					resultsTwo = JSON.parse(tempArray[1]);					// parse string into JSON array
					resultsTwoLength = Object.keys(resultsTwo).length;
					onlyTwo = 1;
				}
				
				// langArray[1] = idx, iso, rod, var
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
				let xValues = [];
				let yValues = [];
				let description = '';
				for (let i in results) {
					extension = results[i]['extension'];
					numOfHits = results[i]['numOfHits'];
					//numOfBandwidth = results[i]['numOfBandwidth'];
					switch(extension) {
						case 'htm':
							description = 'SE.org map files';
							break;
						case 'pdf':
							description = 'PDF files';
							break;
						case 'txt':
							description = 'Playlist (audio/video) files';
							break;
						case 'txt|':
							extension = 'txt';
							description = 'SAB HTML (PWA) Read/Listen/View';
							break;
						case 'apk':
							description = 'Android app files';
							break;
						case 'srt':
							description = 'Subtitles for video files';
							break;
						case 'mp3':
						case 'pkf':
							description = 'Audio files';
							break;
						case 'mp4':
							description = 'Video files';
							break;
						case 'sfm':
							description = 'Standard Format Marker (Viewer)';
							break;
						case 'usfm':
							description = 'Unified Standard Format Marker (Viewer)';
							break;
						case 'exe':
							description = 'theWord app downloads';
							break;
						case 'twm':
						case 'ont':
						case 'ot':
						case 'nt':
						case 'ontx':
						case 'otx':
						case 'ntx':
						case 'twzip':
							description = 'theWord app downloads';
							break;
						case 'jad':
							description = 'MySword (Android) app downloads';
							break;
						case 'jar':
							description = 'GoBible (Java) app downloads';
							break;
						case 'map':
							description = 'Progressive web app (PWA) files';
							break;
						case '3gp':
							description = 'Audio files';
							break;
						case 'wasm':
							description = 'WebAssembly codes';
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
						extensionTwo = 'SAB HTML (PWA) Read/Listen/View (' + extensionTwo + ')';
						xValues.push(extensionTwo);
						yValues.push(sumView);
					}
				}
				
				new Chart("ChartISO", {
					type: "pie", 	 							/* doughnut */
					data: {
						labels: xValues,
						datasets: [{
							backgroundColor: barColors,
							data: yValues
						}]
					},
					/*options: {
						legend: {display: false},
						title: {
							display: true,
							text: LN + " Language"
						}
					}*/
					options: {
						plugins: {
							title: {
								display: true,
								text: LN + " Language",
								color: 'white',
								font: {
									family: 'Arial',
									size: 20,      
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
}