<?php 

/***************************************************

	Email all user in the selected state

**************************************************/

include("../inc/connectDB.php");

//This is the report to pull total users
$totalUsers = mysql_query("SELECT * FROM users");
//$totalUsersRow = mysql_fetch_array($totalUsers);
$totalUsersRowCount = mysql_num_rows($totalUsers);


//Identifying Script name to run when contact button is clicked
$thisScriptName = "reports/emailUsers";
 

//Setting the to email
$adminEmail = "matt@therockpass.com";
$admin = "Matt";
$subject = "";
$message = "";
$state = "";

if (isset($_POST["emailUsers"])) {
	unset($_POST["emailUsers"]);
	
	//Grabbing info
	$subject = mysql_real_escape_string(@$_POST["subject"]);
	$message = mysql_real_escape_string(@$_POST["message"]);
	$state = mysql_real_escape_string(@$_POST["state"]);


	//Checks to make sure all the fields were entered
	if ($subject && $message) {

		// For loop will cycle through all the users in the DB
		for ($i=0; $i < $totalUsersRowCount; $i++) { 

			$user = mysql_query("SELECT * FROM users LIMIT 1 OFFSET $i");
			$userData = mysql_fetch_array($user);

			if ($userData['state'] == $state) {

				//Setting Email Parameters
				$to = $userData['email'];
				$subject = $subject;
				$txt = $message;
				$headers = 'From: '.$admin.' <'.$adminEmail.'>' ;
				
				if (mail($to, $subject, $message, $headers)) {

			
				} else {

					//$errormsg = "Email was not sent";
					echo '<div class="alert alert-danger text-center" role="alert">Email was not sent.</div>';

				}

			}

		}

		header("Location: ../admin");
		
	} else {

		//$errormsg = "Please fill in all the fields";
		echo '<div class="alert alert-danger text-center" role="alert">Please fill in all the fields.</div>';

	}

}

	
	$fld_subject = '<input type="text" class="form-control" value="'.$subject.'"  name="subject" id="subject" maxlength="50" placeholder="Subject" required />';
	$fld_message = '<textarea type="textarea" class="form-control" value="'.$message.'"  name="message" id="message" rows="7" maxlength="500" placeholder="Message"></textarea>';
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

 	
	<form action="<?php echo $thisScriptName; ?>" method="post">
		
		<h3>Email Users</h3>
			<p>Send a Message to all the Users.</p>

		<div class="form-group">
			<label>State: </label><br/>
	        <?php echo $fld_state; ?>
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
		<button type="submit" class="btn btn-primary" name="emailUsers">Email Users</button>	

	</form>

</div>	
		