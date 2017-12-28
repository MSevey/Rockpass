<?php

/************************************************

	STATUS OF PAGE
	Working

	TO DOs
	1)

************************************************/



//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
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

			$password = mysql_real_escape_string(@$_POST["password"]);
			$password_Confirm = mysql_real_escape_string(@$_POST["password_Confirm"]);

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

						$password = mysql_real_escape_string(@$_POST["password"]);
						$password_Confirm = mysql_real_escape_string(@$_POST["password_Confirm"]);

						$password = md5($password);

						$users_Update = "UPDATE users ";
				      	$users_Update .= "SET password='$password'  ";
				     	$users_Update .= "WHERE email='$originalEmail' ";

				     	//Checks to make sure update statement worked.
						if (mysql_query($users_Update)) {


							echo '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong>  Your info was updated!</div>';

						} else {

							echo '<div class="alert alert-danger text-center" role="alert">Oops, looks liks something did not update.  Try reloading the page and trying again.</div>';

						}
					}

				} else {

					echo '<div class="alert alert-danger text-center" role="alert">Please make sure your passwords match.</div>';

				}

			} else {


				$fName = mysql_real_escape_string(@$_POST["fName"]);
				$lName = mysql_real_escape_string(@$_POST["lName"]);
				$username = mysql_real_escape_string(@$_POST["username"]);
				$email = mysql_real_escape_string(@$_POST["email"]);
				$state = mysql_real_escape_string(@$_POST["state"]);
				$job = mysql_real_escape_string(@$_POST["job"]);


				$users_Update = "UPDATE users ";
			  	$users_Update .= "SET fName='$fName', lName='$lName', username='$username', email='$email', state='$state', job='$job'  ";
			 	$users_Update .= "WHERE email='$originalEmail' ";


				//Checks to make sure update statement worked.
				if (mysql_query($users_Update)) {
					$_SESSION["username_login"] = $username;
					echo '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong>  Your info was updated!</div>';

				} else {

					echo '<div class="alert alert-danger text-center" role="alert">Oops, looks liks something did not update.  Try reloading the page and trying again.</div>';

				}
			}
		}

// For Updating Profile Picture
	// Setting parameters for file upload
	$target_dir = "./img/";
	$uploadOk = "";
	$profilePic = $userRow['profilePic'];;

	// Checking if upload button was clicked
	if (isset($_POST["upload"])) {
		unset($_POST["upload"]);

		//Capturing image info
		$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]); //specifies the path of the file to be uploaded
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //holds the file extension of the file

		//Checking if image is an actual image
		$imgCheck = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($imgCheck !== false) {
			$uploadOk = 1;

			//Checking to see if file already exists
			if (file_exists($target_file)) {
				$uploadOk = 0;
			}

			 // Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				$errormsg = "Pictures must be less than 500KB.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			    $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$errormsg = "Make sure your file is a jpg, jpeg, png, or gif format.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			    $uploadOk = 0;
			}

		} else {
			$errormsg = "Something looks wrong with your file.  Please select your image again.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$errormsg = "Sorry your file was not uploaded.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';

			// if everything is ok, try to upload file
		} else {

			//Changes the filename to a unique name using the current time
			$temp = explode(".", $_FILES["fileToUpload"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$target_file = $target_dir.$newfilename;

		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        $profilePic = $target_file;
		        $profilePic_Update = "UPDATE users SET profilePic='$profilePic' WHERE username='$username'";

		        if (mysql_query($profilePic_Update)) {

					echo '	<div class="alert alert-dismissable alert-success text-center" role="alert">
			          			<strong>Success!</strong>  Your profile picture was uploaded!
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';

		        } else {
		        	$errormsg = "Sorry something went wrong with updating your information, please refresh page and try again.";
					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
			          			'.$errormsg.'
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
		        }
		    } else {
		        $errormsg = "Sorry something went wrong with the upload, please refresh page and try again.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
		    }
		}
	}

	$fld_profilePic = '<img src="'.$profilePic.'" class="img-circle img-responsive" id="profilePic" alt="Responsive image">';

// For updating climbing stats
	$preferedStyle = $userData['preferedStyle'];
	$boulderinglvl = $userData['boulderingLvl'];
	$topRopinglvl = $userData['topRopingLvl'];
	$leadinglvl = $userData['leadingLvl'];
	$yearsClimbing = $userData['yearsClimbing'];

	// Checking if climbing update stats button was clicked
		if (isset($_POST["stats"])) {
			unset($_POST["stats"]);

			// Pulling in selections from dropdowns
				$preferedStyle = mysql_real_escape_string(@$_POST["preferedStyle"]);
				$boulderinglvl = mysql_real_escape_string(@$_POST["boulderinglvl"]);
				$topRopinglvl = mysql_real_escape_string(@$_POST["topRopinglvl"]);
				$leadinglvl = mysql_real_escape_string(@$_POST["leadinglvl"]);
				$yearsClimbing = mysql_real_escape_string(@$_POST["yearsClimbing"]);

			// Updating userdata
				$userData_update = "UPDATE userdata ";
				$userData_update .= "SET boulderingLvl='$boulderinglvl', topRopingLvl='$topRopinglvl', ";
				$userData_update .= 	"leadingLvl='$leadinglvl', preferedStyle='$preferedStyle', ";
				$userData_update .= 	"yearsClimbing='$yearsClimbing' ";
				$userData_update .= "WHERE userID='$userID'";

			if (mysql_query($userData_update)) {

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

			if (mysql_query($userHobbies_update)) {

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
			<!-- <li role="presentation"><a href="#profilePic" aria-controls="profilePic" role="tab" data-toggle="tab">Profile Picture</a></li> -->
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

	   			<div class="row">
					<form action="<?php echo $thisScriptName; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
						    <label for="fileToUpload">Update Profile Picture:</label>
						    <input type="file" name="fileToUpload" id="fileToUpload">
						</div>

						<button type="submit" class="btn btn-primary" name="upload">Upload!</button>
					</form>
				</div>

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
							<?php echo $userData['boulderingLvl']; ?>
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

						<!-- Looking for new friends/partners
								this would enable sending notification of matches in stead of just displaying suggestions
							-->

						<br>
						<button type="submit" class="btn btn-primary" name="stats">Update Stats!</button>

					</form>

				</div>

			</div>
			<div role="tabpanel" class="tab-pane" id="hobbies">

				<div class="col-sm-6">

					<h3>What are your Hobbies?</h3>

					<form action="<?php echo $thisScriptName; ?>" method="post">

						<!-- This should insert a row for the user then change columns from NULL to 1 or yes -->
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
