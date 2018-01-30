<?php

include("./chooseHeader.php");

$today = date("M-d-Y");
$gym = "MetroRock";


?>

<div class="container">

  <h1>Get Ready to Crush Climbs!!</h1>

  <h3>Your pass is validate for <?php echo $today; ?> at <?php echo $gym; ?>.</h3>

  <div class="row">

    <div class="col-md-6">

      This should be the person picture

    </div>

    <div class="col-md-6">

      <p>Please show this email at <?php echo $gym; ?> and go crush come climbs!</p>

    </div>

  </div>

</div>

<?php
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
    <h3>Your pass is validate for ".$today." at ".$gym."</h3>
    <div>
      <div>
        This should be the person picture
      </div>
      <div>
        <p>Please show this email at ".$gym." and go crush come climbs!</p>
      </div>
    </div>
  </div>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <passes@therockpass.com>' . "\r\n";
$headers .= 'Cc: matt@therockpass.com' . "\r\n";

mail($to,$subject,$message,$headers);
?>




<?php include("./footer.php"); ?>
