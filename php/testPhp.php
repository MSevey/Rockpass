<?php 

/**************************************

	STATUS OF PAGE
	Testing keeping php code out of main pages

	**header is loading original page again??**


***************************************/

session_start();

include("../inc/connectDB.php");

//Identifying user from username
  $username = $_SESSION["username_login"];

//Grabbing Current User Information
  $userInfo = mysql_query("SELECT * FROM users WHERE username='$username'");
  $userRow = mysql_fetch_array($userInfo);  
  $userID = $userRow['ID'];

  echo $userRow['username'];

  $referralCode = "";

  for ($i=0; $i < 6; $i++) { 
		$randomValue = substr("abcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0,35), 1);
		$referralCode = $referralCode.$randomValue;
	}

	$referralCode_Update = "UPDATE users SET referralCode='$referralCode' WHERE username='$username'";

	if (mysql_query($referralCode_Update)) {
		//have page reload so that if the user refreshes the page it does not resubmit the form

		// Header is for localhost.  Does not work on live website
		header("Location: ../test.php");

		// Javascript is for live website.  Does not work on localhost
		// echo '<script type="text/javascript"> window.location="www.therockpass.com/account"; </script>';

	} else {
		echo '<div class="alert alert-danger text-center" role="alert">Sorry something went wrong with your referral code, please refresh page and try again.</div>';
	}



 ?>