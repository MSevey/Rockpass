<?php

/*********************************************
  STATUS OF PAGE

  Working
  This page will eventually change to be where people can purchase passes

  TO DO
  1) Right now they get a warning that there are still passes in their name
      - Need a way from them to confirm and continue with the purchase

*********************************************/



//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


// This is used with the form field below so that when click the script runs again.
$thisScriptName = "reloadPasses";

// sets error message to an empty highlight_string(str)
$errormsg = "";


if(isset($_POST["reloadPasses"])) {

  if($passNumRows == 0) {

    for ($i=0; $i < 10; $i++) {

      $passes_SQLinsert = "INSERT INTO passes (userID) VALUES ($userID)";

      if (mysql_query($passes_SQLinsert)) {


      } else {
        $errormsg = "Oops! Something went wrong. Please reload the page and try again.";
        echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                  '.$errormsg.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';

        echo "<br>";
        echo $i;

      }

    }

    $datePurchasedInfo = mysql_query("SELECT * FROM passes WHERE emailSent IS NULL LIMIT 1");
    $datePurchasedRow = mysql_fetch_array($datePurchasedInfo);
    $datePurchased = $datePurchasedRow['datePurchased'];

    $dateUpdate = "UPDATE passes SET datePurchased='$datePurchased' WHERE userID='$userID' AND emailSent IS NULL";

    if (mysql_query($dateUpdate)) {

      echo '<div class="row">
              <div class="col-xs-12">
                <h3 class="bg-success test-success text-center">Passes Reloaded, get to Climbing!</h3>
              </div>
            </div>';

    } else {

      $errormsg = "Oops, something went Wrong and did not update right.  Try Reloading the page.";
      echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                '.$errormsg.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';

    }

  } else {

    // $errormsg = "It looks like you have passes still.  Are you sure you want to buy more?";
    $errormsg = "It looks like you have passes still.  Please use your current passes before you buy more?";
    echo '  <div class="alert alert-dismissable alert-warning text-center" role="alert">
              '.$errormsg.'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';

  }

} else {}


?>

  <div class="container">

    <div class="jumbotron">

        <h1>Need more passes?</h1>
        <h3>Click below for a reload!</h3>
        <br>

      <div class="row">
        <form action="<?php echo $thisScriptName; ?>" method="post">
          <!-- <div class="form-group">
            <label for="referralCode">Referral Code?</label>
            <input type="text" class="form-control" value="referralCode" name="referralCode"/>
          </div>

          <div class="checkbox">
            <label><input type="checkbox" name="accessFund" value="Yes"> Donate $1 to the Access Fund?</label>
          </div> -->

          <button type="submit" class="btn btn-primary btn-lg center-block" name="reloadPasses" id="reloadPasses">
            Reload Passes
          </button>
        </form>
      </div>


    </div>

  </div>



<?php include("./footer.php"); ?>
