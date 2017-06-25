<?php 

include("../inc/connectDB.php");

//This is the report to pull the first 50 users and shows their name
for ($i=0; $i < 50; $i++) { 

	$user = mysql_query("SELECT * FROM users ORDER BY ID LIMIT 1 OFFSET $i");
	$userData = mysql_fetch_array($user);

	echo $userData['fName']." ".$userData['lName'];
	echo "<br>";
}



 ?>