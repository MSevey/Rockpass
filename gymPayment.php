<?php 

/*******************************************************************
	STATUS OF PAGE
	-query for pulling passes used in a given month works
	-Dropdown selections work

	TO DO
	1) Have it run based off of the year (Drop down or just always)
		- Show all passes used grouped by month (total) - gym (total) - users (total)

	-Make Automated
	-Show which users went to each gym.


*********************************************************************/

include("./chooseHeader.php");


//	Identifying Script name to run when submit button is clicked
$thisScriptName = "gymPayment.php";

//	Clearing Variables
$FOM = "";
$NFOM = "";
$gym = "";
$month = "";
$nextMonth = "";
$gymRate = "";

//	Checks to see if the submit button was clicked.
if (isset($_POST["submit"])) {
	unset($_POST["submit"]);


	//Capturing inputs into variables
	$month = mysql_real_escape_string(@$_POST["month"]);
	$gym = mysql_real_escape_string(@$_POST["gym"]);

	/*First of the Month*/
	$FOM = date("Y-$month-01");
	echo '$FOM is '.$FOM;
	
	echo "<br>";

	/*Next first of the Month*/
	$nextMonth = $month + 1;
	$NFOM = date("Y-$nextMonth-01");
	echo '$NFOM is '.$NFOM;
	
	echo "<br>";

	$gymQuery = mysql_query("SELECT * FROM gyms WHERE shortName='$gym'");
	$gymRow = mysql_fetch_array($gymQuery);
	$gymRate = $gymRow['dayRate'];

	echo $gym.' has a day rate of $'.$gymRate;
	echo "<br>";

	/*************************************************************	
	NEEDED VARIABLES

	1) users who used passes last month and which gyms they went to

	***************************************************************/


	// PULL ALL PASSES USED LAST MONTH
	$passesUsed = mysql_query("SELECT * FROM passes WHERE (dateUsed BETWEEN '$FOM' AND '$NFOM') AND (emailSent='Yes' AND rockGym='$gym')");
	$passesUsedRow = mysql_num_rows($passesUsed);

	echo 'There were '.$passesUsedRow.' passes used at '.$gym.' last month';
		
		echo "<br>";

	$dueGym = $gymRate * $passesUsedRow;

	echo 'You need to pay '.$gym.' $'.$dueGym.'.';


}


// This is the easy code that could be used to automatically run on the first of the month.
// if (date("Y-m-d") == $FOM) {
// 	echo "It's the first of the month.";
// } else {
// 	echo "It is not the first of the month";
// }


$fld_month = '<select name="month" class="form-control" required>
					<option value="">Select Month</option>
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>';

$fld_gym = '<select name="gym" class="form-control" required>
				<option value="">Select Gym</option>
				<option value="RSpotSB">Rock Spot</option>
				<option value="MetroEverett">MetroRock</option>
				<option value="BKBSomm">BKB</option>
				<option value="CentralRockBoston">CRG</option>
			</select>';

?>


<!-- 	This can be a drop down section where I can 
		choose the month I need to know the payment 
		for and for which gym 
-->

<div class="container">

 	
	<form action="<?php echo $thisScriptName; ?>" method="post">

		<label>Month: </label><br/>
		<?php echo $fld_month; ?>

		<label>Gym: </label><br/>
		<?php echo $fld_gym; ?>

		<br>
		<button type="submit" class="btn btn-primary" name="submit">Submit</button>

	</form>

</div>

<?php

include("./footer.php");

?>