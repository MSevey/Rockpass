<?php

include("../inc/connectDB.php");

//This is the report to pulls the most popular gym
$RSpotSB = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='RSpotSB'");
$MetroEvertt = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='MetroEvertt'");
$BKBSomm = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='BKBSomm'");
$CentralRockBoston = mysqli_query($dbConnected, "SELECT * FROM passes WHERE rockGym='CentralRockBoston'");


$RSpotSBCount = mysqli_num_rows($RSpotSB);
$MetroEverttCount = mysqli_num_rows($MetroEvertt);
$BKBSommCount = mysqli_num_rows($BKBSomm);
$CentralRockBostonCount = mysqli_num_rows($CentralRockBoston);

$maxCount = max($RSpotSBCount, $MetroEverttCount, $BKBSommCount, $CentralRockBostonCount);

switch ($maxCount) {
  case $RSpotSBCount:
    echo "The most visited gym is Rock Spot Southie!";
    break;

  case $MetroEverttCount:
    echo "The most visited gym is Rock Spot MetroRock!";
    break;

  case $BKBSommCount:
    echo "The most visited gym is Rock Spot BKB!";
    break;

  case $CentralRockBostonCount:
    echo "The most visited gym is Rock Spot Central Rock!";
    break;

  default:
    echo "Error.  Or nothing in Passes table";
    break;
}


 ?>
