<?php

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

    <title>Welcome back <?php echo $username; ?>!</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- My javascript -->
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- My Code Files -->
    <link rel="stylesheet" type="text/css" href="./css/myCSS.css">


  </head>

  <body>

    <!-- This is the navbar that is fixed to the top of the Screen -->
    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

          <!-- This is the Brand and the link to the index page -->
          <a class="navbar-brand" href="./account">The Rock Pass</a>

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

        <a href="./account" class="list-group-item"><?php echo $username; ?></a>
        <a href="./passesRedirect" class="list-group-item">Passes<span class="badge"><?php echo $passNumRows; ?></span></a>
        <a href="./reloadPasses" class="list-group-item">Buy more Passes</a>
        <a href="./gyms" class="list-group-item">Gyms</a>
        <a href="./faq" class="list-group-item">FAQ</a>
        <a href="./contact" class="list-group-item">Contact Us</a>
        <a href="./inc/logout" class="list-group-item">Log Out</a>

      </div>
