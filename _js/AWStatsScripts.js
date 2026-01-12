// Called from AWStatsView.php: AWStatsScripts.js

// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025

/*****************************************************************************************************************
	AWStatsScripts.js:
		function yearMonthChange(year, month):
				=> fetch - selectCountries.php => 'Choose a country...'
				=> fetches - yearMonthChange.php (ChartFileType (pie)) (returns text: unique visitors, number of visits, pages) and
					localesChange.php (ChartLocales (bar)) (returns monthly or yearly data: pages and bandwidth)
			initially hidden => buttonMenu.style.display = "none";
				=> fetch - AWStatsSections.php?s=1 (ChartBrowsers (bar))
				=> fetch - AWStatsSections.php?s=2 (ChartDurations (bar))
				=> fetch - AWStatsSections.php?s=3 (ChartIPs (bar))
				=> fetch - AWStatsSections.php?s=4 (ChartOSs (bar))

		function isoChange(langData [LN and ISO], month, year):
				=> fetch - isoChange.php("+iso+"&m="+month+"&y="+year)) => ChartISO (pie)
				Returns JSON file for a specific language/ISO code within a selected country.
*****************************************************************************************************************/

function yearMonthChange(year, month) {										// change the year/month
	// Destroy exiting Chart.js instance to reuse <canvas> element.

	let pieFileType = document.getElementById('pieChartFileType');			// <!-- pie -->
	pieFileType.innerHTML = '';
	$('#pieChartFileType').append('<canvas id="ChartFileType"><canvas>');	// add <canvas> element for ChartFileType

	let barLocales = document.getElementById("barChartLocales");			// <!-- bar -->
	barLocales.innerHTML = '';
	$('#barChartLocales').append('<canvas id="ChartLocales"><canvas>');		// add <canvas> element for ChartLocales
	
	let barTwo = document.getElementById("barChartTwo");					// <!-- pie -->
	barTwo.innerHTML = '';
	$('#barChartTwo').append('<canvas id="ChartTwo"><canvas>');				// add <canvas> element for ChartTwo

	let barOne = document.getElementById("barChartISO");					// <!-- pie -->
	barOne.innerHTML = '';
	$('#barChartISO').append('<canvas id="ChartISO"><canvas>');				// add <canvas> element for ChartISO

	let bowser = document.getElementById("browsersLines");					// <!-- bar -->
	bowser.innerHTML = '<div id="browsersLinesContent"></div>';
	$('#browsersLines').append('<canvas id="ChartBrowsers"></canvas>');		// add <canvas> element for ChartBrowsers

	let duration = document.getElementById("durationLines");				// <!-- bar -->
	duration.innerHTML = '<div id="durationLinesContent"></div>';
	$('#durationLines').append('<canvas id="ChartDurations"></canvas>');	// add <canvas> element for ChartDurations

	let ip = document.getElementById("ipLines");							// <!-- bar -->
	ip.innerHTML = '<div id="ipLinesContent"></div>';
	$('#ipLines').append('<canvas id="ChartIPs"></canvas>');				// add <canvas> element for ChartIPs

	let os = document.getElementById("osLines");							// <!-- bar -->
	os.innerHTML = '<div id="osLinesContent"></div>';
	$('#osLines').append('<canvas id="ChartOSs"></canvas>');				// add <canvas> element for ChartOSs

	document.getElementById("idCountry").innerHTML = "";
	
	document.getElementById("idISO").innerHTML = "";
	
	const elem = document.getElementById("firstLine");
	elem.innerHTML = "";

  	const sLine = document.getElementById("selectLine");
	sLine.innerHTML = "";

	// end of destroying existing charts
//alert("Year/Month change to " + month.toString() + "/" + year.toString());
	if (year.toString() == "Choose a year...") {
		return;
	}
	if (month.toString() == "Choose a month...") {
		return;
	}
	if (month == 13) {														// whole year
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

		let date1 = new Date(month+'/1/'+year);
		let dateYear1 = date1.getFullYear();
		let dateMonth1 = date1.getMonth();

		let date2 = new Date();														// current date
		let dateYear2 = date2.getFullYear();
		//date2.setMonth(date2.getMonth() - 1);										// set to previous month
		let dateMonth2 = date2.getMonth();

		//alert("Checking date: " + dateMonth1 + '/' + dateYear1 + ' vs. ' + dateMonth2 + '/' + dateYear2);

		if (dateYear1 < dateYear2) {
			console.log("year: do it");
			}
		else if ((dateYear1 == dateYear2) && (dateMonth1 < dateMonth2)) {
			console.log("month: do it");
		} 
		else {
			console.log(`do not do it`);
			date2.setMonth(date2.getMonth() - 1);									// set to previous month
			let tempMonth = date2.getMonth() + 1;									// set month to previous month
			let tempYear = date2.getFullYear();										// set year to current year
			alert("The InMotion Hosting server for SE.org can't go beyond "+tempMonth+"/"+tempYear+".");
			return;
		}
	}
	
	let buttonMenu = document.getElementById("buttonMenu");
	buttonMenu.style.display = "block";

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
				const sLine = document.getElementById("firstLine");
				sLine.innerHTML = "No " + month.toString() + "/" + year.toString() + " were found."; 
			}
			else {
				let result = jsonOne;
				let results = result.split('|');
				let para = '<select id="countries" onchange="countryChange(document.getElementById(\'countries\').options[document.getElementById(\'countries\').selectedIndex].value, '+month+', '+year+')">';
				para = para + "<option value='Choose a country...' selected='selected'>Choose a country...</option>";
				let fields = [];
				//let field = [];
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
			const sLine = document.getElementById("firstLine");
			sLine.innerHTML = "No " + month.toString() + "/" + year.toString() + " were found."; 
		}
	} ) ();

    /****************************************************************************************************************
    	fetch - yearMonthChange.php => ChartFileType (pie) (unique visitors, number of visits, pages) and
			 localesChange.php => ChartTwo (bar) (monthly or yearly data: pages and bandwidth)
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
		//alert("Fetching yearMonthChange.php...");
		//alert(month + ' ' + year);
			const responseTwo = await fetch("yearMonthChange.php?m="+month+"&y="+year);
		//alert("2 Fetching yearMonthChange.php...");
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
				//let resultsLength = Object.keys(results).length;
				
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
					para = para + '<table style="border: 1px solid brown; margin-bottom: 10px; text-align: center; margin-left: auto; margin-right: auto; width: 70%; "><thead><tr style="background-color: brown; color: white; font-size: 20pt; "><th colspan="4" style="padding-top: 20px; padding-bottom: 20px;">' + year.toString()+' (this year)</th></tr></thead><tbody><tr style="background-color: gray; "><td style="padding-top: 10px; padding-bottom: 10px; width: 25%; ">Visitors</td><td>Number of Visits</td><td>Pages</td><td>Average number of pages per visit</td></tr>';
				}
				else {
					para = para + '<table style="border: 1px solid brown; margin-bottom: 10px; text-align: center; margin-left: auto; margin-right: auto; width: 70%; "><thead><tr style="background-color: brown; color: white; font-size: 20pt; "><th colspan="4" style="padding-top: 20px; padding-bottom: 20px;">' + monthNames[month-1] + ', ' + year.toString()+' (only this month)</th></tr></thead><tbody><tr style="background-color: gray; "><td style="padding-top: 10px; padding-bottom: 10px; width: 25%; ">Visitors</td><td>Number of Visits</td><td>Pages</td><td>Average number of pages per visit</td></tr>';
				}
				para = para + '<tr style=""><td style="padding-top: 10px; padding-bottom: 10px; ">'+uniqueVisitors.toLocaleString()+'</td><td>'+numberOfVisits.toLocaleString()+'</td><td>'+pages.toLocaleString()+'</td><td>'+temp+'</td></tr></tbody></table>';
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
			const elem = document.getElementById("firstLine");
			elem.innerHTML = "No " + month.toString() + "/" + year.toString() + " were found."; 
		}
	} ) ();

    /****************************************************************************************************************
    	fetch - localesChange.php?m="+month+"&y="+year (returns monthly or yearly data: pages and bandwidth)	bar chart
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseThree = await fetch("localesChange.php?m="+month+"&y="+year);
			const jsonThree = await responseThree.json();
			if (jsonThree == "none") {
				const felem = document.getElementById("idCountryError");
				felem.innerHTML = "No country was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
			// locales, lPages, lBandwidth
			let locales = '';
			let pages = 0;
			let bandwidth = 0;
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
			const felem = document.getElementById("idCountryError");
			felem.innerHTML = "No country was found.";
		}
	} ) ();

    /****************************************************************************************************************
	 	browsers
			fetch - AWStatsSections.php?s=1&m="+month+"&y="+year		bar chart
	
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
	(async function () {
		try {
			const responseBrowser = await fetch("AWStatsSections.php?s=1&m="+month+"&y="+year);
			const jsonBrowser = await responseBrowser.json();
			if (jsonBrowser == "none") {
				const belem = document.getElementById("browsersLinesContent");
				belem.innerHTML = "No browser was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
				let browser = '';
				let bPages = 0;
				let pBPercent = '';
				//let bHits = 0;
				//let hBPercent = '';
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
				
				let xValuesBrowser = [];
				let yValuesbPages = [];
				let yValuespBPercent = [];
				//let yValuesbHits = [];	
				//let yValueshBPercent = [];
				for (let i in jsonBrowser) {
					browser = jsonBrowser[i]['browser'];
					bPages = jsonBrowser[i]['pages'];					// browser table ORDER BY number of pages
					pBPercent = jsonBrowser[i]['percent'];				// percentage of bPages. this should a number with % sign
					//bHits = jsonBrowser[i]['bHits'];
					//hBPercent = jsonBrowser[i]['hBPercent'];
					xValuesBrowser.push(browser);
					yValuesbPages.push(bPages);
					yValuespBPercent.push(parseFloat(pBPercent));		// convert string to float number. The string has  " %" at the end.
					//yValuesbHits.push(bHits);
					//yValueshBPercent.push(hBPercent);
				}
				
				Chart.defaults.color = 'white';							// color of axeses
				new Chart("ChartBrowsers", {
					type: "bar",
					data: {
						labels: xValuesBrowser,
						color: 'white',
						datasets: [
							{
								label: 'Pages',
								backgroundColor: ["#ff9999"],
								data: yValuesbPages,
								borderWidth: 1
							},
							{
								label: 'Precentage of Pages (%)',
								backgroundColor: ["#00aba9"],
								data: yValuespBPercent,
								borderWidth: 1
							}
						]
					},
					options: {
						plugins: {
							title: {
							  display: true,
							  position: "top",
							  text: "Browsers",
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
			const belem = document.getElementById("browsersLinesContent");
			belem.innerHTML = "No browser was found.";
		}
	} ) ();

    /****************************************************************************************************************
	 	durations
			fetch - AWStatsSections.php?s=2&m="+month+"&y="+year
	
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
	(async function () {
		try {
			const responseDuration = await fetch("AWStatsSections.php?s=2&m="+month+"&y="+year);
			const jsonDuration = await responseDuration.json();
			if (jsonDuration == "none") {
				const delem = document.getElementById("durationsLinesContent");
				delem.innerHTML = "No duration was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
				let zeroSecThirtySeconds = 0;
				let thirtyOneSecOneMinutes = 0;
				let oneMinFiveMinutes = 0;
				let fiveMinFifteenMinutes = 0;
				let fifteenMinThirtyMininues = 0;
				let thirtyMinOneHour = 0;
				let oneHourPlus = 0;
				let zeroSecThirtySecPrecent = '';
				let thirtyOneSecOneMinPrecent = '';
				let oneMinFiveMinPrecent = '';
				let fiveMinFifteenMinPrecent = '';
				let fifteenMinThirtyMinPrecent = '';
				let thirtyMinOneHourPrecent = '';
				let oneHourPlusPrecent = '';

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
				
				let xValuesDuration = [];
				xValuesDuration.push("0-30 Seconds");
				xValuesDuration.push("31 Seconds-1 Minute");
				xValuesDuration.push("1-5 Minutes");
				xValuesDuration.push("5-15 Minutes");
				xValuesDuration.push("15-30 Minutes");
				xValuesDuration.push("30 Minutes-1 Hour");
				xValuesDuration.push("1-Plus Hours");
				let yValuesTime = [];
				let yValuesPercent = [];

				for (let i in jsonDuration) {
					zeroSecThirtySeconds = jsonDuration[i]['zeroSecThirtySec'];
					zeroSecThirtySecPrecent = jsonDuration[i]['zeroSecThirtySecPre'];	// browser table ORDER BY number of pages
					thirtyOneSecOneMinutes = jsonDuration[i]['thirtyOneSecOneMin'];
					thirtyOneSecOneMinPrecent = jsonDuration[i]['thirtyOneSecOneMinPre'];
					oneMinFiveMinutes = jsonDuration[i]['oneMinFiveMin'];
					oneMinFiveMinPrecent = jsonDuration[i]['oneMinFiveMinPre'];
					fiveMinFifteenMinutes = jsonDuration[i]['fiveMinFifteenMin'];
					fiveMinFifteenMinPrecent = jsonDuration[i]['fiveMinFifteenMinPre'];
					fifteenMinThirtyMininues = jsonDuration[i]['fifteenMinThirtyMin'];
					fifteenMinThirtyMinPrecent = jsonDuration[i]['fifteenMinThirtyMinPre'];
					thirtyMinOneHour = jsonDuration[i]['thirtyMinOneHour'];
					thirtyMinOneHourPrecent = jsonDuration[i]['thirtyMinOneHourPre'];
					oneHourPlus = jsonDuration[i]['oneHourPlus'];
					oneHourPlusPrecent = jsonDuration[i]['oneHourPlusPre'];

					yValuesTime.push(zeroSecThirtySeconds);
					yValuesPercent.push(parseFloat(zeroSecThirtySecPrecent));			// convert string to float number. The string has  " %" at the end.
					yValuesTime.push(thirtyOneSecOneMinutes);
					yValuesPercent.push(parseFloat(thirtyOneSecOneMinPrecent));
					yValuesTime.push(oneMinFiveMinutes);
					yValuesPercent.push(parseFloat(oneMinFiveMinPrecent));
					yValuesTime.push(fiveMinFifteenMinutes);
					yValuesPercent.push(parseFloat(fiveMinFifteenMinPrecent));
					yValuesTime.push(fifteenMinThirtyMininues);
					yValuesPercent.push(parseFloat(fifteenMinThirtyMinPrecent));
					yValuesTime.push(thirtyMinOneHour);
					yValuesPercent.push(parseFloat(thirtyMinOneHourPrecent));
					yValuesTime.push(oneHourPlus);
					yValuesPercent.push(parseFloat(oneHourPlusPrecent));
				}
				
				Chart.defaults.color = 'white';							// color of axeses
				new Chart("ChartDurations", {
					type: "bar",
					data: {
						labels: xValuesDuration,
						color: 'white',
						datasets: [
							{
								label: 'Times',
								backgroundColor: ["#ff9999"],
								data: yValuesTime,
								borderWidth: 1
							},
							{
								label: 'Precentage of Time (%)',
								backgroundColor: ["#00aba9"],
								data: yValuesPercent,
								borderWidth: 1
							}
						]
					},
					options: {
						plugins: {
							title: {
							  display: true,
							  position: "top",
							  text: "Durations",
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
		catch (e) {
			const belem = document.getElementById("durationLinesContent");
			belem.innerHTML = "No duration was found.";
		}
	} ) ();

    /****************************************************************************************************************
	 	IP
			fetch - AWStatsSections.php?s=3&m="+month+"&y="+year
	
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
	(async function () {
		try {
			const responseIP = await fetch("AWStatsSections.php?s=3&m="+month+"&y="+year);
			const jsonIP = await responseIP.json();
			if (jsonIP == "none") {
				const belem = document.getElementById("IPsLinesContent");
				belem.innerHTML = "No IP was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
				let ip = '';
				let ipPages = 0;
				let ipBandwidth = 0;
				//let ipHits = 0;
				//let ipLastVisit = '';		DateTime
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
				
				let xValuesIP = [];
				let yValuesipPages = [];
				let yValuesipBandwidth = [];
				//let yValuesipHits = [];	
				//let yValuesipLastVisit = [];
				for (let i in jsonIP) {
					ipBandwidth = jsonIP[i]['bandwidth'];				// bandwidth of ip. This has the number of " MB" (AWStatsSections.php).
					if (ipBandwidth < 600) {							// skip IPs with less than 600 MB bandwidth
						continue;
					}
					ip = jsonIP[i]['ip'];
					if (ip == 'Others') {								// skip 'Others' IPs
						continue;
					}
					ipPages = jsonIP[i]['pages'];						// ip table ORDER BY number of pages
					//ipHits = jsonIP[i]['ipHits'];
					//ipLastVisit = jsonIP[i]['ipLastVisit'];
					xValuesIP.push(ip);
					yValuesipPages.push(ipPages);
					yValuesipBandwidth.push(parseFloat(ipBandwidth));	// convert string to float number. The string has  " MB" at the end.
					//yValuesipHits.push(ipHits);
					//yValuesipLastVisit.push(ipLastVisit);
				}
				
				Chart.defaults.color = 'white';							// color of axeses
				new Chart("ChartIPs", {
					type: "bar",
					data: {
						labels: xValuesIP,
						color: 'white',
						datasets: [
							{
								label: 'Pages',
								backgroundColor: ["#ff9999"],
								data: yValuesipPages,
								borderWidth: 1
							},
							{
								label: 'Bandwidth (MB)',
								backgroundColor: ["#00aba9"],
								data: yValuesipBandwidth,
								borderWidth: 1
							}
						]
					},
					options: {
						plugins: {
							title: {
							  display: true,
							  position: "top",
							  text: "IP Addresses",
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
		catch (e) {
			const belem = document.getElementById("ipLinesContent");
			belem.innerHTML = "No IP was found.";
		}
	} ) ();

    /****************************************************************************************************************
	 	OS
			fetch - AWStatsSections.php?s=4&m="+month+"&y="+year
	
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
	(async function () {
		try {
			const responseOS = await fetch("AWStatsSections.php?s=4&m="+month+"&y="+year);
			const jsonOS = await responseOS.json();
			if (jsonOS == "none") {
				const belem = document.getElementById("osLinesContent");
				belem.innerHTML = "No OS was found.";
				//document.getElementById("").style.display = "none";
			}
			else {
				let os = '';
				let osPages = 0;
				let osPercentOne = '';
				//let osHits = 0;
				//let osPercentTwo = '';
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
				
				let xValuesOS = [];
				let yValuesosPages = [];
				let yValuesosPercentOne = [];
				//let yValuesbHits = [];	
				//let yValueshBPercent = [];
				for (let i in jsonOS) {
					os = jsonOS[i]['os'];
					osPages = jsonOS[i]['pages'];						// os table ORDER BY number of pages
					osPercentOne = jsonOS[i]['percent'];				// percentage of osPages. This should a number with % sign off.
					//osHits = jsonOS[i]['osHits'];
					//osPercentTwo = jsonOS[i]['osPercentTwo'];
					xValuesOS.push(os);
					yValuesosPages.push(osPages);
					yValuesosPercentOne.push(parseFloat(osPercentOne));	// convert string to float number. The string has  " %" at the end.
					//yValuesbHits.push(osHits);
					//yValueshBPercent.push(osPercentTwo);
				}
				
				Chart.defaults.color = 'white';							// color of axeses
				new Chart("ChartOSs", {
					type: "bar",
					data: {
						labels: xValuesOS,
						color: 'white',
						datasets: [
							{
								label: 'Pages',
								backgroundColor: ["#ff9999"],
								data: yValuesosPages,
								borderWidth: 1
							},
							{
								label: 'Precentage of Pages (%)',
								backgroundColor: ["#00aba9"],
								data: yValuesosPercentOne,
								borderWidth: 1
							}
						]
					},
					options: {
						plugins: {
							title: {
							  display: true,
							  position: "top",
							  text: "Operating Systems",
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
		catch (e) {
			const belem = document.getElementById("osLinesContent");
			belem.innerHTML = "No OS was found.";
		}
	} ) ();
} // End of yearMonthChange()

/*****************************************************************************************************************
	countryChange.js => fetch - allCountry.php(cChange, month, year) (ChartTwo - pie) and
					 => fetch - countryChange.php (<select> <option>) 'Choose a language...'
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
    	fetch - allCountry.php(cChange, month, year) returns a text file		pie chart
	
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseAllCountry = await fetch("allCountry.php?cc="+CCode+"&m="+month+"&y="+year);
			const textAllCountry = await responseAllCountry.text();
//console.log(textAllCountry);
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
				//let resultsLength = Object.keys(results).length;
				
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
							description = 'Android apps';
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
							description = 'Progressive web app (PWAs) files';
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
						extensionTwo = 'SAB HTML (PWA) Read/Listen/View' + ' (' + extensionTwo + ')';
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
    	fetch - countryChange.php display a <select> <option> 'Choose a language...'
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseCountryChange = await fetch("countryChange.php?cc=" + CCode + "&m=" + month + "&y=" + year);
			const results = await responseCountryChange.json();
			if (results == "none") {
				document.getElementById("idISO").innerHTML = "No ISOs were found for " + month.toString() + "/" + year.toString() + "."; 
			}
			else {
				//let resultsLength = Object.keys(results).length;
				// country = full country
				// CCode = country code [CC]
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
					//para = para + "<option value='" + LN + ':' + idx + ' ' + iso + ' ' + rod + ' ' + variant + "'>" + LN + ' [' + iso + '] (' + rod + ') ' + variant + '</option>';
					para = para + "<option value='" + LN  + '%20' + iso + "'>" + LN + ' [' + iso + '] (' + rod + ') ' + variant + '</option>';
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

/*****************************************************************************************************************
	isoChange(langData, month, year) => ChartISO (pie)
		fetch - isoChange.php?i=[langArray[1]]&m=MM&y=YYYY
*****************************************************************************************************************/
function isoChange(langData, month, year) {
	// Destroy exiting Chart.js instance to reuse <canvas> element.
	let barOne = document.getElementById('barChartISO');
	barOne.innerHTML = '&nbsp;';
	$('#barChartISO').append('<canvas id="ChartISO"><canvas>');
	const elem = document.getElementById("idISOError");
	elem.innerHTML = "";
		
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
	let iso = "";
	
	let langArray = langData.split("%20");									// langData = LN + ':' + idx + ' ' + iso + ' ' + rod + ' ' + variant
	LN = langArray[0];
	iso = langArray[1];

    /****************************************************************************************************************
    	fetch - isoChange.php?i="+langArray[1]+"&m="+month+"&y="+year)
		
		An Immediately Invoked Function Expression (IIFE) is a technique used to execute a function immediately
		as soon as you define it. This is useful when you need to run the asynchronous function only once.
    ****************************************************************************************************************/
    (async function () {
		try {
			const responseTwo = await fetch("isoChange.php?i="+iso+"&m="+month+"&y="+year);
			const textTwo = await responseTwo.json();
			if (textTwo == "none" || textTwo == "{}") {
				const elem = document.getElementById("idISO");
				elem.innerHTML = "No ISO ["+iso+"] was found for " + month.toString() + "/" + year.toString() + ".";
			}
			else {
				let description = '';
				let extension = '';
				let accesses = 0;
				
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
				for (let i in textTwo) {
					extension = textTwo[i]['extension'];
					accesses = textTwo[i]['accesses'];
					switch (extension) {
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
					yValues.push(accesses);
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
		catch (e) {
			//alert('Error fetching isoChange.php: ' + e.message);
			//console.error('Error', e.message);
			const elem = document.getElementById("idISOError");
			elem.innerHTML = "No ISO ["+iso+"] was found for " + month.toString() + "/" + year.toString() + ".";
		}
	} ) ();
}	// End of isoChange()