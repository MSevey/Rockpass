<?php

/*
********************************************************
*
*	File: conectDB.php
*	By: Matthew Sevey
*	Date: July 26, 2015
*	Purpose: To connect to the RPassdb database
*			and return an error message if unsuccessful
*
********************************************************
*/

//Creating the array $db so that inforamtion about the DB only has to be changed in one location

	// // For using on computer localhost
	// $db = array(
	// 	'hostname' => 'localhost',
	// 	'username' => 'root',
	// 	'password' => 'password',
	// 	'database' => 'rpassdb',
	// 	);

	// For using on live website
	$db = array(
		'hostname' => 'us-cdbr-iron-east-05.cleardb.net',
		'username' => 'b9473b73b938d0',
		'password' => 'c396de86',
		'database' => 'heroku_ca1cbb3f9ee48ef',
		);


//Setting Variable $dbSuccess initially to false so that if nothing happens we will have an error message
	$dbSuccess = false;

//Setting vaiable $dbConnected to a value of Ture or False based on if the db is connected
	$dbConnected = mysqli_connect($db['hostname'],$db['username'],$db['password'],$db['database']);

//First checking to see if the mysqli_connect statement came back as true making the variable $dbConnected = true

	$alert = "";

	if ($dbConnected) {
		//If the database is successfully connected, we make sure we can select the DB
		$dbSelected = mysqli_select_db($dbConnected,$db['database']);

		//This then checks to make sure we were able to select the DB
		if ($dbSelected) {
			$dbSuccess = true;
		} else {
			echo "DB Selection FAILED";
			$alert = "Failed";
			echo "<script type='text/javascript'>alert('$alert');</script>";
		}

	} else {
		echo "MySQL Connection FAILED";
		$alert = "Failed";
		echo "<script type='text/javascript'>alert('$alert');</script>";
	}

?>
