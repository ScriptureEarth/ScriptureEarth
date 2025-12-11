<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Cache-Control" 			content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" 					content="no-cache" />
	<meta http-equiv="Expires" 					content="0" />
	<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
	<meta name="ObjectType" 					content="Document" />
	<meta http-equiv="Window-target" 			content="_top" />
	<meta name="Created-by" 					content="Scott Starker" />
	<title>AWStats View</title>
	<style type="text/css">
		html {
			font-family: "helvetica neue", helvetica, arial, sans-serif;
		}
		.linePointer {
			cursor: pointer;
			/*display: inline;*/
		}
		.linePointer:hover {
			border-bottom:2px solid red;
		}
		.container {
			/*background-position: center;
			background-image: url('../images/background_earth.jpg');
			background-size: 50%;
			background-position: 50%;
			background-repeat: no-repeat;*/
		}
		.lineOne {
			text-shadow: 0.07em 0.07em 0.05em black;
		}
		body {
			background-color: black;
			color: white;
		}
	</style>
	<script type="text/javascript" language="javascript" src="_js/jquery-1.12.4.js"></script>
	<script type="text/javascript" language="javascript" src="_js/AWStatsScripts.js?v=0.1.8"></script>
	<script type="text/javascript" language="javascript" src="_js/countryChange.js?v=0.1.3"></script>
	<script type="text/javascript" language="javascript" src="_js/chart.umd.min.js"></script>			<!-- 2.9.4 -->
</head>
<body>
<?php

/*
locales: Country Code [[ISO codes]]
downloads: ISO, study (apk) or PDF or audio (mp3) or video (mp4) or /data/[iso]/sab/[iso]+/timings/*-timing.txt (country) [[country code]]
html: ISO /data/[iso]/sab/[iso]+/ *.html (country) [[country code]]

This table not used now:
duration table
ip table
browsers table
os table
*/

//	require_once './include/conn.inc.php';										// connect to the database named 'scripture'
//	$db = get_my_db();

	/*$query="SELECT * FROM visitors WHERE month = ? AND year = ?";
	$visitors_select_stmt=$db->prepare($query);
	$query="INSERT INTO visitors (month, year, uniqueVisitors, numberOfVisits, pages, hits, bandwidth) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?)";
	$visitors_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM duration WHERE month = ? AND year = ?";
	$duration_select_stmt=$db->prepare($query);
	$query="INSERT INTO duration (month, year, zeroSecThirtySec, zeroSecThirtySecPre, thirtySecTwoMin, thirtySecTwoMinPre, twoMinFiveMin, twoMinFiveMinPre, fiveMinFifthteenMin, fiveMinFifthteenMinPre, fifthteenMinThirtyMin, fifthteenMinThirtyMinPre, thirtyMinOneHour, thirtyMinOneHourPre, oneHourPlus, oneHourPlusPre) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$duration_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM fileType WHERE month = ? AND year = ?";
	$fileType_select_stmt=$db->prepare($query);
	$query="INSERT INTO fileType (month, year, fileType, description, fTHits, hFTPercent, fTBandwidth, bFTPercent) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?, ?)";
	$fileType_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM os WHERE month = ? AND year = ?";
	$os_select_stmt=$db->prepare($query);
	$query="INSERT INTO os (month, year, os, osPages , osPercentOne, osHits, osPercentTwo) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?)";
	$os_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM browsers WHERE month = ? AND year = ?";
	$browsers_select_stmt=$db->prepare($query);
	$query="INSERT INTO browsers (month, year, browser, bPages, pBPercent, bHits, hBPercent) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?)";
	$browsers_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM locales WHERE month = ? AND year = ?";
	$locales_select_stmt=$db->prepare($query);
	$query="INSERT INTO locales (month, year, locales, cc, lPages, lHits, lBandwidth) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?)";
	$locales_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM ip WHERE month = ? AND year = ?";
	$ip_select_stmt=$db->prepare($query);
	$query="INSERT INTO ip (month, year, ip, ipPages, ipHits, ipBandwidth, ipLastVisit) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?)";
	$ip_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM downloads WHERE month = ? AND year = ?";
	$downloads_select_stmt=$db->prepare($query);
	$query="INSERT INTO downloads (month, year, iso, subFolder, isoPlus, extension, download, dHit, dHit206, dBandwidth) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?, ?, ?, ?)";
	$downloads_insert_stmt=$db->prepare($query);

	$query="SELECT * FROM html WHERE month = ? AND year = ?";
	$html_select_stmt=$db->prepare($query);
	$query="INSERT INTO html (month, year, iso, subFolder, isoPlus, extension, HTML, View) VALUE ($intMonth, $intYear, ?, ?, ?, ?, ?, ?)";
	$html_insert_stmt=$db->prepare($query);*/

	/**************************************************************************************************************************************************/

	// beginning month/year: 8/2020
	// ending month/year: last month
	?>
	
<img src='../images/00eng-ScriptureEarth_header.jpg' style='margin-left: 20%; width: 50%; ' />
	
<div class="container">
	<div style="width: 100%; text-align: center; margin-top: 10px; ">
		<select id="month" onchange="yearMonthChange(document.getElementById('year').options[document.getElementById('year').selectedIndex].value, document.getElementById('month').options[document.getElementById('month').selectedIndex].value)">
			<option value='Choose a month...' selected='selected'>Choose a month...</option>
			<option value='1'>January</option>
			<option value='2'>February</option>
			<option value='3'>March</option>
			<option value='4'>April</option>
			<option value='5'>May</option>
			<option value='6'>June</option>
			<option value='7'>July</option>
			<option value='8'>August</option>
			<option value='9'>September</option>
			<option value='10'>October</option>
			<option value='11'>November</option>
			<option value='12'>December</option>
			<option value='13'>Year</option>
		</select>

		<select id="year" onchange="yearMonthChange(document.getElementById('year').options[document.getElementById('year').selectedIndex].value, document.getElementById('month').options[document.getElementById('month').selectedIndex].value)">
			<option value='Choose a year...' selected='selected'>Choose a year...</option>
			<?php
			for ($i = 2020; $i <= date("Y"); $i++) {
				echo "<option value='". $i . "'>".$i."</option>";
			}
			?>
		</select>
	</div>

	<br /><br />

	<!-- the lines of the "visitors", "Number of Visits", "Pages", and "Average number of pages per visit" -->
	<div id="firstLine" style="margin-top: 20px; "></div>

	<!-- The total pie chart for this month -->
	<div id="pieChartFileType" style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 60%; ">
		<canvas id="ChartFileType" style="margin: 0; "></canvas>				<!-- pie -->
	</div>
	
	<!-- a bar chart for the Countries -->
	<div id="barChartLocales" style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 90%; ">
		<canvas id="ChartLocales" style=""></canvas>							<!-- bar -->
	</div>
	
	<div id="selectLine" style="margin-top: 10px; "></div>

	<!-- a pie chart of the Country for this month -->
	<div id="barChartTwo" style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 46%; ">
		<canvas id="ChartTwo" style=""></canvas>								<!-- pie -->
	</div>
	
	<div id="idCountry" style="margin-top: 20px; "></div>
	
	<div id="idISO" style="margin-top: 20px; "></div>

	<!-- a pie chart for this ISO (minority language) -->
	<div id="barChartISO" style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 46%; ">
		<canvas id="ChartISO" style=""></canvas>								<!-- pie -->
	</div>

</div>
</body>
</html>