<?php

include("../inc/connectDB.php");

//This is the report to pull total users
$totalUsers = mysqli_query($dbConnected, "SELECT * FROM users");
$totalUsersCount = mysqli_num_rows($totalUsers);

echo $totalUsersCount;



 ?>
