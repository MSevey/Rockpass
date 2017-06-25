<?php 

/**********************************************************************

	STATUS OF PAGE
 	Working

	TO DOs
	-obscate encode and decode (option for password)


************************************************************************/




session_start();

include("./inc/connectDB.php");  


include ( "./header.php" );


//Identifying Script name to run when save button is clicked
$thisScriptName = "signUp.php";


// Clearing variables so that nothing shows up in the input fields		
$fName = "";
$lName = "";
$username = "";
$email = "";
$password = "";
$password_Confirm = "";
$state = "";

// Setting parameters for file upload
$target_dir = "./img/";
$uploadOk = "";
$profilePic = "";

//Sign Up Button Clicked
if (isset($_POST["signUp"])) {
unset($_POST["signUp"]);

	//Capturing inputs into variables
	$fName = mysql_real_escape_string(@$_POST["fName"]);
	$lName = mysql_real_escape_string(@$_POST["lName"]);
	$username = mysql_real_escape_string(@$_POST["username"]);
	$email = mysql_real_escape_string(@$_POST["email"]);
	$password = mysql_real_escape_string(@$_POST["password"]);
	$password_Confirm = mysql_real_escape_string(@$_POST["password_Confirm"]);
	$state = mysql_real_escape_string(@$_POST["state"]);

	//Capturing image info
	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]); //specifies the path of the file to be uploaded
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //holds the file extension of the file

			
	// Check to see if info is sufficient
	//check if user already exists
	$email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
	$username_check = mysql_query("SELECT username FROM users WHERE username='$username'");
	$emailRow = mysql_num_rows($email_check);
	$usernameRow = mysql_num_rows($username_check);
					
	if ($emailRow == 0) {
	if ($usernameRow == 0) {

		//check all of the fields have been filled in
		if ($fName&&$lName&&$username&&$email&&$state&&$password&&$password_Confirm) {

			//Checks to make sure the username, fname, lname are alphanumeric
			if (ctype_alnum($username)&&ctype_alnum($fName)&&ctype_alnum($lName)) {

				//check that passwords match 
				if ($password == $password_Confirm) {

					//Checking to make sure the password does not contain any other user info
					if(strpos($password, $fName) !== false) {
      					echo '<div class="alert alert-danger text-center" role="alert">Make sure your password does not contain your first name.</div>'; 
					} elseif(strpos($password, $lName) !== false) {
      					echo '<div class="alert alert-danger text-center" role="alert">Make sure your password does not contain your last name.</div>'; 
					} elseif(strpos($password, $username) !== false) {
      					echo '<div class="alert alert-danger text-center" role="alert">Make sure your password does not contain your Username.</div>'; 
					} elseif(strpos($password, $email) !== false) {
      					echo '<div class="alert alert-danger text-center" role="alert">Make sure your password does not contain your email.</div>'; 
					} elseif(strpos($password, "password") !== false) {
      					echo '<div class="alert alert-danger text-center" role="alert">Make sure your password does not contain the word password.</div>'; 
					} else {


						//Checks to make sure the password is at least 8 characters	
						if (strlen($password)>=8) {
							
							//check the maximum length of username/firstname/lastname does not exceed 25 characters
							if (strlen($email)>50||strlen($fName)>20||strlen($lName)>50|strlen($username)>50|strlen($password)>50) {
      							echo '<div class="alert alert-danger text-center" role="alert">Sorry the maximum length for inputs is 50 characters.</div>'; 
							} else {		

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
										    echo '<div class="alert alert-danger text-center" role="alert">Pictures must be less than 500KB.</div>';
										    $uploadOk = 0;
										}

										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
										&& $imageFileType != "gif" ) {
										    echo '<div class="alert alert-danger text-center" role="alert">Make sure your file is a jpg, jpeg, png, or gif format.</div>';
										    $uploadOk = 0;
										}

									} else {
									    echo '<div class="alert alert-danger text-center" role="alert">Something looks wrong with your file.  Please select your image again.</div>';
									    $uploadOk = 0;
									}

									// Check if $uploadOk is set to 0 by an error
									if ($uploadOk == 0) {
									    echo '<div class="alert alert-danger text-center" role="alert">Sorry your file was not uploaded.</div>';

										// if everything is ok, try to upload file
									} else {

										//Changes the filename to a unique name using the current time
										$temp = explode(".", $_FILES["fileToUpload"]["name"]);
										$newfilename = round(microtime(true)) . '.' . end($temp);
										$target_file = $target_dir.$newfilename;

									    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {									
									        $profilePic = $target_file;
									    } else {
									        echo '<div class="alert alert-danger text-center" role="alert">Sorry something went wrong with the upload, please refresh page and try again.</div>';
									    }
									}
									
								$password = md5($password);	

								$users_SQLinsert = "INSERT INTO users (";
								$users_SQLinsert .= "fName, ";	
								$users_SQLinsert .= "lName, ";	
								$users_SQLinsert .= "username, ";	
								$users_SQLinsert .= "email, ";	
								$users_SQLinsert .= "password, ";	
								$users_SQLinsert .= "state, ";
								$users_SQLinsert .= "profilePic ";
								$users_SQLinsert .= ") ";	
								
								$users_SQLinsert .= "VALUES (";	
								$users_SQLinsert .= "'".$fName."', ";
								$users_SQLinsert .= "'".$lName."', ";
								$users_SQLinsert .= "'".$username."', ";
								$users_SQLinsert .= "'".$email."', ";
								$users_SQLinsert .= "'".$password."', ";
								$users_SQLinsert .= "'".$state."', ";
								$users_SQLinsert .= "'".$profilePic."' ";
								$users_SQLinsert .= ") ";			
												
								//Checks to make sure insert statement worked.				
								if (mysql_query($users_SQLinsert)) {

									//Sets the session to the username
									$_SESSION["username_login"] = $username;

									//Starts session and sends users to index page
									session_start();

								    // Header is for localhost.  Does not work on live website
									header("Location: thankYou");

									// Javascript is for live website.  Does not work on localhost
									// echo '<script type="text/javascript"> window.location="www.therockpass.com/thankyou"; </script>';
								   
								} else {
      								echo '<div class="alert alert-danger text-center" role="alert">Oops! Something went wrong. Please reload the page and try again.</div>'; 
									die(mysql_error());
								}										
									
							}
							
						
						} else {
      						echo '<div class="alert alert-danger text-center" role="alert">Please make sure your password is longer than 8 characters.</div>'; 
						}
					}	
			 
				} else {
      				echo '<div class="alert alert-danger text-center" role="alert">Ooo, almost. Please make sure the Passwords match.</div>'; 
				}
	 
			} else {
      			echo '<div class="alert alert-danger text-center" role="alert">Sorry but please only use letters and numbers in your username, first name, and last name.</div>'; 
			}
	 
		} else {
      		echo '<div class="alert alert-danger text-center" role="alert">Please make sure you filled in all the fields.</div>'; 
		}

	} else {
      	echo '<div class="alert alert-danger text-center" role="alert">Someone has already registered with that username.</div>'; 
	}

	} else {
      	echo '<div class="alert alert-danger text-center" role="alert">Someone has already registered with that email address.</div>'; 
	}

} 	
	
?>


<!-- END Save button clicked -->

<?php 


	$fld_fName = '<input type="text" class="form-control" value="'.$fName.'" name="fName" id="fName" size="30" maxlength="20" required/>';
	$fld_lName = '<input type="text" class="form-control" value="'.$lName.'" name="lName" id="lName" size="30" maxlength="50" required/>';
	$fld_username = '<input type="text" class="form-control" value="'.$username.'"  name="username" id="username" size="30" maxlength="50" required/>';
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
			
			<label>State: <span>*</span></label><br/>
	        <?php echo $fld_state; ?>

	        <div class="form-group">
			    <label for="fileToUpload">Select image to upload:</label>
			    <input type="file" name="fileToUpload" id="fileToUpload"> 
			</div>

			<br>
			<button type="submit" class="btn btn-primary" name="signUp">Sign Up!</button>	

	</form>

</div>	
					


<?php include("./footer.php"); ?>