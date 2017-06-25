<?php 

include("../chooseHeader.php");

// //Checks to see if the update button was clicked
// if (isset($_POST["update"])) {
// unset($_POST["update"]);

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
					//have page reload so that if the user refreshes the page it does not resubmit the form

		        	// Header is for localhost.  Does not work on live website
					header("Location: ../accountSettings");

					// Javascript is for live website.  Does not work on localhost
					// echo '<script type="text/javascript"> window.location="www.therockpass.com/account"; </script>';

						
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
		

		$users_Update = "UPDATE users ";
	  	$users_Update .= "SET fName='$fName', lName='$lName', username='$username', email='$email', state='$state'  ";
	 	$users_Update .= "WHERE email='$originalEmail' ";

						
		//Checks to make sure update statement worked.				
		if (mysql_query($users_Update)) {

			echo '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong>  Your info was updated!</div>';
				
		} else {

			echo '<div class="alert alert-danger text-center" role="alert">Oops, looks liks something did not update.  Try reloading the page and trying again.</div>';
				
		}										
	}
}



?>