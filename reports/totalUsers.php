<?php 

include("../inc/connectDB.php");

//This is the report to pull total users
$totalUsers = mysql_query("SELECT * FROM users");
$totalUsersCount = mysql_num_rows($totalUsers);

echo $totalUsersCount;



 ?>