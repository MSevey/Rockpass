<?php

/************************************************

	STATUS OF PAGE
	Users can update any field all at once or one at a time

	TO DOs
	1) Have warning for any missing information of the user in the user table
		a) Have this warning pop up from the header user file so that the user sees it no matter what page they are on.
		b) This should force them to always have all the info filled in.


************************************************/



//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


//Identifying Script name to run when update button is clicked
$thisScriptName = "gymAccountSettings";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Grabbing Current User email
$originalName = $gymRow['gymName'];

//Showing User what their current information is. Password is hidden
$gymName = $gymRow['gymName'];
$stAddress = $gymRow['stAddress'];
$zipCode = $gymRow['zipCode'];
$email = $gymRow['email'];
$phone = $gymRow['phone'];
$password = "password";
$password_Confirm = "password";
$state = $gymRow['state'];


//Checks to see if the update button was clicked
if (isset($_POST["update"])) {
unset($_POST["update"]);


	//Checks to make sure that the password and password confirm fields are equal to each other
	if (mysqli_real_escape_string($dbConnected, @$_POST["password"]) == mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"])) {

		$password = mysqli_real_escape_string($dbConnected, @$_POST["password"]);
		$password_Confirm = mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"]);

		//Checking to make sure the password does not contain any other user info
		if(strpos($password, $gymRow['gymName']) !== false) {
			$errormsg = "Make sure your password does not contain your gym name.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		} elseif(strpos($password, $gymRow['stAddress']) !== false) {
			$errormsg = "Make sure your password does not contain your St Address.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		} elseif(strpos($password, $gymRow['zipCode']) !== false) {
			$errormsg = "Make sure your password does not contain your Zip Code.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		} elseif(strpos($password, $gymRow['email']) !== false) {
			$errormsg = "Make sure your password does not contain your email.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		} elseif(strpos($password, $gymRow['phone']) !== false) {
			$errormsg = "Make sure your password does not contain your phone number.";
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

			$password = md5($password);

			$gyms_Update = "UPDATE gyms ";
	      	$gyms_Update .= "SET password='$password'  ";
	     	$gyms_Update .= "WHERE gymName='$originalName' ";

	     	//Checks to make sure update statement worked.
			if (mysqli_query($dbConnected, $gyms_Update)) {

				//echo "success";

			} else {

				$errormsg = "Oops, looks liks something did not update.  Try reloading the page and trying again.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';

			}
		}

	} else {

		$errormsg = "Please make sure your passwords match.";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'
          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';

	}



	$gymName = mysqli_real_escape_string($dbConnected, @$_POST["gymName"]);
	$stAddress = mysqli_real_escape_string($dbConnected, @$_POST["stAddress"]);
	$zipCode = mysqli_real_escape_string($dbConnected, @$_POST["zipCode"]);
	$email = mysqli_real_escape_string($dbConnected, @$_POST["email"]);
	$phone = mysqli_real_escape_string($dbConnected, @$_POST["phone"]);
	$state = mysqli_real_escape_string($dbConnected, @$_POST["state"]);

	$gyms_Update = "UPDATE gyms ";
  	$gyms_Update .= "SET gymName='$gymName', stAddress='$stAddress', zipCode='$zipCode' email='$email', phone='$phone' state='$state'  ";
 	$gyms_Update .= "WHERE gymName='$originalName' ";


	//Checks to make sure update statement worked.
	if (mysqli_query($dbConnected, $gyms_Update)) {

		echo '	<div class="alert alert-dismissable alert-success text-center" role="alert">
          			<strong>Success!</strong>  Your info was updated!
          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';

	} else {

		$errormsg = "Oops, looks liks something did not update.  Try reloading the page and trying again.";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'
          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';

	}

}


?>


<?php

	$fld_gymName = '<input type="text" class="form-control" value="'.$gymName.'" name="gymName" id="gymName" size="30" maxlength="20" />';
	$fld_stAddress = '<input type="text" class="form-control" value="'.$stAddress.'"  name="stAddress" id="stAddress" size="30" maxlength="50"/>';
	$fld_zipCode = '<input type="text" class="form-control" value="'.$zipCode.'"  name="zipCode" id="zipCode" size="30" maxlength="50"/>';
	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" size="30" maxlength="50"/>';
	$fld_phone = '<input type="text" class="form-control" value="'.$phone.'"  name="phone" id="phone" size="30" maxlength="50"/>';
	$fld_password = '<input type="password" class="form-control" value="'.$password.'"  name="password" id="password" size="30" maxlength="50"/>';
	$fld_password_Confirm = '<input type="password" class="form-control" value="'.$password_Confirm.'"  name="password_Confirm" id="password_Confirm" size="30" maxlength="50"/>';
	$fld_state = '<select name="state" class="form-control">
			            <option value="'.$state.'">'.$state.'</option>
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


	<form action="<?php echo $thisScriptName; ?>" method="post">


			<h3>Account Settings</h3>
   			<p>Update the info below.</p>

			<div class="form-group">
				<label for="gymName">Gym Name</label>
				<?php echo $fld_gymName; ?>
			</div>

			<div class="form-group">
				<label for="stAddress">St Address</label>
				<?php echo $fld_stAddress; ?>
			</div>

			<div class="form-group">
				<label for="zipCode">Zip Code</label>
				<?php echo $fld_zipCode; ?>
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<?php echo $fld_email; ?>
			</div>

			<div class="form-group">
				<label for="phone">Phone Number</label>
				<?php echo $fld_phone; ?>
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
			<button type="submit" class="btn btn-primary">Update Info!</button>

	</form>

</div>



<?php include("./footer.php"); ?>
