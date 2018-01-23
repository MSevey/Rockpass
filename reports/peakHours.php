<?php

/***************************************************
	STATUS OF PAGE

	Page currently pulls in hour most visited total and for each gym



****************************************************/


include("../inc/connectDB.php");


//This is grabbing all the used passes in the passes table
$totalPassInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE emailSent IS NOT NULL");
$totalPasses = mysqli_num_rows($totalPassInfo);

//This is grabbing all the used passes at RSpot in the passes table
$RStotalPassInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='RSpot' AND emailSent IS NOT NULL");
$RStotalPasses = mysqli_num_rows($RStotalPassInfo);

//This is grabbing all the used passes at Metro in the passes table
$MetrototalPassInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='Metro' AND emailSent IS NOT NULL");
$MetrototalPasses = mysqli_num_rows($MetrototalPassInfo);

//This is grabbing all the used passes at CRG in the passes table
$CRGtotalPassInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='CRG' AND emailSent IS NOT NULL");
$CRGtotalPasses = mysqli_num_rows($CRGtotalPassInfo);

//This is grabbing all the used passes at BKB in the passes table
$BKBtotalPassInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='BKBSomm' AND emailSent IS NOT NULL");
$BKBtotalPasses = mysqli_num_rows($BKBtotalPassInfo);




// This is the overall peak hour
	for ($i=0; $i < $totalPasses; $i++) {

		//Grabbing the hour from dateUsed
		$hourUsedInfo = mysqli_query($dbConnected, "SELECT HOUR(dateUsed) AS hour FROM passes WHERE emailSent IS NOT NULL ORDER BY ID LIMIT 1 OFFSET $i");
		$hourUsed = mysqli_fetch_array($hourUsedInfo);

		$hour[$i] = $hourUsed['hour'];


	}

	//Finding the mode, or most visited hour
	$values = array_count_values($hour);
	$mode = array_search(max($values), $values);

	echo "The hour when the most people climb is ".$mode."<br>";


// This is the peak hour for each gym
//	This code can be updated in the future when there are more areas/gyms to have the gym or area selected from a drop down to then determine peak hours
	for ($i=0; $i < $RStotalPasses; $i++) {

		//Grabbing the hour from dateUsed for RockSpot
		$RShourUsedInfo = mysqli_query($dbConnected, "SELECT HOUR(dateUsed) AS hour FROM passes WHERE rockGym='RSpot' AND emailSent IS NOT NULL ORDER BY ID LIMIT 1 OFFSET $i");
		$RShourUsed = mysqli_fetch_array($RShourUsedInfo);

		$RShour[$i] = $RShourUsed['hour'];


	}

	for ($i=0; $i < $MetrototalPasses; $i++) {

		//Grabbing the hour from dateUsed for MetroRock
		$MetrohourUsedInfo = mysqli_query($dbConnected, "SELECT HOUR(dateUsed) AS hour FROM passes WHERE rockGym='Metro' AND emailSent IS NOT NULL ORDER BY ID LIMIT 1 OFFSET $i");
		$MetrohourUsed = mysqli_fetch_array($MetrohourUsedInfo);

		$Metrohour[$i] = $MetrohourUsed['hour'];

	}

	for ($i=0; $i < $CRGtotalPasses; $i++) {

		//Grabbing the hour from dateUsed for CRG
		$CRGhourUsedInfo = mysqli_query($dbConnected, "SELECT HOUR(dateUsed) AS hour FROM passes WHERE rockGym='CRG' AND emailSent IS NOT NULL ORDER BY ID LIMIT 1 OFFSET $i");
		$CRGhourUsed = mysqli_fetch_array($CRGhourUsedInfo);

		$CRGhour[$i] = $CRGhourUsed['hour'];

	}

	for ($i=0; $i < $BKBtotalPasses; $i++) {

		//Grabbing the hour from dateUsed for RockSpot
		$BKBhourUsedInfo = mysqli_query($dbConnected, "SELECT HOUR(dateUsed) AS hour FROM passes WHERE rockGym='BKBSomm' AND emailSent IS NOT NULL ORDER BY ID LIMIT 1 OFFSET $i");
		$BKBhourUsed = mysqli_fetch_array($BKBhourUsedInfo);

		$BKBhour[$i] = $BKBhourUsed['hour'];

	}


	//Finding the mode, or most visited hour at RSpot
	$RSvalues = array_count_values($RShour);
	$RSmode = array_search(max($RSvalues), $RSvalues);

	echo "The hour when the most people climb at RockSpot is ".$RSmode."<br>";

	//Finding the mode, or most visited hour at Metro
	$Metrovalues = array_count_values($Metrohour);
	$Metromode = array_search(max($Metrovalues), $Metrovalues);

	echo "The hour when the most people climb at Metro is ".$Metromode."<br>";

	//Finding the mode, or most visited hour at CRG
	$CRGvalues = array_count_values($CRGhour);
	$CRGmode = array_search(max($CRGvalues), $CRGvalues);

	echo "The hour when the most people climb at CRG is ".$CRGmode."<br>";

	//Finding the mode, or most visited hour at BKB
	$BKBvalues = array_count_values($BKBhour);
	$BKBmode = array_search(max($BKBvalues), $BKBvalues);

	echo "The hour when the most people climb at BKB is ".$BKBmode."<br>";

 ?>
