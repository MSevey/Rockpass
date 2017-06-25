<?php 

include("./inc/connectDB.php");

//This is the report to pull total users
$totalUsers = mysql_query("SELECT * FROM users");
//$totalUsersRow = mysql_fetch_array($totalUsers);
$totalUsersRowCount = mysql_num_rows($totalUsers);

echo $totalUsersRowCount;



 ?>