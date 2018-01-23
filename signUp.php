<?php

/**********************************************************************

	STATUS OF PAGE
 	Edited 12/15/15 to only ask for email and password and state

	TO DOs
	-obscate encode and decode (option for password)
	-direct to profile page after and have alert asking for additional info
	-Add ability to sign in with facebook



************************************************************************/




session_start();

include("./inc/connectDB.php");


include ( "./header.php" );


//Identifying Script name to run when save button is clicked
$thisScriptName = "signUp.php";

// sets error message to an empty highlight_string(str)
$errormsg = "";

// Clearing variables so that nothing shows up in the input fields
$username = "";
$email = "";
$password = "";
$password_Confirm = "";
$state = "";
$referralCode = "";

//Sign Up Button Clicked
if (isset($_POST["signUp"])) {
unset($_POST["signUp"]);

	//Capturing inputs into variables
	$email = mysqli_real_escape_string($dbConnected, @$_POST["email"]);
	$password = mysqli_real_escape_string($dbConnected, @$_POST["password"]);
	$password_Confirm = mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"]);
	$state = mysqli_real_escape_string($dbConnected, @$_POST["state"]);
	$username = $email;


	// Check to see if info is sufficient
	//check if user already exists
	$email_check = mysqli_query($dbConnected, "SELECT email FROM users WHERE email='$email'");
	$emailRow = mysqli_num_rows($email_check);

	if ($emailRow == 0) {

		//check all of the fields have been filled in
		if ($email&&$state&&$password&&$password_Confirm) {

				//check that passwords match
				if ($password == $password_Confirm) {

					//Checking to make sure the password does not contain any other user info
					if(strpos($password, $email) !== false) {
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
							if (strlen($email)>50||strlen($password)>50) {
								$errormsg = "Sorry the maximum length for inputs is 50 characters.";
		      					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
						          			'.$errormsg.'
						          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';
							} else {

								$password = md5($password);

								for ($i=0; $i < 6; $i++) {
									$randomValue = substr("abcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0,35), 1);
									$referralCode = $referralCode.$randomValue;
								}

								$users_SQLinsert = "INSERT INTO users (";
								$users_SQLinsert .= "username, ";
								$users_SQLinsert .= "email, ";
								$users_SQLinsert .= "password, ";
								$users_SQLinsert .= "state, ";
								$users_SQLinsert .= "referralCode ";
								$users_SQLinsert .= ") ";

								$users_SQLinsert .= "VALUES (";
								$users_SQLinsert .= "'".$username."', ";
								$users_SQLinsert .= "'".$email."', ";
								$users_SQLinsert .= "'".$password."', ";
								$users_SQLinsert .= "'".$state."', ";
								$users_SQLinsert .= "'".$referralCode."' ";
								$users_SQLinsert .= ") ";

								//Checks to make sure insert statement worked.
								if (mysqli_query($dbConnected, $users_SQLinsert)) {

									//Sets the session to the username
									$_SESSION["username_login"] = $username;

									//Starts session and sends users to index page
									session_start();

								    // Header is for localhost.  Does not work on live website
									header("Location: account");

									// Javascript is for live website.  Does not work on localhost
									// echo '<script type="text/javascript"> window.location="www.therockpass.com/account"; </script>';

								} else {
									$errormsg = "Oops! Something went wrong. Please reload the page and try again.";
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
			$errormsg = "Please make sure you filled in all the fields.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		}

	} else {
		$errormsg = "Someone has already registered with that email address.";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'
	      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';
	}

}

?>


<!-- END Save button clicked -->

<?php


	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" size="30" maxlength="50" required/>';
	$fld_password = '<input type="password" class="form-control" value="'.$password.'"  name="password" id="password" size="30" maxlength="50" required/>';
	$fld_password_Confirm = '<input type="password" class="form-control" value="'.$password_Confirm.'"  name="password_Confirm" id="password_Confirm" size="30" maxlength="50" required/>';
	$fld_state = '<select name="state" class="form-control" required>
			            <option value="AL">AL</option>
			            <option value="AK">AK</option>
			            <option value="AZ">AZ</option>
			            <option value="AR">AR</option>
			            <option value="CA">CA</option>
			            <option value="CO">CO</option>
			            <option value="CT">CT</option>
			            <option value="DE">DE</option>
			            <option value="DC">DC</option>
			            <option value="FL">FL</option>
			            <option value="GA">GA</option>
			            <option value="HI">HI</option>
			            <option value="ID">ID</option>
			            <option value="IL">IL</option>
			            <option value="IN">IN</option>
			            <option value="IA">IA</option>
			            <option value="KS">KS</option>
			            <option value="KY">KY</option>
			            <option value="LA">LA</option>
			            <option value="ME">ME</option>
			            <option value="MD">MD</option>
			            <option value="MA">MA</option>
			            <option value="MI">MI</option>
			            <option value="MN">MN</option>
			            <option value="MS">MS</option>
			            <option value="MO">MO</option>
			            <option value="MT">MT</option>
			            <option value="NE">NE</option>
			            <option value="NV">NV</option>
			            <option value="NH">NH</option>
			            <option value="NJ">NJ</option>
			            <option value="NM">NM</option>
			            <option value="NY">NY</option>
			            <option value="NC">NC</option>
			            <option value="ND">ND</option>
			            <option value="OH">OH</option>
			            <option value="OK">OK</option>
			            <option value="OR">OR</option>
			            <option value="PA">PA</option>
			            <option value="RI">RI</option>
			            <option value="SC">SC</option>
			            <option value="SD">SD</option>
			            <option value="TN">TN</option>
			            <option value="TX">TX</option>
			            <option value="UT">UT</option>
			            <option value="VT">VT</option>
			            <option value="VA">VA</option>
			            <option value="WA">WA</option>
			            <option value="WV">WV</option>
			            <option value="WI">WI</option>
			            <option value="WY">WY</option>
			        </select>';

?>

<!-- User Input Form -->
<div class="container">


	<form action="<?php echo $thisScriptName; ?>" method="post" enctype="multipart/form-data">


			<h3>Sign Up!</h3>
   			<p>Start climbing where you want, when you want!</p>


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

			<label>State: <span>*</span></label><br/>
	        <?php echo $fld_state; ?>


			<br>
			<button type="submit" class="btn btn-primary" name="signUp">Sign Up!</button>

	</form>

</div>



<?php include("./footer.php"); ?>
