<?php 

//***********************************************************************
//
//  STATUS OF PAGE
// 
//  1) Need to make all links fit in one drop down on the right of the navber.  Should be a 3 bar icon if possible.  Otherwise just "username"
//
//************************************************************************

 
 
ob_start();

date_default_timezone_set('America/New_York');

include("./inc/connectDB.php");

 ?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Welcome back <?php echo $username; ?>!</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- My javascript -->

    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script src="./js/myScript.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>

      body {
        padding-top: 50px;
      }

      .navbar-header {
        width: 100%;
      }

      .jumbotron {
        background-color: white;
      }

      .navbar-menu-toggle {
        position: relative;
        float: right;
        padding: 9px 10px;
        margin-top: 8px;
        margin-right: 15px;
        margin-bottom: 8px;
        background-color: transparent;
        background-image: none;
        border: 1px solid #fff;
        border-radius: 4px;
      }
      .navbar-menu-toggle:focus {
        outline: 0;
      }
      .navbar-menu-toggle .icon-bar {
        display: block;
        width: 22px;
        height: 2px;
        border-radius: 1px;
      }
      .navbar-menu-toggle .icon-bar + .icon-bar {
        margin-top: 4px;
      }

      .icon-bar {
        background-color: #fff;
      }

      #menu {
        position: absolute;
        top: 50px;
        right: 0;
        display: none;
      }


    </style>

  </head>

  <body>
    
    <!-- This is the navbar that is fixed to the top of the Screen -->
    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

          <!-- This is the Brand and the link to the index page -->
          <a class="navbar-brand" href="./index">The Rock Pass</a>

          <!-- This is the button to toggle the side bar menu -->
          <button type="button" class="navbar-menu-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>

      </div><!-- /.container-fluid -->

    </nav>


      <div id="menu" class="list-group col-md-3">
              <!-- Change the number 14 to the number of passes available -->
        <a href="./passesRedirect" class="list-group-item">Passes<span class="badge">14</span></a>
        <a href="./accountSettings" class="list-group-item">Account</a>
        <a href="./contact" class="list-group-item">Contact Us</a>
        <a href="./inc/logout" class="list-group-item">Log Out</a>
        <a href="./admin" class="list-group-item">Admin</a>
        <a href="./addGym" class="list-group-item">Add Gym</a>
        <a href="./test" class="list-group-item">test page</a>
        
      </div>

<script>

  $(".navbar-menu-toggle").click(function() {
    $("#menu").slideToggle("fast");
  });



</script>