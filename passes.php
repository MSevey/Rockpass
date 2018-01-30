<?php

include("./chooseHeader.php");



// This is used with the form field below so that when click the script runs again.
$thisScriptName = "passes";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Grabbing the Date in Year Month Day hour minute second format
$today = date("Y-m-d H:i:s");


// Checking to see if user clicked email pass.
if (isset($_POST["emailPass"])) {

  // User Clicked email pass
  // setting $rockgym equal to the value from drop down
  $rockGym = mysqli_real_escape_string($dbConnected, @$_POST["rockGym"]);


  // Checking to see if there is a pass logged for today.  If no passes logged for today, continue.
  if (date("Y-m-d 00:00:00") > $usedPassRow['dateUsed'] || $passNumRows ==10){

    // no passes in DB for today.  In other words, the last 'dateUsed' is less than today
    // Checks to make sure the user has passes available.
    if ($passNumRows > 0) {

      // User has passes available ie passes where the emailSent is NULL
      // Selecting the next pass to be used
      $nextPass = mysqli_query($dbConnected, "SELECT * FROM passes WHERE emailSent IS NULL AND userID='$userID' ORDER BY ID LIMIT 1");
      $nextPassRow = mysqli_fetch_array($nextPass);
      $nextPassID = $nextPassRow['ID'];


      //  NEED UPDATE STATEMENT TO INSERT ROCKGYM, DATE, AND CHANGE EMAIL TO NOT NULL
        // ******************************************************* UPDATE
        $passes_SQLUpdate = "UPDATE passes ";
        $passes_SQLUpdate .= "SET rockGym='$rockGym', dateUsed='$today', emailSent='Yes'  ";
        $passes_SQLUpdate .= "WHERE ID='$nextPassID'";

        //*************************************************************

      //Checks to make sure update statement worked.
      if (mysqli_query($dbConnected, $passes_SQLUpdate)) {

        $to = $userRow['email'];
        $subject = "Your Rock Pass";
        $message = "
        <html>
        <head>
        <title>Pass Email</title>
        </head>
        <body>
          <div>
            <h1>Get Ready to Crush Climbs!!</h1>
            <h3>Your pass is validate for ".$today." at ".$rockGym."</h3>
            <div>
              <div>
                This should be the person picture
              </div>
              <div>
                <p>Please show this email at ".$rockGym." and go crush come climbs!</p>
              </div>
            </div>
          </div>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <passes@therockpass.com>' . "\r\n";
        // $headers .= 'Cc: matt@therockpass.com' . "\r\n";

        if (mail($to,$subject,$message,$headers)) {
          $errormsg = "Your pass is in your inbox!";
          echo '  <div class="alert alert-dismissable alert-success text-center" role="alert">
                    '.$errormsg.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        } else {
          // $errormsg = "Oops there seems to be a problem.  The Email did not send.";
          $errormsg = "This site is no longer active so emails are not being sent.";
          echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                    '.$errormsg.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        }

      } else {
        $errormsg = "Oops there seems to be a problem, DB did not update.  Try Reloading the page and selecting your Gym Again.";
        echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                  '.$errormsg.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
      }


    } else {
      // User has no passes available
      header("Location: noPass");

    }

  } else {
      // User has already used a pass today
      header("Location: passUsedToday");

  }

}

$fld_rockGym = '<select name="rockGym" class="form-control" required>
                  <option value="">Select Gym</option>
                  <option value="RSpot">Rock Spot</option>
                  <option value="Metro">MetroRock</option>
                  <option value="BKBSomm">BKB</option>
                  <option value="CRG">CRG</option>
                </select>';

?>



<div class="container">

  <div class = "jumbotron">

    <form action="<?php echo $thisScriptName; ?>" method="post">

      <label>Select Gym: </label><br/>
      <?php echo $fld_rockGym; ?>

      <br>
      <button type="submit" class="btn btn-success btn-lg center-block" name="emailPass">Send me my Pass!</button>

    </form>

  </div>

</div>

<div class="container">

  <div class="row">

    <h3 class="text-center">Here is how you've used your passes so far.</h3>

  </div>

  <table class="table table-hover">
    <tr>
      <th>Pass</th>
      <th>Date Used</th>
      <th>Gym Visited</th>
      <th>Status</th>
    </tr>

    <?php

      for ($i=0; $i < 10; $i++) {
        echo "<tr>
                <td>".$passPack[$i]['ID']."</td>
                <td>".$passPack[$i]['dateUsed']."</td>
                <td>".$passPack[$i]['rockGym']."</td>
                <td>".$passPack[$i]['emailSent']."</td>
              </tr>
        ";
      }


     ?>

  </table>

</div>



<?php include("./footer.php");?>
