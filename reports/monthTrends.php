<?php

/*******************************************************************
	STATUS OF PAGE
	Compares visits by month and trends them

	TO DO
	1) Converting from gym payment script
		-Track last 12 months
		-Pull pass data by gym by month for the last 12 months
		-Store as values and show in graph

*********************************************************************/

include("./chooseHeader.php");


	//Capturing inputs into variables
	$month = ;
	$gym = ;

	/*First of the Month*/
	$FOM = date("Y-$month-01");
	echo '$FOM is '.$FOM;

	echo "<br>";

	/*Next first of the Month*/
	$nextMonth = $month + 1;
	$NFOM = date("Y-$nextMonth-01");
	echo '$NFOM is '.$NFOM;

	echo "<br>";

	$gymQuery = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE shortName='$gym'");
	$gymRow = mysqli_fetch_array($gymQuery);
	$gymRate = $gymRow['dayRate'];

	echo $gym.' has a day rate of $'.$gymRate;
	echo "<br>";

	/*************************************************************
	NEEDED VARIABLES

	1) users who used passes last month and which gyms they went to

	***************************************************************/


	// PULL ALL PASSES USED LAST MONTH
	$passesUsed = mysqli_query($dbConnected, "SELECT * FROM passes WHERE (dateUsed BETWEEN '$FOM' AND '$NFOM') AND (emailSent='Yes' AND rockGym='$gym')");
	$passesUsedRow = mysqli_num_rows($passesUsed);

	echo 'There were '.$passesUsedRow.' passes used at '.$gym.' last month';

		echo "<br>";

	$dueGym = $gymRate * $passesUsedRow;

	echo 'You need to pay '.$gym.' $'.$dueGym.'.';




// This is the easy code that could be used to automatically run on the first of the month.
// if (date("Y-m-d") == $FOM) {
// 	echo "It's the first of the month.";
// } else {
// 	echo "It is not the first of the month";
// }



?>
