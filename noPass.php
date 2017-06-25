<?php 

//**************************************
//
//  STATUS OF PAGE
//
//  Working
//
//
//
//*************************************



//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");
  

?>

<div class="container">

  <div class="jumbotron">

      <h1>Oops!</h1>
      <br>
      <div class="row">
        <div class="col-md-6">
          <p>It looks like you are all out of Passes.  Please purchase another pack of passes so you can get back to climbing!</p>
        </div>
        <div class="col-md-6">
          <span class="glyphicon glyphicon-thumbs-up" style="font-size: 4em;"></span>
        </div>
      </div> 

  </div>

  <div class="row">
    <p class="text-center">If you need more passes click <a href="reloadPasses">here!</a></p>
  </div>

</div>



<?php include("./footer.php"); ?>