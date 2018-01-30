<?php

include("./chooseHeader.php");


//Identifying Script name to run when contact button is clicked
$thisScriptName = "contact";

// sets error message to an empty highlight_string(str)
$errormsg = "";


//Setting the to email
// $adminEmail = "matt@therockpass.com";
$adminEmail = "";

//Showing User what their current information is, or leaving it blank for someone not signed in.
if ($session) {

	$contactName = "".$userRow['fName']." ".$userRow['lName']."";
	$email = $userRow['email'];

} else {

	$contactName = "";
	$email = "";

}

$subject = "";
$message = "";

if (isset($_POST["contact"])) {
	unset($_POST["contact"]);

	//Grabbing info
	$contactName = mysqli_real_escape_string($dbConnected, @$_POST["contactName"]);
	$email = mysqli_real_escape_string($dbConnected, @$_POST["email"]);
	$subject = mysqli_real_escape_string($dbConnected, @$_POST["subject"]);
	$message = mysqli_real_escape_string($dbConnected, @$_POST["message"]);


	//Checks to make sure all the fields were entered
	if ($contactName && $email && $subject && $message) {

		//Setting Email Parameters
		$to = $adminEmail;
		$subject = $subject;
		$txt = $message;
		$headers = 'From:'.$contactName.' <'.$email.'>' ;


		if (mail($to, $subject, $message, $headers)) {

			$sent = "Yes";

			//Inserting email info into database
			$email_SQLinsert = "INSERT INTO email (";
			$email_SQLinsert .= "fromName, ";
			$email_SQLinsert .= "fromEmail, ";
			$email_SQLinsert .= "subject, ";
			$email_SQLinsert .= "message, ";
			$email_SQLinsert .= "toEmail, ";
			$email_SQLinsert .= "sent ) ";

			$email_SQLinsert .= "VALUES (";
			$email_SQLinsert .= "'".$contactName."', ";
			$email_SQLinsert .= "'".$email."', ";
			$email_SQLinsert .= "'".$subject."', ";
			$email_SQLinsert .= "'".$message."', ";
			$email_SQLinsert .= "'".$to."', ";
			$email_SQLinsert .= "'".$sent."' ) ";

			if (mysqli_query($dbConnected, $email_SQLinsert)) {

				//Displays Success message
				echo '	<div class="alert alert-dismissable alert-success text-center" role="alert">
		          			<strong>Email Sent!</strong>  Thanks for reaching out.  We will get back to you as soon as we can!
			      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';

				exit();

			} else {

				$errormsg = "Oops, something went wrong.  Please reload the page and try again.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
			      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';

			}

		} else {

			$errormsg = "Email was not sent";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
		      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';

		}



	} else {

		$errormsg = "Please fill in all the fields";
		echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
          			'.$errormsg.'
	      			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>';

	}

}



	$fld_contactName = '<input type="text" class="form-control" value="'.$contactName.'" name="contactName" id="contactName" maxlength="50" placeholder="Name" required />';
	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" maxlength="50" placeholder="Email" required />';
	$fld_subject = '<input type="text" class="form-control" value="'.$subject.'"  name="subject" id="subject" maxlength="50" placeholder="Subject" required />';
	$fld_message = '<textarea type="textarea" class="form-control" value="'.$message.'"  name="message" id="message" rows="7" maxlength="500" placeholder="Message"></textarea>';


?>


<!-- User Input Form -->
<div class="container">


	<form action="<?php echo $thisScriptName; ?>" method="post">

			<h3>Contact Us</h3>
   			<!-- <p>Need to reach out about something? Send us a message!</p> -->
   			<p>This site is not supported anymore.</p>

			<!-- <div class="form-group">
				<label for="contactName">Name</label>
				<?php echo $fld_contactName; ?>
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<?php echo $fld_email; ?>
			</div>

			<div class="form-group">
				<label for="subject">Subject</label>
				<?php echo $fld_subject; ?>
			</div>

			<div class="form-group">
				<label for="message">Message</label>
				<?php echo $fld_message; ?>
			</div>


			<br>
			<button type="submit" class="btn btn-primary" name="contact">Contact Us!</button> -->

	</form>

</div>



<?php include("./footer.php"); ?>
