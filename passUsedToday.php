<?php

include("./chooseHeader.php");

// This is used with the form field below so that when click the script runs again.
$thisScriptName = "passUsedToday";

// sets error message to an empty highlight_string(str)
$errormsg = "";

$today = date("D-m-Y");

if (isset($_POST["emailPass"])) {

  $to = "mjsevey@gmail.com";
  $subject = "Your Rock Pass";
  $message = "
  <html>
  <head>
  <title>Pass Email</title>
  </head>
  <body>
    <div>
      <h1>Get Ready to Crush Climbs!!</h1>
      <h3>Your pass is validate for ".$today." at ".$usedPassRow['rockGym']."</h3>
      <div>
        <div>
          This should be the person picture
        </div>
        <div>
          <p>Please show this email at ".$usedPassRow['rockGym']." and go crush come climbs!</p>
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
    $errormsg = "Oops there seems to be a problem.  The Email did not send.";
    echo '  <div class="alert alert-dismissable alert-danger text-center" role="alert">
                '.$errormsg.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
  }

}



 ?>

<div class="container">

  <div class="jumbotron">

      <h1>You've already crushed climbs today!</h1>
      <br>
      <div class="row">
        <div class="col-md-6">
          <p>Our records show that you have already used a pass today.  If this is wrong please contact us.</p>
        </div>
        <div class="col-md-6">
          <span class="glyphicon glyphicon-thumbs-up" style="font-size: 4em;"></span>
        </div>
      </div>

  </div>

  <div class="row">

    <div class="col-xs-12">
      <h3>Your pass should be in your inbox.  If you can't find the email, click the button below to resend your pass.</h3>
    </div>

    <form action="<?php echo $thisScriptName; ?>" method="post">
      <button type="submit" class="btn btn-success btn-lg center-block" name="emailPass">
        Send me my Pass!
      </button>
    </form>

  </div>

</div>


<?php include("./footer.php"); ?>
