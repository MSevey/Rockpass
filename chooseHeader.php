<?php 

/********************************************************

  STATUS OF PAGE
  -Identifies if someone is logged in and who the user is.
  -Makes sure there are entries for the user in all relavent tables
  -Pulls the following user info
    -$userRow : users info from users table
      -$userID : current users ID
      -$username : current users username
    -$passRow : users info from the last used pass
      -$passNumRows : number of available passes
      -$passPack[][] : current 10 pack of passes
    -$gymRow : pulls gyms info from gyms table
    -$userData : users info from userData table
      -$dataLastUpdate : date of last update of userdata
    -$UserHobbies : users info from hobbies table
      -$hobbiesLastUpdate : date of last update of hobbies

********************************************************/

session_start();

include("./inc/connectDB.php");  


if (isset($_SESSION["username_login"])) {
  $session = true;

  //Identifying user from username
  $username = $_SESSION["username_login"];

  //Grabbing Current User Information
    $userInfo = mysql_query("SELECT * FROM users WHERE username='$username'");
    $userRow = mysql_fetch_array($userInfo);  
    $userID = $userRow['ID'];

  //Grabbing user available pass info from passes table
    //This is the number of available passes
    $passInfo = mysql_query("SELECT * FROM passes WHERE userID='$userID' AND emailSent IS NULL");
    $passNumRows = mysql_num_rows($passInfo);

  
  //This is the last pass used
    if ($passNumRows != 0) {
      // Date when 10 pack was purchased Purchased
        $datePurchasedInfo = mysql_query("SELECT datePurchased FROM passes WHERE userID='$userID' AND emailSent IS NULL LIMIT 1");
        $datePurchasedRow = mysql_fetch_array($datePurchasedInfo);
        $datePurchased = $datePurchasedRow['datePurchased']; 

      // select the ten rows
        for ($i=0; $i < 10; $i++) { 

          $passInfo = mysql_query("SELECT * FROM passes WHERE datePurchased='$datePurchased' AND userID='$userID' ORDER BY ID LIMIT 1 OFFSET $i");
          $passRow = mysql_fetch_array($passInfo);

          $passPack[$i]['ID'] = $passRow['ID'];
          $passPack[$i]['userID'] = $passRow['userID'];
          $passPack[$i]['rockGym'] = $passRow['rockGym'];
          $passPack[$i]['datePurchased'] = $passRow['datePurchased'];
          $passPack[$i]['dateUsed'] = $passRow['dateUsed']; 
          $passPack[$i]['emailSent'] = $passRow['emailSent'];
        }


      if ($passNumRows != 10) {

        $usedPassInfo = mysql_query("SELECT * FROM passes WHERE (userID='$userID' AND emailSent IS NOT NULL) ORDER BY ID DESC LIMIT 1");
        $usedPassRow = mysql_fetch_array($usedPassInfo);

      } else {
        $usedPassRow['dateUsed'] = 0;
      }

    } 

  // Adds row for user to all relavent tables
    // currently only relavent tables are users, userdata, and hobbies. users is created at Sign Up.  
    // userdata and hobbies are created right after sign up
    $userData_sql = mysql_query("SELECT * FROM userdata WHERE userID='$userID'");
    $userData_num = mysql_num_rows($userData_sql);

    $userHobbies_sql = mysql_query("SELECT * FROM hobbies WHERE userID='$userID'");
    $userHobbies_num = mysql_num_rows($userHobbies_sql);

    // Checking if user has info in the userData table
      if ($userData_num != 0) {   

        // User is in userData table, grabbing info
        $userData = mysql_fetch_array($userData_sql);

      } else {

        // User is not in userData table. Inserting a row then grabbing that info
        $userData_insert = "INSERT INTO userdata (userID) VALUES ('".$userID."')";

        if (mysql_query($userData_insert)) {

          $userData_sql = mysql_query("SELECT * FROM userdata WHERE userID='$userID'");
          $userData = mysql_fetch_array($userData_sql);
          
        } else {

          $errormsg = "Oops! Something went wrong. Please refresh the page."; 
          echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                      '.$errormsg.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'; 
          echo " (".__LINE__.")";

        }

      }

    // Getting date of last update to the userData table for user
      $dataLastUpdate_sql = mysql_query(" SELECT DAY( lastUpdate ) AS DAY, 
                                                 MONTH( lastUpdate ) AS MONTH, 
                                                 YEAR( lastUpdate ) AS YEAR
                                          FROM userdata");
      $dataLastUpdate_array = mysql_fetch_array($dataLastUpdate_sql);
      $dataLastUpdate = $dataLastUpdate_array['DAY'].$dataLastUpdate_array['MONTH'].$dataLastUpdate_array['YEAR'];

    // Checking if user has info in the hobbies table
      if ($userHobbies_num != 0) {    
        
        // User is in the hobbies table, grabbing their info
        $userHobbies = mysql_fetch_array($userHobbies_sql);

      } else {

        // User is not in the hobbies table. Inserting a row and grabbing their info
        $userHobbies_insert = "INSERT INTO hobbies (userID) VALUES ('".$userID."')";

        if (mysql_query($userHobbies_insert)) {

          $userHobbies_sql = mysql_query("SELECT * FROM hobbies WHERE userID='$userID'");
          $userHobbies = mysql_fetch_array($userHobbies_sql);
          
        } else {

          $errormsg = "Oops! Something went wrong. Please refresh the page."; 
          echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                      '.$errormsg.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
          echo " (".__LINE__.")";

        }

      }

    // Getting date of last update to the hobbies table for user
      $hobbiesLastUpdate_sql = mysql_query("  SELECT DAY( lastUpdate ) AS DAY, 
                                                     MONTH( lastUpdate ) AS MONTH, 
                                                     YEAR( lastUpdate ) AS YEAR
                                              FROM hobbies");
      $hobbiesLastUpdate_array = mysql_fetch_array($hobbiesLastUpdate_sql);
      $hobbiesLastUpdate = $hobbiesLastUpdate_array['DAY'].$hobbiesLastUpdate_array['MONTH'].$hobbiesLastUpdate_array['YEAR'];


  //Checking to see if the user is an admin 
    if ($userRow['admin'] == "Yes") {
    
      include ("./headerAdmin.php");

    } else {
     
      include ( "./headerUser.php" );

    }

  
} elseif (isset($_SESSION["gym_login"])) {

  $gymName = $_SESSION["gym_login"];

  // Grab gym information
  $gymInfo = mysql_query("SELECT * FROM gyms WHERE gymName='$gymName'");
  $gymRow = mysql_fetch_array($gymInfo);

  include ("./headerGym.php");
  
} else {
  $session = false;
  
  include ( "./header.php" );

}
  

?>