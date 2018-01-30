<?php

include("./chooseHeader.php");


//Identifying Script name to run when update button is clicked
$thisScriptName = "accountSettings";

// sets error message to an empty highlight_string(str)
$errormsg = "";

// For Updating general settings
	//Grabbing Current User email
		$originalEmail = $userRow['email'];

	//Showing User what their current information is. Password is hidden
		$fName = $userRow['fName'];
		$lName = $userRow['lName'];
		$username = $userRow['username'];
		$email = $userRow['email'];
		$password = "*****";
		$password_Confirm = "*****";
		$state = $userRow['state'];
		$job = $userRow['job'];

	// Checks to see if the update button was clicked
		if (isset($_POST["update"])) {
			unset($_POST["update"]);

			$password = mysqli_real_escape_string($dbConnected, @$_POST["password"]);
			$password_Confirm = mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"]);

			//Checking if password was changed or not
			if ($password != "*****") {


				//Checks to make sure that the password and password confirm fields are equal to each other
				if ($password == $password_Confirm) {

					//Checking to make sure the password does not contain any other user info
					if(strpos($password, $userRow['fName']) !== false) {
						$errormsg = "Make sure your password does not contain your first name.";
						echo '<div class="alert alert-danger text-center" role="alert">'.$errormsg.'.</div>';
					} elseif(strpos($password, $userRow['lName']) !== false) {
						$errormsg = "Make sure your password does not contain your last name.";
						echo '<div class="alert alert-danger text-center" role="alert">'.$errormsg.'.</div>';
					} elseif(strpos($password, $userRow['username']) !== false) {
						$errormsg = "Make sure your password does not contain your Username.";
						echo '<div class="alert alert-danger text-center" role="alert">'.$errormsg.'.</div>';
					} elseif(strpos($password, $userRow['email']) !== false) {
						$errormsg = "Make sure your password does not contain your email.";
						echo '<div class="alert alert-danger text-center" role="alert">'.$errormsg.'.</div>';
					} elseif(strpos($password, "password") !== false) {
						$errormsg = "Make sure your password does not contain the word password.";
						echo '<div class="alert alert-danger text-center" role="alert">'.$errormsg.'.</div>';
					} else {

						$password = mysqli_real_escape_string($dbConnected, @$_POST["password"]);
						$password_Confirm = mysqli_real_escape_string($dbConnected, @$_POST["password_Confirm"]);

						$password = md5($password);

						$users_Update = "UPDATE users ";
				      	$users_Update .= "SET password='$password'  ";
				     	$users_Update .= "WHERE email='$originalEmail' ";

				     	//Checks to make sure update statement worked.
						if (mysqli_query($dbConnected, $users_Update)) {


							echo '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong>  Your info was updated!</div>';

						} else {

							echo '<div class="alert alert-danger text-center" role="alert">Oops, looks liks something did not update.  Try reloading the page and trying again.</div>';

						}
					}

				} else {

					echo '<div class="alert alert-danger text-center" role="alert">Please make sure your passwords match.</div>';

				}

			} else {


				$fName = mysqli_real_escape_string($dbConnected, @$_POST["fName"]);
				$lName = mysqli_real_escape_string($dbConnected, @$_POST["lName"]);
				$username = mysqli_real_escape_string($dbConnected, @$_POST["username"]);
				$email = mysqli_real_escape_string($dbConnected, @$_POST["email"]);
				$state = mysqli_real_escape_string($dbConnected, @$_POST["state"]);
				$job = mysqli_real_escape_string($dbConnected, @$_POST["job"]);


				$users_Update = "UPDATE users ";
			  	$users_Update .= "SET fName='$fName', lName='$lName', username='$username', email='$email', state='$state', job='$job'  ";
			 	$users_Update .= "WHERE email='$originalEmail' ";


				//Checks to make sure update statement worked.
				if (mysqli_query($dbConnected, $users_Update)) {
					$_SESSION["username_login"] = $username;
					echo '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong>  Your info was updated!</div>';

				} else {

					echo '<div class="alert alert-danger text-center" role="alert">Oops, looks liks something did not update.  Try reloading the page and trying again.</div>';

				}
			}
		}

	$fld_profilePic = '<img src="'.$profilePic.'" class="img-circle img-responsive" id="profilePic" alt="Responsive image">';

// Climbing Ratings
	$climbs = [
		'0' => '5.0',
		'1' => '5.1',
		'2' => '5.2',
		'3' => '5.3',
		'4' => '5.4',
		'5' => '5.5',
		'6' => '5.6',
		'7' => '5.7',
		'8' => '5.8',
		'9' => '5.9',
		'10' => '5.10a',
		'11' => '5.10b',
		'12' => '5.10c',
		'13' => '5.10d',
		'14' => '5.11a',
		'15' => '5.11b',
		'16' => '5.11c',
		'17' => '5.11d',
		'18' => '5.12a',
		'19' => '5.12b',
		'20' => '5.12c',
		'21' => '5.12d',
		'22' => '5.13a',
		'23' => '5.13b',
		'24' => '5.13c',
		'25' => '5.13d',
		'26' => '5.14a',
		'27' => '5.14b',
		'28' => '5.14c',
		'29' => '5.14d',
		'30' => '5.15a',
		'31' => '5.15b',
		'32' => '5.15c',
		'33' => '5.15d'
	];

	$boulders = [
		'0' => 'V0',
		'1' => 'V1',
		'2' => 'V2',
		'3' => 'V3',
		'4' => 'V4',
		'5' => 'V5',
		'6' => 'V6',
		'7' => 'V7',
		'8' => 'V8',
		'9' => 'V9',
		'10' => 'V10',
		'11' => 'V11',
		'12' => 'V12',
		'13' => 'V13',
		'14' => 'V14'
	];

// For updating climbing stats
	$preferedStyle = $userData['preferedStyle'];
	$boulderinglvl = $boulders[$userData['boulderinglvl']];
	$topRopinglvl = $climbs[$userData['topRopinglvl']];
	$leadinglvl = $climbs[$userData['leadinglvl']];
	$yearsClimbing = $userData['yearsClimbing'];

	// Checking if climbing update stats button was clicked
		if (isset($_POST["stats"])) {
			unset($_POST["stats"]);

			// Pulling in selections from dropdowns
				$preferedStyle = mysqli_real_escape_string($dbConnected, @$_POST["preferedStyle"]);
				$boulderinglvl = mysqli_real_escape_string($dbConnected, @$_POST["boulderinglvl"]);
				$topRopinglvl = mysqli_real_escape_string($dbConnected, @$_POST["topRopinglvl"]);
				$leadinglvl = mysqli_real_escape_string($dbConnected, @$_POST["leadinglvl"]);
				$yearsClimbing = mysqli_real_escape_string($dbConnected, @$_POST["yearsClimbing"]);

			// Updating userdata
				$userData_update = "UPDATE userdata ";
				$userData_update .= "SET boulderingLvl='$boulderinglvl', topRopingLvl='$topRopinglvl', ";
				$userData_update .= 	"leadingLvl='$leadinglvl', preferedStyle='$preferedStyle', ";
				$userData_update .= 	"yearsClimbing='$yearsClimbing' ";
				$userData_update .= "WHERE userID='$userID'";

			if (mysqli_query($dbConnected, $userData_update)) {

				echo '	<div class="alert alert-dismissable alert-success text-center" role="alert">
		          			<strong>Success!</strong> Your climbing stats have been updated!
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';

			} else {
	        	$errormsg = "Sorry something went wrong with updating your climbing stats, please refresh page and try again.";
						echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
				          			'.$errormsg.'
				          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
	        }

		}

// For updating Hobbies in DB
	$rockClimbing = $userHobbies['rockClimbing'];
	$iceClimbing = $userHobbies['iceClimbing'];
	$hiking = $userHobbies['hiking'];
	$camping = $userHobbies['camping'];

	// Checking if hobbies update button was clicked
		if (isset($_POST["hobbies"])) {
			unset($_POST["hobbies"]);

			// Identifying which check boxes are checked
				if (isset($_POST["rockClimbing"])) {
					$rockClimbing = $_POST["rockClimbing"];
				} else {
					$rockClimbing = 0;
				}
				if (isset($_POST["iceClimbing"])) {
					$iceClimbing = $_POST["iceClimbing"];
				} else {
					$iceClimbing = 0;
				}
				if (isset($_POST["hiking"])) {
					$hiking = $_POST["hiking"];
				} else {
					$hiking = 0;
				}
				if (isset($_POST["camping"])) {
					$camping = $_POST["camping"];
				} else {
					$camping = 0;
				}

			// UPdate userData Table only for newly checked boxes
				$userHobbies_update = "UPDATE hobbies ";
				$userHobbies_update .= "SET rockClimbing='$rockClimbing', iceClimbing='$iceClimbing', hiking='$hiking', camping='$camping' ";
				$userHobbies_update .= "WHERE userID='$userID'";

			if (mysqli_query($dbConnected, $userHobbies_update)) {

				echo '	<div class="alert alert-dismissable alert-success text-center" role="alert">
		          			<strong>Success!</strong> Your hobbies have been updated!
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';

			} else {
	        	$errormsg = "Sorry something went wrong with updating your hobbies, please refresh page and try again.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
	        }

		}
/***********************************************************************************************************************************************/

// Input fields for general settings
	$fld_fName = '<input type="text" class="form-control" value="'.$fName.'" name="fName" id="fName" size="30" maxlength="20" />';
	$fld_lName = '<input type="text" class="form-control" value="'.$lName.'" name="lName" id="lName" size="30" maxlength="50"/>';
	$fld_username = '<input type="text" class="form-control" value="'.$username.'"  name="username" id="username" size="30" maxlength="50"/>';
	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" size="30" maxlength="50"/>';
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
	$fld_job = '<select name="job" class="form-control" required>
		            <option value="'.$job.'">'.$job.'</option>
					<option value="Student">Student</option>
		            <option value="Engineer">Engineer</option>
		            <option value="Teacher">Teacher</option>
		            <option value="Marketing">Marketing</option>
		            <option value="Retail">Retail</option>
		        </select>';

// Input fields for Climbing Stats
	$fld_preferedStyle =   '<select name="preferedStyle" class="form-control" required>
					            <option value="'.$preferedStyle.'">'.$preferedStyle.'</option>
								<option value="Bouldering">Bouldering</option>
					            <option value="Top Roping">Top Roping</option>
					            <option value="Lead Climbing">Lead Climbing</option>
					        </select>';
	$fld_boulderinglvl =   '<select name="boulderinglvl" class="form-control" required>
					            <option value="'.$boulderinglvl.'">'.$boulderinglvl.'</option>
								<option value="0">V0</option>
								<option value="1">V1</option>
								<option value="2">V2</option>
								<option value="3">V3</option>
								<option value="4">V4</option>
								<option value="5">V5</option>
								<option value="6">V6</option>
								<option value="7">V7</option>
								<option value="8">V8</option>
								<option value="9">V9</option>
								<option value="10">V10</option>
								<option value="11">V11</option>
								<option value="12">V12</option>
								<option value="13">V13</option>
								<option value="14">V14</option>
					        </select>';
	$fld_topRopinglvl  =   '<select name="topRopinglvl" class="form-control" required>
					            <option value="'.$topRopinglvl.'">'.$topRopinglvl.'</option>
								<option value="0">5.0</option>
								<option value="1">5.1</option>
								<option value="2">5.2</option>
								<option value="3">5.3</option>
								<option value="4">5.4</option>
								<option value="5">5.5</option>
								<option value="6">5.6</option>
								<option value="7">5.7</option>
								<option value="8">5.8</option>
								<option value="9">5.9</option>
								<option value="10a">5.10a</option>
								<option value="11">5.10b</option>
								<option value="12">5.10c</option>
								<option value="13">5.10d</option>
								<option value="14">5.11a</option>
								<option value="15">5.11b</option>
								<option value="16">5.11c</option>
								<option value="17">5.11d</option>
								<option value="18">5.12a</option>
								<option value="19">5.12b</option>
								<option value="20">5.12c</option>
								<option value="21">5.12d</option>
								<option value="22">5.13a</option>
								<option value="23">5.13b</option>
								<option value="24">5.13c</option>
								<option value="25">5.13d</option>
								<option value="26">5.14a</option>
								<option value="27">5.14b</option>
								<option value="28">5.14c</option>
								<option value="29">5.14d</option>
								<option value="30">5.15a</option>
								<option value="31">5.15b</option>
								<option value="32">5.15c</option>
								<option value="33">5.15d</option>
					        </select>';
	$fld_leadinglvl =	   '<select name="leadinglvl" class="form-control" required>
					            <option value="'.$leadinglvl.'">'.$leadinglvl.'</option>
								<option value="0">5.0</option>
								<option value="1">5.1</option>
								<option value="2">5.2</option>
								<option value="3">5.3</option>
								<option value="4">5.4</option>
								<option value="5">5.5</option>
								<option value="6">5.6</option>
								<option value="7">5.7</option>
								<option value="8">5.8</option>
								<option value="9">5.9</option>
								<option value="10a">5.10a</option>
								<option value="11">5.10b</option>
								<option value="12">5.10c</option>
								<option value="13">5.10d</option>
								<option value="14">5.11a</option>
								<option value="15">5.11b</option>
								<option value="16">5.11c</option>
								<option value="17">5.11d</option>
								<option value="18">5.12a</option>
								<option value="19">5.12b</option>
								<option value="20">5.12c</option>
								<option value="21">5.12d</option>
								<option value="22">5.13a</option>
								<option value="23">5.13b</option>
								<option value="24">5.13c</option>
								<option value="25">5.13d</option>
								<option value="26">5.14a</option>
								<option value="27">5.14b</option>
								<option value="28">5.14c</option>
								<option value="29">5.14d</option>
								<option value="30">5.15a</option>
								<option value="31">5.15b</option>
								<option value="32">5.15c</option>
								<option value="33">5.15d</option>
					        </select>';
	$fld_yearClimbing =    '<input type="text" class="form-control" value="'.$yearsClimbing.'" name="yearsClimbing" id="yearsClimbing"/>';

// Input fields for Hobbies
	// Displaying previously selected hobbies as checked checkboxes
	if ($rockClimbing == 1) {
		$fld_rockClimbing = '<label><input type="checkbox" name="rockClimbing" value="1"  checked="checked"> Rock Climbing</label>';
	} else {
		$fld_rockClimbing = '<label><input type="checkbox" name="rockClimbing" value="1"> Rock Climbing</label>';
	}
	if ($iceClimbing == 1) {
		$fld_iceClimbing = '<label><input type="checkbox" name="iceClimbing" value="1" checked="checked"> Ice Climbing</label>';
	} else {
		$fld_iceClimbing = '<label><input type="checkbox" name="iceClimbing" value="1"> Ice Climbing</label>';
	}
	if ($hiking == 1) {
		$fld_hiking = '<label><input type="checkbox" name="hiking" value="1" checked="checked"> Hiking</label>';
	} else {
		$fld_hiking = '<label><input type="checkbox" name="hiking" value="1"> Hiking</label>';
	}
	if ($camping == 1) {
		$fld_camping ='<label><input type="checkbox" name="camping" value="1" checked="checked"> Camping</label>';
	} else {
		$fld_camping ='<label><input type="checkbox" name="camping" value="1"> Camping</label>';
	}

?>

<!-- put options into tabs -->

<div class="wrapper">

	<div class="container">

		<!-- Nav tabs -->
		<br>
		<ul class="nav nav-pills" role="tablist">
			<li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
			<li role="presentation"><a href="#climbingStats" aria-controls="climbingStats" role="tab" data-toggle="tab">Climbing Stats</a></li>
			<li role="presentation"><a href="#hobbies" aria-controls="hobbies" role="tab" data-toggle="tab">Hobbies</a></li>
			<li><a href="./account">Back to Account</a></li>
		</ul>



		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="general">

				<div class="col-sm-6">

					<h3>General Settings</h3>
		   			<p>Update the info below.</p>

					<form action="<?php echo $thisScriptName; ?>" method="post">

						<div class="form-group">
							<label for="fName">First Name</label>
							<?php echo $fld_fName; ?>
						</div>

						<div class="form-group">
							<label for="lName">Last Name</label>
							<?php echo $fld_lName; ?>
						</div>

						<div class="form-group">
							<label for="username">Username</label>
							<?php echo $fld_username; ?>
						</div>

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

						<label>State: </label>
				        <?php echo $fld_state; ?>
				        <br>

						<label>Job: </label>
				        <?php echo $fld_job; ?>


						<br>
						<button type="submit" class="btn btn-primary" name="update">Update Info!</button>

					</form>

				</div>

			</div>
			<div role="tabpanel" class="tab-pane" id="profilePic">

				<h3>Profile Picture</h3>

	   			<?php if ($userRow['profilePic'] != "") : ?>
	   				<div class="row">
	   					<div class="col-sm-4"><?php echo $fld_profilePic; ?></div>
	   				</div>
	   			<?php endif; ?>

	   			<br>

			</div>
			<div role="tabpanel" class="tab-pane" id="climbingStats">

				<div class="col-sm-6">

					<h3>What type of Climber are you?</h3>

					<form action="<?php echo $thisScriptName; ?>" method="post">

						<div class="form-group">
							<label for="preferedStyle">Favorite Climbing Style</label>
							<?php echo $fld_preferedStyle; ?>
						</div>

						<div class="form-group">
							<label for="boulderinglvl">Bouldering Level</label>
							<?php echo $fld_boulderinglvl; ?>
						</div>

						<div class="form-group">
							<label for="topRopinglvl">Top Roping Level</label>
							<?php echo $fld_topRopinglvl; ?>
						</div>

						<div class="form-group">
							<label for="leadinglvl">Lead Climbing Level</label>
							<?php echo $fld_leadinglvl; ?>
						</div>

						<div class="form-group">
							<label for="yearsClimbing"># Years Climbing</label>
							<?php echo $fld_yearClimbing; ?>
						</div>

						<br>
						<button type="submit" class="btn btn-primary" name="stats">Update Stats!</button>

					</form>

				</div>

			</div>
			<div role="tabpanel" class="tab-pane" id="hobbies">

				<div class="col-sm-6">

					<h3>What are your Hobbies?</h3>

					<form action="<?php echo $thisScriptName; ?>" method="post">

						<div class="checkbox">
							<?php echo $fld_rockClimbing; ?>
						</div>
						<div class="checkbox">
							<?php echo $fld_iceClimbing; ?>
						</div>
						<div class="checkbox">
							<?php echo $fld_hiking; ?>
						</div>
						<div class="checkbox">
							<?php echo $fld_camping; ?>
						</div>

						<button type="submit" class="btn btn-primary" name="hobbies">Submit</button>

					</form>

				</div>

			</div>
		</div>

	</div>

</div>


<?php include("./footer.php"); ?>
