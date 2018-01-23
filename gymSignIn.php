<?php


/***********************************************************************

	STATUS OF PAGE
	- Working

	TO DOs
	- Need to update password match once gyms have created own passwords
	-

************************************************************************/


session_start();

include ( "./header.php" );


//Setting the script name to run when the sign In button is cicked
$thisScriptName = "gymSignIn.php";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Setting login info to blank
$gym_login = "";
$password_login = "";


//Checks to see if anything has been entered in for username, email, or password
if (isset($_POST["password_login"]) && isset($_POST["gym_login"])) {


	//Sets the username and email to what was entered
	$gym_login = $_POST["gym_login"];

	//Sets password to what was entered
	$password_login = $_POST["password_login"];

	//Checks to make sure the password and username are not blank
	if ($password_login != "" && $gym_login != "") {

		//Password is not blank
		//Hashes password
		// $password_login_md5 = md5($password_login);	currently gyms passwords are not hashed and only set to password

		//Finds the entry in users table where username and password match what was entered
		$gym_Select = mysqli_query($dbConnected, "SELECT ID FROM gyms WHERE gymName='$gym_login' AND password='$password_login' LIMIT 1");

		//Counts the number of rows that where found in the users table
		$gymCount = mysqli_num_rows($gym_Select);

		//Verifies there was only one entry
		if ($gymCount == 1) {

			//Sets the session to the username
			$_SESSION["gym_login"] = $gym_login;

			//Starts session and sends users to index page
			session_start();
			// Header is for localhost.  Does not work on live website
			header("location: index");

			// Javascript is for live website.  Does not work on localhost
			// echo '<script type="text/javascript"> window.location="www.therockpass.com/index"; </script>';

		} else {
			//Error message for when more than on entry or no entry is found for the username and password
			$errormsg = "There seems to be a problem with your log in Information.  Please double check your info and try logging in again.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		}


	} else {
		$errormsg = "Please make sure you filled in all the fields.";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'
	      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';
	}

}



$fld_gymname = '<input type="text" class="form-control" value="'.$gym_login.'" name="gym_login" size="30" maxlength="20" required/>';
$fld_password = '<input type="password" class="form-control" name="password_login" size="30" maxlength="20" required/>';

?>


<div class="container">



	<form action="<?php echo $thisScriptName; ?>" method="post">

		<h2>Sign In Below!</h2>
		<h5>Don't have an account, or not a member gym yet? <a class="noDec" href="contact">Send us an Email</a> and we will get it started.</h5>

		<div class="form-group">
			<label for="gymname">Gym Name</label>
			<?php echo $fld_gymname; ?>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<?php echo $fld_password; ?>
		</div>

		<p>Forgot Password or Need Password? Click <a href="./gymForgotPassword">here.</a></p>

		<br>
		<button type="submit" class="btn btn-primary" name="gymSignIn">Sign In!</button>

	</form>


</div>	<!-- container -->



<!-- Below statement includes the footer. -->

<?php  include ( "./footer.php");  ?>
