<?php 


//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


?>
    
<div class="container">

  <div class="jumbotron">

      <h1>Thank You!</h1>
      <br>
      <div class="row">
        <div class="col-md-6">
          <p>Thank you for signing up!  As soon as we have The Rock Pass up and running we will reach out to you and let you know.</p>
        </div>
        <div class="col-md-6">
          <span class="glyphicon glyphicon-thumbs-up" style="font-size: 4em;"></span>
        </div>
      </div> 

  </div>

</div>


<?php include("./footer.php"); ?>