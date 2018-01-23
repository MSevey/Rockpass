<?php

/************************************************

	STATUS OF PAGE
	Working


************************************************/



//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


//Identifying Script name to run when update button is clicked
$thisScriptName = "forgotPassword";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Setting Password fields to blank
$email = "";
$password = "";
$password_Confirm = "";


//Checks to see if the save button was clicked
if (isset($_POST["save"])) {
unset($_POST["save"]);

	//Capturing inputs into variables
	$email = mysqli_real_escape_string($dbConnected, @$_POST["email"]);
	$password = mysqli_real_escape_string($dbConnected, @$_POST["password"]);
	$password_Confirm = mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"]);

	// Check to see if info is sufficient
	//check if user already exists
	$userInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE email='$email'");
	$userRow = mysqli_fetch_array($userInfo);

	if ($userRow != 0) {

		//check all of the fields have been filled in
		if ($email&&$password&&$password_Confirm) {


				//check that passwords match
				if ($password == $password_Confirm) {

					//Checking to make sure the password does not contain any other user info
					if(strpos($password, $userRow['fName']) !== false) {
						$errormsg = "Make sure your password does not contain your first name.";
      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
					} elseif(strpos($password, $userRow['lName']) !== false) {
						$errormsg = "Make sure your password does not contain your last name.";
      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
					} elseif(strpos($password, $userRow['username']) !== false) {
						$errormsg = "Make sure your password does not contain your Username.";
      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
					} elseif(strpos($password, $userRow['email']) !== false) {
						$errormsg = "Make sure your password does not contain your email.";
      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
					} elseif(strpos($password, "password") !== false) {
						$errormsg = "Make sure your password does not contain the word password.";
      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
					} else {


						//Checks to make sure the password is at least 8 characters
						if (strlen($password)>=8) {

							//check the maximum length of username/firstname/lastname does not exceed 25 characters
							if (strlen($password)>50) {

								$errormsg = "Your Password can not be longer than 50 characters.";
		      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
						          			'.$errormsg.'
						          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';

							} else {

								$password = md5($password);

								// Change to Update statement
								$users_Update = "UPDATE users ";
						      	$users_Update .= "SET password='$password' ";
						     	$users_Update .= "WHERE email='$email' ";


								//Checks to make sure insert statement worked.
								if (mysqli_query($dbConnected, $users_Update)) {
								    // Header is for localhost.  Does not work on live website
									//header("Location: thankYou");

									// Javascript is for live website.  Does not work on localhost
									// echo '<script type="text/javascript"> window.location="www.therockpass.com/thankyou"; </script>';

									echo '<div class="container">

											  <div class="jumbotron">

											      <h1>Success!</h1>
											      <br>
											      <div class="row">
											        <div class="col-md-6">
											          <p>Your password was successfully updated!  Head back and <a href="./signIn">Sign In!</a></p>
											        </div>
											        <div class="col-md-6">
											          <span class="glyphicon glyphicon-thumbs-up" style="font-size: 4em;"></span>
											        </div>
											      </div>

											  </div>

											</div>';

									include("./footer.php");
									exit();

								} else {
									$errormsg = "Your Password failed in update. Please reload the page and try again.";
			      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
							          			'.$errormsg.'
							          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>';
									die(mysqli_error());
								}

							}


						} else {
							$errormsg = "Please make sure your password is longer than 8 characters.";
	      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
					          			'.$errormsg.'
					          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						}
					}

				} else {
					$errormsg = "Ooo, almost. Please make sure the Passwords match.";
  					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
			          			'.$errormsg.'
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
				}

		} else {
			$errormsg = "Please fill in all required fields.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		}

	} else {
		$errormsg = "We do not have that email address on file.  Please go back to the ";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'<a href="./signUp" class="alert-link">Sign Up Page.</a>
          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';
	}

}




	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" size="30" maxlength="50" required/>';
	$fld_password = '<input type="password" class="form-control" value="'.$password.'"  name="password" id="password" size="30" maxlength="50" required/>';
	$fld_password_Confirm = '<input type="password" class="form-control" value="'.$password_Confirm.'"  name="password_Confirm" id="password_Confirm" size="30" maxlength="50" required/>';


?>

<!-- User Input Form -->
<div class="container">


	<form action="<?php echo $thisScriptName; ?>" method="post">


			<h3>Update Password</h3>
   			<p>Enter in your new Password.</p>

			<div class="form-group">
				<label for="email">Email</label>
				<?php echo $fld_email; ?>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<?php echo $fld_password; ?>
			</div>

			<div class="form-group">
				<label for="password_Confirm">Confirm Password</label>
				<?php echo $fld_password_Confirm; ?>
			</div>

			<br>
			<button type="submit" class="btn btn-primary" name="save">Save</button>

	</form>

</div>



<?php include("./footer.php"); ?>
