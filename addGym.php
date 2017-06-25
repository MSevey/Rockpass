<?php 

//***********************************************************************
//
//	STATUS OF PAGE
// 
//	Lets admin add gyms
//
//************************************************************************




//Contains connectDB.php, session_start and decides which header to display
//Also contains $userRow and $password which are the users info from the users table and their last entry in the passes table
include("./chooseHeader.php");


//Identifying Script name to run when save button is clicked
$thisScriptName = "addGym.php";

// sets error message to an empty highlight_string(str)
$errormsg = ""; 


// Clearing variables so that nothing shows up in the input fields		
$gymName = "";
$state = "";
$shortName = "";
$stAddress = "";
$zipCode = "";
$email = "";
$phone = "";
	

//Sign Up Button Clicked
if (isset($_POST["addGym"])) {
unset($_POST["addGym"]);

	//Capturing inputs into variables
	$gymName = mysql_real_escape_string(@$_POST["gymName"]);
	$state = mysql_real_escape_string(@$_POST["state"]);
	$shortName = mysql_real_escape_string(@$_POST["shortName"]);
	$stAddress = mysql_real_escape_string(@$_POST["stAddress"]);
	$zipCode = mysql_real_escape_string(@$_POST["zipCode"]);
	$email = mysql_real_escape_string(@$_POST["email"]);
	$phone = mysql_real_escape_string(@$_POST["phone"]);
			
	// Check to see if info is sufficient
	//check if gym already exists
	$gym_check = mysql_query("SELECT gymName FROM gyms WHERE shortName='$shortName'");
	$gymRow = mysql_num_rows($gym_check);
					
	if ($gymRow == 0) {

		//check all of the fields have been filled in
		if ($gymName&&$state&&$shortName&&$stAddress&&$zipCode&&$email&&$phone) {
											
			//check the maximum length of username/firstname/lastname does not exceed 25 characters
			if (strlen($email)>50||strlen($gymName)>50||strlen($shortName)>50||strlen($stAddress)>100) {
					$errormsg = "Sorry the maximum length for inputs is 50 characters and 100 characters for st addresses."; 
  					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
			          			'.$errormsg.'
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>'; 
			} else {																													
					
				$gym_SQLinsert = "INSERT INTO gyms (";
				$gym_SQLinsert .= "gymName, ";	
				$gym_SQLinsert .= "state, ";		
				$gym_SQLinsert .= "shortName, ";	
				$gym_SQLinsert .= "stAddress, ";	
				$gym_SQLinsert .= "zipCode, ";	
				$gym_SQLinsert .= "email, ";	
				$gym_SQLinsert .= "phone ";	
				$gym_SQLinsert .= ") ";	
				
				$gym_SQLinsert .= "VALUES (";	
				$gym_SQLinsert .= "'".$gymName."', ";	
				$gym_SQLinsert .= "'".$state."', ";	
				$gym_SQLinsert .= "'".$shortName."', ";	
				$gym_SQLinsert .= "'".$stAddress."', ";	
				$gym_SQLinsert .= "'".$zipCode."', ";	
				$gym_SQLinsert .= "'".$email."', ";	
				$gym_SQLinsert .= "'".$phone."' ";	
				$gym_SQLinsert .= ") ";
								
				//Checks to make sure insert statement worked.				
				if (mysql_query($gym_SQLinsert)) {

					echo '<div class="alert alert-success text-center" role="alert">Gym info uploaded.</div>';
					echo '<div class="container"><a href="./addGym">Add another gym.</a></div>';
					exit();
				   
				} else {
					$errormsg = "Oops! Something went wrong."; 
  					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
			          			'.$errormsg.'
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>'; 
					die(mysql_error());
				}										
								
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
		$errormsg = "There is already a Gym register with that info."; 
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


	$fld_gymName = '<input type="text" class="form-control" value="'.$gymName.'" name="gymName" id="gymName" required/>';
	$fld_shortName = '<input type="text" class="form-control" value="'.$shortName.'" name="shortName" id="shortName" required/>';
	$fld_stAddress = '<input type="text" class="form-control" value="'.$stAddress.'" name="stAddress" id="stAddress" required/>';
	$fld_zipCode = '<input type="text" class="form-control" value="'.$zipCode.'"  name="zipCode" id="zipCode" required/>';
	$fld_email = '<input type="text" class="form-control" value="'.$email.'"  name="email" id="email" required/>';
	$fld_phone = '<input type="text" class="form-control" value="'.$phone.'"  name="phone" id="phone" required/>';
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

		
			<h3>Add Gym</h3>
   			<p>Enter in new gym information below.</p>

			<div class="form-group">
				<label for="gymName">Gym Name</label>
				<?php echo $fld_gymName; ?>
			</div>

			<div class="form-group">
				<label for="shortName">Gym Short Name</label>
				<?php echo $fld_shortName; ?>
			</div>

			<div class="form-group">
				<label for="stAddress">Street Address</label>
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
			
			<label>State: <span>*</span></label><br/>
	        <?php echo $fld_state; ?>

			<br>
			<button type="submit" class="btn btn-primary" name="addGym">Add Gym</button>	

	</form>

</div>	
					


<?php include("./footer.php"); ?>