<?php


//***********************************************************************
//
//	STATUS OF PAGE
//
//	1)  Need to understand what if statement with isset is really doing
//		a) Does that also execute the isset command?
//		b) Right now it is getting an error when trying to log in with only your email as it still executes the username code.
//
//************************************************************************


session_start();

include("./inc/connectDB.php");

include ( "./header.php" );


//Setting the script name to run when the sign In button is cicked
$thisScriptName = "signIn.php";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Setting login info to blank
$username_login = "";
$password_login = "";


//Checks to see if signIn has been clicked
if (isset($_POST["signIn"])) {
	unset($_POST["signIn"]);

	//Sets the username and email to what was entered
	$username_login = mysqli_real_escape_string($dbConnected, @$_POST["username_login"]);

	//Sets password to what was entered
	$password_login = mysqli_real_escape_string($dbConnected, @$_POST["password_login"]);

	//Checks to make sure the password and username are not blank
	if ($password_login != "" && $username_login != ""){

		//Password is not blank
		//Hashes password
		$password_login_md5 = md5($password_login);

		//Finds the entry in users table where username and password match what was entered
		$users_Select = mysqli_query($dbConnected, "SELECT * FROM users WHERE username='$username_login' AND password='$password_login_md5' LIMIT 1");

		//Counts the number of rows that were found in the users table
		$userCount = mysqli_num_rows($users_Select);

		//Verifies there was only one entry
		if ($userCount == 1) {

			//Sets the session to the username
			$_SESSION["username_login"] = $username_login;

			//Starts session and sends users to index page
			session_start();
			// Header is for localhost.  Does not work on live website
			header("location: index");

			// Javascript is for live website.  Does not work on localhost
			// echo '<script type="text/javascript"> window.location="www.therockpass.com/index"; </script>';

		} else {

			//Finds the entry in users table where email and password match what was entered
			$users_Select = mysqli_query($dbConnected, "SELECT * FROM users WHERE email='$username_login' AND password='$password_login_md5' LIMIT 1");
			$users_Select_Row = mysqli_fetch_array($users_Select);

			//Counts the number of rows that where found in the users table
			$userCount = mysqli_num_rows($users_Select);

			if ($userCount == 1) {

				//Grabbing users Username since they logged in with email and redefining $username_login
				$username_login = $users_Select_Row['username'];

				//Sets the session to the username
				$_SESSION["username_login"] = $username_login;

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

		}


	} else {
		$errormsg = "Please fill in all the fields!";
      	echo '	<div class="alert alert-dismissable alert-warning text-center" role="alert">
          			'.$errormsg.'
          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';
	}

}



$fld_username = '<input type="text" class="form-control" value="'.$username_login.'" name="username_login" size="30" maxlength="20" required/>';
$fld_password = '<input type="password" class="form-control" value="'.$password_login.'" name="password_login" size="30" maxlength="20" required/>';

?>


<div class="container">


	<form action="<?php echo $thisScriptName; ?>" method="post">

		<h2>Sign In Below!</h2>
		<h5>Don't have an account?<a class="noDec" href="signUp">Sign up here</a></h5>

		<div class="form-group">
			<label for="username">Username or Email</label>
			<?php echo $fld_username; ?>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<?php echo $fld_password; ?>
		</div>

		<p>Forgot Password or Need Password? Click <a href="./forgotPassword">here.</a></p>

		<br>
		<button type="submit" class="btn btn-primary" name="signIn">Sign In!</button>

	</form>

</div>



<!-- Below statement includes the footer. -->

<?php  include ( "./footer.php");  ?>
