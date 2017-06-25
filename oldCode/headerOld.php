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
    <title>The Rock Pass</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- My javascript -->
    <script type="js/myScript.js"></script>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

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


    </style>

  </head>

  <body>
    
    <!-- This is the navbar that is fixed to the top of the Screen -->
    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="./index">The Rock Pass</a>

      
          <ul class="nav navbar-nav collapse navbar-collapse pull-right" id="menu">
            <li><a href="./signUp">Sign Up!</a></li>
            <li><a href="./signIn">Sign In</a></li>
            <li><a href="./contact">Contact Us</a></li>
          </ul> 

        </div>

      </div><!-- /.container-fluid -->

    </nav>
