<?php 

include("../inc/connectDB.php");

//This is the report to pulls passes purchased
$passesPurchased = mysql_query("SELECT * FROM passes");
$passesPurchasedCount = mysql_num_rows($passesPurchased) / 10;

echo $passesPurchasedCount;



 ?>