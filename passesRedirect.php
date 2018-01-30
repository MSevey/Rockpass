<?php

include("./chooseHeader.php");


//Checking to make sure the user has passes
if ($passNumRows == 0) {

  header("Location: noPass");

}

//User has passes Available.
//Checking to see if there is a passes table entry for today.
elseif (date("Y-m-d 00:00:00") <= $usedPassRow['dateUsed']) {

    //User has passes Available and has an entry for today
    //Checking to see if an email has been sent
    if ($usedPassRow['emailSent'] == "Yes") {

      header("Location: passUsedToday");

      //User has passes Available, has an entry for today, but has not used a QR Code
      //Checking to see where the user is from.
    } elseif ($userRow['state'] == "MA") {

        header("Location: passes");

      } else {

        header("Location: notMA");

      }

}

//User has passes available but no entry for today.
//Checking to see where user is from.
elseif ($userRow['state'] == "MA") {

  header("Location: passes");

}

else {

  header("Location: notMA");

}


 ?>
