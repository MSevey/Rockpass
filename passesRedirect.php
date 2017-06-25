<?php 

//**************************************************
//  STATUS OF PAGE
//
// 
//
//**************************************************


//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


//Checking to make sure the user has passes
if ($passNumRows == 0) {

  // Header is for localhost.  Does not work on live website
  header("Location: noPass");
  
  // Javascript is for live website.  Does not work on localhost
  // echo '<script type="text/javascript"> window.location="www.therockpass.com/noPass"; </script>';

}

//User has passes Available.
//Checking to see if there is a passes table entry for today.
elseif (date("Y-m-d 00:00:00") <= $usedPassRow['dateUsed']) {

    //User has passes Available and has an entry for today
    //Checking to see if an email has been sent
  // ***********this might need to be updated once the passes page is updated.*************************
    if ($usedPassRow['emailSent'] == "Yes") {

      // Header is for localhost.  Does not work on live website
      header("Location: passUsedToday");
      
      // Javascript is for live website.  Does not work on localhost
      // echo '<script type="text/javascript"> window.location="www.therockpass.com/passUsedToday"; </script>';

      //User has passes Available, has an entry for today, but has not used a QR Code
      //Checking to see where the user is from.
    } elseif ($userRow['state'] == "MA") {

        // Header is for localhost.  Does not work on live website
        header("Location: passes");
        
        // Javascript is for live website.  Does not work on localhost
        // echo '<script type="text/javascript"> window.location="www.therockpass.com/passesMA"; </script>';

      } else {

        // Header is for localhost.  Does not work on live website
        header("Location: notMA");
        
        // Javascript is for live website.  Does not work on localhost
        // echo '<script type="text/javascript"> window.location="www.therockpass.com/notMA"; </script>';

      }

}

//User has passes available but no entry for today.
//Checking to see where user is from.    
elseif ($userRow['state'] == "MA") {

  // Header is for localhost.  Does not work on live website
  header("Location: passes");
  
  // Javascript is for live website.  Does not work on localhost
  // echo '<script type="text/javascript"> window.location="www.therockpass.com/passesMA"; </script>';

} 

else {

  // Header is for localhost.  Does not work on live website
  header("Location: notMA");
  
  // Javascript is for live website.  Does not work on localhost
  // echo '<script type="text/javascript"> window.location="www.therockpass.com/notMA"; </script>';

}


 ?>
    