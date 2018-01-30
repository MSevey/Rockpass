<?php

  include("./chooseHeader.php");

  $thisScriptName = "delete";
  $errormsg = "";

  // Checks to see if Yes was clicked
    if (isset($_POST["yes"])) {
      unset($_POST["yes"]);

      if (mysqli_query($dbConnected, "DELETE FROM hobbies WHERE userID='$userID'")) {

        if (mysqli_query($dbConnected, "DELETE FROM passes WHERE userID='$userID'")) {

          if (mysqli_query($dbConnected, "DELETE FROM userdata WHERE userID='$userID'")) {

            if (mysqli_query($dbConnected, "DELETE FROM matches WHERE matchedUserID='$userID' OR primaryUserID='$userID'")) {

              if (mysqli_query($dbConnected, "DELETE FROM users WHERE ID='$userID'")) {
                header("location: inc/logout");

              } else {
                $errormsg = "Something went wrong with deleting your account";
                echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
                '.$errormsg.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
              }

            } else {
              $errormsg = "Something went wrong with deleting your matches";
              echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
              '.$errormsg.'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>';
            }

          } else {
            $errormsg = "Something went wrong with deleting your userdata";
            echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
            '.$errormsg.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
          }

        } else {
          $errormsg = "Something went wrong with deleting your passes";
          echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          '.$errormsg.'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
        }

      } else {
        $errormsg = "Something went wrong with deleting your hobbies";
        echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
        '.$errormsg.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
      }

    }

  // Checks to see if No was clicked
    if (isset($_POST["no"])) {
      unset($_POST["no"]);

      header("location: account");

    }

?>

<div class="container">

  <form action="<?php echo $thisScriptName; ?>" method="post">
    <h2>Are you sure?</h2>
    <button type="submit" class="btn btn-danger" name="yes">Yes</button>
    <button type="submit" class="btn btn-primary" name="no">No</button>
  </form>

</div>


<?php include("./footer.php"); ?>
