<?php

/*****************************************
  STATUS OF PAGE

  This page pulls the MA based gyms and displays them in a table.
  It pulls MA based on the users state

  TO DOs
  -add state drop down so people can select a state
  -eventually this will be an interactive map with the
    gym locations on it (google maps plugin)


******************************************/


//Contains connectDB.php and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


if (isset($_SESSION["username_login"])) {

  $state = $userRow['state'];

} elseif (isset($_SESSION["gym_login"])) {

  $state = $gymRow['state'];

} else {

  $state = "MA";

}


$gymState = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$state'");
$gymStateNum = mysqli_num_rows($gymState);

for ($i=0; $i < $gymStateNum; $i++) {

  $gymInfo = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$state' LIMIT 1 OFFSET $i");
  $gym = mysqli_fetch_array($gymInfo);

  $gymArray[$i]['gymName'] = $gym['gymName'];
  $gymArray[$i]['state'] = $gym['state'];
  $gymArray[$i]['stAddress'] = $gym['stAddress'];
  $gymArray[$i]['zipCode'] = $gym['zipCode'];
  $gymArray[$i]['phone'] = $gym['phone'];

}


?>

<div class="container">

  <div>

    <h3>Here are all the Gyms in your area.</h3>
    <br>
  </div>

  <table class="table table-hover">
    <tr>
      <th>Gym</th>
      <th>Street Address</th>
      <th>Zip Code</th>
      <th>State</th>
      <th>Phone number</th>
    </tr>

    <?php

      for ($i=0; $i < $gymStateNum; $i++) {
        echo "<tr>
                <td>".$gymArray[$i]['gymName']."</td>
                <td>".$gymArray[$i]['stAddress']."</td>
                <td>".$gymArray[$i]['zipCode']."</td>
                <td>".$gymArray[$i]['state']."</td>
                <td>".$gymArray[$i]['phone']."</td>
              </tr>
        ";
      }


     ?>

  </table>

  <div class="row">

    <p>**Currently The Rock Pass is only available in MA.</p>

  </div>

</div>




<?php include("./footer.php"); ?>
