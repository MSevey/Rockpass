<?php 


//Contains connectDB.php and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");
  

?>
    
    <div class="container">

      <div class="jumbotron">

          <h1>Like to Climb?</h1>
          <br>
          <div class="row">
            <div class="col-md-6">
              <p>Do you like to climb but hate having to pick between climbing with friends and finding the closest gym?</p>
            </div>
            <div class="col-md-6">
              <span class="glyphicon glyphicon-thumbs-up" style="font-size: 4em;"></span>
            </div>
          </div> 

      </div>

      <div class="jumbotron">

          <h1>Which is the Best Gym?</h1>
          <br>
          <p>Where is the best bouldering?</p>
          <p>Where is the best top roping?</p>
          <p>Where has the best lead climbing??</p>

      </div>

      <div class="jumbotron">

          <h1>Have it all!</h1>
          <br>
          <p>With the Rock Pass you can have it all!  The Rock Pass allows you to go to any rock gym!  No more choosing between bouldering and leading, friends and convience.  Climb whenever, wherever.</p>
          <p><a class="btn btn-primary btn-lg" href="./signUp.php" data-toggle="modal" role="button">Learn more</a></p>

      </div>

    </div>




<?php include("./footer.php"); ?>