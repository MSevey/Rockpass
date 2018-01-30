<?php

include("./chooseHeader.php");

$thisScriptName = "userProfile.php";

// sets error message to an empty highlight_string(str)
$errormsg = "";

// Checking if username was submitted from profile form
	if (isset($_GET['username'])) {

		// Checking if user is being directed back to their account
			$userCheck = $_GET['username'];

			if ($userCheck == $username) {

				header("location: account");

			}

		// Reasigning values to username
			$username = $_GET['username'];
			$userquery = mysqli_query($dbConnected, "SELECT * FROM users WHERE username='$username'");

		// Making sure there is only one entry in the users table for the username
			if (mysqli_num_rows($userquery) != 1) {
				$errormsg = "This user could not be found.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			}
		// Grabbing users info
			$userRow = mysqli_fetch_array($userquery);
			$fName = $userRow['fName'];
			$lName = $userRow['lName'];
			$userID = $userRow['ID'];
			$dbusername = $userRow['username'];

		// Double check that the username submitted from the form is the username in the users table
			if ($username != $dbusername) {
				$errormsg = "Usernames do not match.";
				echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
		          			'.$errormsg.'
		          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			}

	} else {
		die("No username is selected");
	}


// Profile Picture
	$profilePic = $userRow['profilePic'];
	$fld_profilePic = '<img src="'.$profilePic.'" class="img-circle img-responsive" id="profilePic" alt="Responsive image">';
	$fld_noProfilePic = '<img src="./img/Empty_Profile.png" class="img-circle img-responsive" id="profilePic" alt="Responsive image">';

//Referral code
	$referralCode = $userRow['referralCode'];

// Determining total number of climbs, ie passes used
	$totalClimbsInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE userID='$userID' and emailSent IS NOT NULL");
	$totalClimbs = mysqli_num_rows($totalClimbsInfo);

// Identifying gym in area
// Determining passes used per gym then identifying top visited gym and calculating te percent of visits to that gym
	$userState = $userRow['state'];

	$gymUserState = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$userState'");
	$gymUserStateNum = mysqli_num_rows($gymUserState);


	for ($i=0; $i < $gymUserStateNum; $i++) {

	  $gymInfo = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$userState' LIMIT 1 OFFSET $i");
	  $gym = mysqli_fetch_array($gymInfo);

	  $gymName = $gym['shortName'];

	  $gymPassesInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE (userID='$userID' AND rockGym='$gymName')");
	  $gymPasses = mysqli_num_rows($gymPassesInfo);

	  // Gym Array is alphbetical by gym name and contains gymName and visits
	  $gymArray[$i]['gymName'] = $gym['gymName'];
	  $gymArray[$i]['visits'] = $gymPasses;

	}


?>

<div class="wrapper">

	<div class="container">

		<!-- Profile Picture -->
		<div class="row" style="padding-top:5px;">

			<div class="col-sm-2 col-xs-6 pull-left">

				<?php if ($profilePic == "") :

						echo $fld_noProfilePic;

					 else :

						echo $fld_profilePic;

					 endif;?>

			</div>

			<div class="col-sm-4 col-xs-6 text-left">

				<h2><?php echo $userRow['fName']." ".$userRow['lName']; ?></h2>

			</div>

		</div>

		<!-- Climbing visits table -->
		<div class="row" style="padding-top:5px;">

			<div class="col-sm-8 col-offset-sm-2">

				<table class="table">
				    <tr>
				      <th>Gym</th>
				      <th class="text-center"># Visits</th>
				      <th class="text-right">See other Climbers</th>
				    </tr>

				    <?php

						for ($i=0; $i < $gymUserStateNum; $i++) {
							echo '<tr>
							        <td>'.$gymArray[$i]['gymName'].'</td>
							        <td class="text-center">'.$gymArray[$i]['visits'].'</td>
							        <td class="text-right">Link to gyms page</td>
							      </tr>';
						}

				    ?>

				  </table>

			</div>

		</div>

	</div> <!-- container div -->

<?php

// Checking matches table for matches where current user is either the primary or matched user
	$matchCheck = mysqli_query($dbConnected, "SELECT * FROM matches WHERE primaryUserID='$userID'");
	$matchCheck_num = mysqli_num_rows($matchCheck);

	$matchCheck2 = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID'");
	$matchCheck2_num = mysqli_num_rows($matchCheck2);

	$totalMatches = $matchCheck_num + $matchCheck2_num;

// cycle through matches table and create arrays of all the matches both primaryID and matchedID
// Pull together array of other user profile pics

	if ($matchCheck_num != 0) {
		// Cycling through all the entries where the current user is the primaryUserID
			for ($i=0; $i < $matchCheck_num; $i++) {

				// Grabbing info from matches table 1 row at a time
				$matchInfo = mysqli_query($dbConnected, "SELECT * FROM matches WHERE primaryUserID='$userID' LIMIT 1 OFFSET $i");
				$match = mysqli_fetch_array($matchInfo);

				// Grabbing the matched users ID
				$matchID = $match['matchedUserID'];

				// Grabbing the matched users info from the users table
				$matchUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE ID='$matchID'");
				$matchUser = mysqli_fetch_array($matchUserInfo);

				// Creatin match array with matched user ID, profile Pic, and what they matched on
				$matchArray[$i]['matchID'] = $matchID;
				$matchArray[$i]['profilePic'] = $matchUser['profilePic'];
				$matchArray[$i]['username'] = $matchUser['username'];
				$matchArray[$i]['fName'] = $matchUser['fName'];
				$matchArray[$i]['lName'] = $matchUser['lName'];
				$matchArray[$i]['hobbieMatch'] = $match['hobbieMatch'];
				$matchArray[$i]['styleMatch'] = $match['styleMatch'];
				$matchArray[$i]['boulderMatch'] = $match['boulderMatch'];
				$matchArray[$i]['TRMatch'] = $match['TRMatch'];
				$matchArray[$i]['leadMatch'] = $match['leadMatch'];
				$matchArray[$i]['gymMatch'] = $match['gymMatch'];
				$matchArray[$i]['rating'] = $match['rating'];

			}

		// Cycling through all the enteries where the current user is the matchedUserID and adding it to the matchArray
			// Verifying there are matches where the user is the matchedID
			if ($matchCheck2_num =! 0) {

				for ($i=$matchCheck2_num; $i < $totalMatches; $i++) {

					// Grabbing info from matches table 1 row at a time
					$matchInfo = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID' LIMIT 1 OFFSET $i");
					$match = mysqli_fetch_array($matchInfo);

					// Grabbing the matched users ID
					$matchID = $match['primaryUserID'];

					// Grabbing the matched users info from the users table
					$matchUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE ID='$matchID'");
					$matchUser = mysqli_fetch_array($matchUserInfo);

					// Creatin match array with matched user ID, profile Pic, and what they matched on
					$matchArray[$i]['matchID'] = $matchID;
					$matchArray[$i]['profilePic'] = $matchUser['profilePic'];
					$matchArray[$i]['username'] = $matchUser['username'];
					$matchArray[$i]['fName'] = $matchUser['fName'];
					$matchArray[$i]['lName'] = $matchUser['lName'];
					$matchArray[$i]['hobbieMatch'] = $match['hobbieMatch'];
					$matchArray[$i]['styleMatch'] = $match['styleMatch'];
					$matchArray[$i]['boulderMatch'] = $match['boulderMatch'];
					$matchArray[$i]['TRMatch'] = $match['TRMatch'];
					$matchArray[$i]['leadMatch'] = $match['leadMatch'];
					$matchArray[$i]['gymMatch'] = $match['gymMatch'];
					$matchArray[$i]['rating'] = $match['rating'];

				}

			}

	} else {
		// Cycling through all the enteries where the current user is the matchedUserID and adding it to the matchArray
			for ($i=0; $i < $matchCheck2_num; $i++) {

				// Grabbing info from matches table 1 row at a time
				$matchInfo = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID' LIMIT 1 OFFSET $i");
				$match = mysqli_fetch_array($matchInfo);

				// Grabbing the matched users ID
				$matchID = $match['primaryUserID'];

				// Grabbing the matched users info from the users table
				$matchUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE ID='$matchID'");
				$matchUser = mysqli_fetch_array($matchUserInfo);

				// Creatin match array with matched user ID, profile Pic, and what they matched on
				$matchArray[$i]['matchID'] = $matchID;
				$matchArray[$i]['profilePic'] = $matchUser['profilePic'];
				$matchArray[$i]['username'] = $matchUser['username'];
				$matchArray[$i]['fName'] = $matchUser['fName'];
				$matchArray[$i]['lName'] = $matchUser['lName'];
				$matchArray[$i]['hobbieMatch'] = $match['hobbieMatch'];
				$matchArray[$i]['styleMatch'] = $match['styleMatch'];
				$matchArray[$i]['boulderMatch'] = $match['boulderMatch'];
				$matchArray[$i]['TRMatch'] = $match['TRMatch'];
				$matchArray[$i]['leadMatch'] = $match['leadMatch'];
				$matchArray[$i]['gymMatch'] = $match['gymMatch'];
				$matchArray[$i]['rating'] = $match['rating'];

			}

	}

	// Cycling through all the entries where the current user is the primaryUserID
		for ($i=0; $i < $matchCheck_num; $i++) {

			// Grabbing info from matches table 1 row at a time
			$matchInfo = mysqli_query($dbConnected, "SELECT * FROM matches WHERE primaryUserID='$userID' LIMIT 1 OFFSET $i");
			$match = mysqli_fetch_array($matchInfo);

			// Grabbing the matched users ID
			$matchID = $match['matchedUserID'];

			// Grabbing the matched users info from the users table
			$matchUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE ID='$matchID'");
			$matchUser = mysqli_fetch_array($matchUserInfo);

			// Creatin match array with matched user ID, profile Pic, and what they matched on
			$matchArray[$i]['matchID'] = $matchID;
			$matchArray[$i]['profilePic'] = $matchUser['profilePic'];
			$matchArray[$i]['hobbieMatch'] = $match['hobbieMatch'];
			$matchArray[$i]['styleMatch'] = $match['styleMatch'];
			$matchArray[$i]['boulderMatch'] = $match['boulderMatch'];
			$matchArray[$i]['TRMatch'] = $match['TRMatch'];
			$matchArray[$i]['leadMatch'] = $match['leadMatch'];
			$matchArray[$i]['gymMatch'] = $match['gymMatch'];
			$matchArray[$i]['rating'] = $match['rating'];

		}

	// Cycling through all the enteries where the current user is the matchedUserID and adding it to the matchArray
		for ($i=$matchCheck2_num; $i < $totalMatches; $i++) {

			// Grabbing info from matches table 1 row at a time
			$matchInfo = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID' LIMIT 1 OFFSET $i");
			$match = mysqli_fetch_array($matchInfo);

			// Grabbing the matched users ID
			$matchID = $match['primaryUserID'];

			// Grabbing the matched users info from the users table
			$matchUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE ID='$matchID'");
			$matchUser = mysqli_fetch_array($matchUserInfo);

			// Creatin match array with matched user ID, profile Pic, and what they matched on
			$matchArray[$i]['matchID'] = $matchID;
			$matchArray[$i]['profilePic'] = $matchUser['profilePic'];
			$matchArray[$i]['hobbieMatch'] = $match['hobbiesMatch'];
			$matchArray[$i]['styleMatch'] = $match['styleMatch'];
			$matchArray[$i]['boulderMatch'] = $match['boulderMatch'];
			$matchArray[$i]['TRMatch'] = $match['TRMatch'];
			$matchArray[$i]['leadMatch'] = $match['leadMatch'];
			$matchArray[$i]['gymMatch'] = $match['gymMatch'];
			$matchArray[$i]['rating'] = $match['rating'];

		}


?>

	<!-- Profile pictures of matches -->
	<div class="container">

		<div class="row">

		<?php
			// Checking for matches
				if ($totalMatches != 0) {

					// Displaying matches profile pictures
					// SHould also display the characterisitcis that make them a good match (ie style, level, gym)
					for ($i=0; $i < sizeof($matchArray); $i++) {

						$matchfName = $matchArray[$i]['fName'];
						$matchlName = $matchArray[$i]['lName'];
						$matchusername = $matchArray[$i]['username'];
						$matchprofilePic = $matchArray[$i]['profilePic'];

						// Checking if user has a profile pic uploaded
						if ($matchArray[$i]['profilePic'] != "") {

							echo '	<div class="col-sm-1">
										<form action="profile.php" method="GET" name="profile">
											<img src="'.$matchArray[$i]['profilePic'].'" class="img-circle img-responsive" alt="Responsive image" id="matchPic">
											<input type="hidden" value="'.$matchArray[$i]['username'].'" name="username">
											<input type="submit" value="'.$matchArray[$i]['fName'].' '.$matchArray[$i]['lName'].'" style="
											    border:0;
											    background-color:transparent;
											    color: blue;
											    text-decoration:underline;
											"/>
										</form>
									</div>';

						} else {

							echo '	<div class="col-sm-1">
										<form action="profile.php" method="GET" name="profile">
											<img src="./img/Empty_Profile.png" class="img-circle img-responsive" alt="Responsive image" id="matchPic">
											<input type="hidden" value="'.$matchArray[$i]['username'].'" name="username">
											<input type="submit" value="'.$matchArray[$i]['fName'].' '.$matchArray[$i]['lName'].'" style="
											    border:0;
											    background-color:transparent;
											    color: blue;
											    text-decoration:underline;
											"/>
										</form>
									</div>';

						}

					}

				}

		?>

		</div>

	</div>

</div> <!-- wrapper -->


<?php include("./footer.php"); ?>
