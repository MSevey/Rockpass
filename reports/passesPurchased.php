<?php

include("../inc/connectDB.php");

//This is the report to pulls passes purchased
$passesPurchased = mysqli_query($dbConnected, "SELECT * FROM passes");
$passesPurchasedCount = mysqli_num_rows($passesPurchased) / 10;

echo $passesPurchasedCount;



 ?>
