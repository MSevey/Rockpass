<?php 


//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


?>
    
<div class="container">

  <div class="jumbotron">

    <div class="btn-group-vertical" role="group" aria-label="...">

      <button type="button" class="btn btn-default" id="emailReport">Email Report</button>
      <button type="button" class="btn btn-default" id="passesPurchased">Passes Purchased</button>
      <button type="button" class="btn btn-default" id="totalUsers">Total Users</button>
      <button type="button" class="btn btn-default" id="popularGym">Most visited Gym</button>
      <button type="button" class="btn btn-default" id="first50">First 50 Users</button> 
      <button type="button" class="btn btn-default" id="peakHours">Peak Hours</button>
      <button type="button" class="btn btn-default" id="slackUsers">Inconsistent Users</button>
      <button type="button" class="btn btn-default" id="monthTrends">Monthly Trends</button>
      <a href="./gymPayment">Gym Payment</a>
    </div>

  </div>

  <div class="jumbotron">

    <div id="reportDiv"></div>

  </div>



</div>


<script>

  // Emails all Users in a selected State
  $("#emailReport").click(function() {
     $("#reportDiv").load("./reports/emailUsers.php");
  });

  // Pulls total number of passes purchased
  $("#passesPurchased").click(function() {
     $("#reportDiv").load("./reports/passesPurchased.php");
  });

  // Pulls total users
  $("#totalUsers").click(function() {
     $("#reportDiv").load("./reports/totalUsers.php");
  });

  // Identifies most popular gym based on passes used
  $("#popularGym").click(function() {
     $("#reportDiv").load("./reports/popularGym.php");
  });

  // Identifyied first fifty users
  $("#first50").click(function() {
     $("#reportDiv").load("./reports/first50.php");
  });

  // Identifies the peak hours passes are used
  $("#peakHours").click(function() {
     $("#reportDiv").load("./reports/peakHours.php");
  });

  // Identifies the users who haven't used passes in last month
  //  Also finds people that haven't purchased a pass in a month
  $("#slackUsers").click(function() {
     $("#reportDiv").load("./reports/slackUsers.php");
  });

  //  Also finds people that haven't purchased a pass in a month
  $("#monthTrends").click(function() {
     $("#reportDiv").load("./reports/monthTrends.php");
  });

</script>


<?php include("./footer.php"); ?>