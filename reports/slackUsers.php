<?php 
/**************************************
	Finds users that haven't used a pass in the last 30 days
		and whether or not they have passes available.

	***THIS CAN BE USED TO SEND OUT EMAIL REMINDERS***	

**************************************/

include("../inc/connectDB.php");


// Finding total users to cycle through getting their IDs
	$totalUsers = mysql_query("SELECT * FROM users");
	$totalUsersCount = mysql_num_rows($totalUsers);


// Looping through user table to grab each user and check them in the passes table
	for ($i=0; $i < $totalUsersCount; $i++) { 
		
		// Grabbing user 1 by 1
			$user = mysql_query("SELECT * FROM users LIMIT 1 OFFSET $i");
			$userRow = mysql_fetch_array($user);


		//  Grabbing total number of passes older than thirty days
		//  Need to look for where this is equal to the total number of passes in the system for the user
			$oldpass = mysql_query("SELECT * FROM passes WHERE (`dateUsed` + INTERVAL 30 DAY < NOW() AND (userID=".$userRow['ID']." AND emailSent='Yes'))");
			$oldpassNum = mysql_num_rows($oldpass);

		// Grabbing total Number of passes used for user
			$pass = mysql_query("SELECT * FROM passes WHERE (userID=".$userRow['ID']." AND emailSent='Yes')");
			$passNum = mysql_num_rows($pass);

		// Grabbing number of available passes
			$passAvail = mysql_query("SELECT * FROM passes WHERE (userID=".$userRow['ID']." AND emailSent IS NULL)");
			$passAvailNum = mysql_num_rows($passAvail);

			// Checking if user has used a pass recently
				if ($passNum == 0) {
					// This means the user hasn't used any passes yet
					echo $userRow['fName']." ".$userRow['lName']." has not used a pass yet.<br>";

				} elseif ($oldpassNum == $passNum) {
					// This means there are no passes used in the last thirty days
					echo $userRow['fName']." ".$userRow['lName']." has not used a pass in the last 30 days.<br>";

				}

			// Checking if the user also doesn't have any passes left
				if ($passAvailNum == 0) {
					// THis means the user also does not have any passes left
					echo $userRow['fName']." ".$userRow['lName']." does not have any passes left.<br><br>";
				}

	}



 ?>