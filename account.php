<?php

include("./chooseHeader.php");

$thisScriptName = "account.php";

// sets error message to an empty highlight_string(str)
$errormsg = "";

//Checking for missing information in the users table
	if ($userRow['fName']==""||$userRow['lName']==""||$userRow['username']=="NULL"||$userRow['password']==""||$userRow['email']==""||$userRow['state']=="") {
		echo '<div class="alert alert-warning text-center" role="alert">Finish filling out your account settings <a href="./accountSettings">HERE!</a>.</div>';
	}


	$profilePic = $userRow['profilePic'];
	$fld_profilePic = '<img src="'.$profilePic.'" class="img-circle img-responsive" id="profilePic" alt="Responsive image">';

//Referral code
	$referralCode = $userRow['referralCode'];

	if (isset($_POST["referral"])) {
		unset($_POST["referral"]);

		for ($i=0; $i < 6; $i++) {
			$randomValue = substr("abcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0,35), 1);
			$referralCode = $referralCode.$randomValue;
		}

		$referralCode_Update = "UPDATE users SET referralCode='$referralCode' WHERE username='$username'";

		if (mysqli_query($dbConnected, $referralCode_Update)) {
			header("Location: account");

        } else {
        	$errormsg = "Sorry something went wrong with your referral code, please refresh page and try again.";
					echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
			          			'.$errormsg.'
			          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
        }


	}

// Determining total number of climbs, ie passes used
	$totalClimbsInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE userID='$userID' and emailSent IS NOT NULL");
	$totalClimbs = mysqli_num_rows($totalClimbsInfo);

// Identifying gym in area
// Determining passes used per gym then identifying top visited gym and calculating te percent of visits to that gym
	$userState = $userRow['state'];

	$gymUserState = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$userState'");
	$gymUserStateNum = mysqli_num_rows($gymUserState);

	$mostVisitGym = "";
	$numVisits = 0;

	for ($i=0; $i < $gymUserStateNum; $i++) {

	  $gymInfo = mysqli_query($dbConnected, "SELECT * FROM gyms WHERE state='$userState' LIMIT 1 OFFSET $i");
	  $gym = mysqli_fetch_array($gymInfo);

	  $gymName = $gym['shortName'];

	  $gymPassesInfo = mysqli_query($dbConnected, "SELECT * FROM passes WHERE (userID='$userID' AND rockGym='$gymName')");
	  $gymPasses = mysqli_num_rows($gymPassesInfo);

	  // Gym Array is alphbetical by gym name and contains gymName and visits
	  $gymArray[$i]['gymName'] = $gym['gymName'];
	  $gymArray[$i]['visits'] = $gymPasses;

	  // Checking for max visits while forming array instead of using foreach or for loop after
	  if ($gymPasses > $numVisits) {
	  	// Storing the max visit and gym name
	  	$numVisits = $gymPasses;
	  	$mostVisitGym = $gym['gymName'];
	  }

	}

	// Calcutaing percent of visits to the gym
	if ($totalClimbs != 0) {
		$percVisit = ($numVisits / $totalClimbs) * 100;
	} else {
		$percVisit = 0;
	}

	// Updating user data table with most visited gym if it hasn't been updated today
	if (date("dmY") != $dataLastUpdate) {
		// Table has not been updated today
		$userData_update = "UPDATE userdata SET percVisit='$percVisit', mostVisitGym='$mostVisitGym' WHERE userID='$userID'";

		if (mysqli_query($dbConnected, $userData_update)) {
			// userdata updated successfully

		} else {

			$errormsg = "Oops! Something went wrong. Please refresh the page.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';

			echo " (".__LINE__.")";

		}

	}

// Alert for no passes available
	if ($passNumRows == 0) {
		echo '<div class="alert alert-warning text-center" role="alert">You are all out of passes!  Get more <a href="./reloadPasses">HERE!</a>.</div>';
	}

?>

<div class="wrapper">

	<div class="container">

		<!-- Profile Picture -->
		<div class="row" style="padding-top:5px;">

			<div class="col-sm-2 col-xs-6 pull-left">

				<?php if ($profilePic == "") : ?>

					<form action="<?php echo $thisScriptName; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
						    <label for="fileToUpload">Select image to upload:</label>
						    <input type="file" name="fileToUpload" id="fileToUpload">
						</div>

						<br>
						<button type="submit" class="btn btn-primary" name="upload">Upload!</button>
					</form>

				<?php else :

						echo $fld_profilePic;

					 endif;?>

			</div>

			<div class="col-sm-4 col-xs-6 text-left">

				<h2><?php echo $userRow['fName']." ".$userRow['lName']; ?></h2>

			</div>

			<div class="col-sm-2 col-xs-6 pull-right text-right">

				<button class="btn btn-info"><a href="./accountSettings" style="color:white; text-decoration:none;">Settings</a></button>

			</div>

		</div>

		<!-- Climbing visits table -->
		<div class="row" style="padding-top:5px;">

			<div class="col-sm-8 col-offset-sm-2">

				<table class="table">
				    <tr>
				      <th>Gym</th>
				      <th class="text-center"># Visits</th>
				      <!-- <th class="text-right">See other Climbers</th> -->
				    </tr>

				    <?php

							for ($i=0; $i < $gymUserStateNum; $i++) {
								echo '<tr>
								        <td>'.$gymArray[$i]['gymName'].'</td>
								        <td class="text-center">'.$gymArray[$i]['visits'].'</td>
								      </tr>';
							}

				    ?>

				  </table>

			</div>

		</div>

	</div> <!-- container div -->

	<div class="container">

		<div class="row">

			<div class="col-sm-6">

				<?php if ($referralCode == "") : ?>

					<form action="<?php echo $thisScriptName; ?>" method="post" enctype="multipart/form-data">
						<h3>Need a Referral Code?</h3>
						<p>Refer a friend and you both get a discount on your next pass!</p>
						<button type="submit" class="btn btn-primary" name="referral">Click Here!</button>
					</form>

				<?php else : ?>

					<h3>Refer a Friend!</h3>
					<p>Give your friends your referral code and you both a your next pass at a discount!</p>

					<p>Your referral code is: <strong><?php echo $referralCode; ?></strong></p>

				<?php endif; ?>

			</div>

		</div>

	</div>


<?php 	// Updating Profession

	// Checking to see if user has submitted a job selectino
	if (isset($_POST["jobSubmit"])) {
		unset($_POST["jobSubmit"]);

		$job = mysqli_real_escape_string($dbConnected, @$_POST["job"]);

		// Updates users with new job
		$userJob_update = "UPDATE users SET job='$job' WHERE ID='$userID'";

		if (mysqli_query($dbConnected, $userJob_update)) {
			//have page reload so that if the user refreshes the page it does not resubmit the form

        	// Header is for localhost.  Does not work on live website
			header("Location: account");

			// Javascript is for live website.  Does not work on localhost
			// echo '<script type="text/javascript"> window.location="www.therockpass.com/account"; </script>';

		} else {
        	$errormsg = "Sorry something went wrong with updating your job, please refresh page and try again.";
			echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
	          			'.$errormsg.'
	          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
        }

	}

	$fld_job = '<select name="job" class="form-control" required>
					<option value="Student">Student</option>
		            <option value="Engineer">Engineer</option>
		            <option value="Teacher">Teacher</option>
		            <option value="Marketing">Marketing</option>
		            <option value="Retail">Retail</option>
		        </select>';

 ?>

<!-- Place to update job if currently blank -->
<?php if ($userRow['job'] == "") : ?>

	<div class="container">

		<div class="row">

			<div class="col-sm-6">

				<form method="post">

					<h3>What do you do for work?</h3>

					<div class="form-group">
						<label for="job">Job</label>
						<?php echo $fld_job; ?>
					</div>

					<button type="submit" class="btn btn-default" name="jobSubmit">Submit</button>

				</form>

			</div>

		</div>

	</div>

<?php endif; ?>


<?php 	// Matching script

 // If a time can be set, have it run at 3am EST.  That way it is also in the middle of the night for all US users (AJAX/JSON/jQuery??)

	// Checking matches table for matches where current user is either the primary or matched user
		$matchLastUpdate_sql = mysqli_query($dbConnected, "SELECT DAY( lastUpdate ) AS DAY,
											   	   MONTH( lastUpdate ) AS MONTH,
											   	   YEAR( lastUpdate ) AS YEAR
											FROM matches
											WHERE primaryUserID='$userID'
											LIMIT 1");
		$matchLastUpdate_array = mysqli_fetch_array($matchLastUpdate_sql);
		$matchLastUpdate = $matchLastUpdate_array['DAY'].$matchLastUpdate_array['MONTH'].$matchLastUpdate_array['YEAR'];

		$matchCheck = mysqli_query($dbConnected, "SELECT * FROM matches WHERE primaryUserID='$userID'");
		$matchCheck_num = mysqli_num_rows($matchCheck);

		$matchCheck2 = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID'");
		$matchCheck2_num = mysqli_num_rows($matchCheck2);

		$totalMatches = $matchCheck_num + $matchCheck2_num;

	// Checking if the last update to the matches table was today
		if ($matchLastUpdate != date("dmY") || $totalMatches == 0) {

			// The last update was not today
			// Run matching script

			// Determining total users in system from users state not including current user
			$totalUserInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE (ID!='$userID' AND state='$userState')");
			$totalUserCount = mysqli_num_rows($totalUserInfo);

			// Identifying climbing ranges of current user
			$TRLow = $userData['topRopingLvl'] - 2;
			$TRHigh = $userData['topRopingLvl'] + 2;

			$BLDLow = $userData['boulderingLvl'] - 1;
			$BLDHigh = $userData['boulderingLvl'] + 1;

			$LeadLow = $userData['leadingLvl'] - 2;
			$LeadHigh = $userData['leadingLvl'] + 2;

			// Cycling through other users in current users state to determine matches
			$y = 0;
			for ($i=0; $i < $totalUserCount; $i++) {

				$rating = 0; // Starting off with a rating of 0, build points as script runs

				// Grabbing info from users table
				$potentialMatchInfo = mysqli_query($dbConnected, "SELECT * FROM users WHERE (ID!='$userID' AND state='$userState') LIMIT 1 OFFSET $i");
				$potentialMatch = mysqli_fetch_array($potentialMatchInfo);
				$ID = $potentialMatch['ID'];

				// Grabbing info from userdata table
				$potentialDataInfo = mysqli_query($dbConnected, "SELECT * FROM userdata WHERE userID='$ID'");
				$potentialData = mysqli_fetch_array($potentialDataInfo);

				// Grabbing info from hobbies table
				$potentialHobbiesInfo = mysqli_query($dbConnected, "SELECT * FROM hobbies WHERE userID='$ID'");
				$potentialHobbies = mysqli_fetch_array($potentialHobbiesInfo);

				// CHecking to see if users climbing levels and style match
					// Climbing style
					if ($userData['preferedStyle'] == $potentialData['preferedStyle']) {
						// They are a style match
						$styleMatch = 2;
					} else {
						// They are not a style match
						$styleMatch = 0;
					}

					// Top Roping
					if ($potentialData['topRopingLvl']>=$TRLow && $potentialData['topRopingLvl']<=$TRHigh) {
						// They are a top roping match
						$TRMatch = 1;

						if ($potentialData['topRopingLvl'] == $userData['topRopingLvl']) {
							// They are a perfect top roping match
							$TRMatch = 2;
						}

					} else {
						// They are not top roping matches
						$TRMatch = 0;
					}

					// Bouldering
					if ($potentialData['boulderingLvl']>=$BLDLow && $potentialData['boulderingLvl']<=$BLDHigh) {
						// They are a bouldering match
						$boulderMatch = 1;

						if ($potentialData['boulderingLvl'] == $userData['boulderingLvl']) {
							// THey are a perfect bouldering match
							$boulderMatch = 2;
						}

					} else {
						// They are not bouldering matches
						$boulderMatch = 0;
					}

					// Leading
					if ($potentialData['leadingLvl']>=$LeadLow && $potentialData['leadingLvl']<=$LeadHigh) {
						// They are a Leading match
						$leadMatch = 1;

						if ($potentialData['leadingLvl'] == $userData['leadingLvl']) {
							// They are a perfect leading match
							$leadMatch = 2;
						}

					} else {
						// They are not leading matches
						$leadMatch = 0;
					}

				// Checking to see if user gym preferences match
					// Checking what gym is listed as their favorite
					if ($potentialData['favoriteGym'] == $userData['favoriteGym']) {
						// They are a favorite gym match
						$gymMatch = 1;

					} else {
						// They are not a favority gym matches
						$gymMatch = 0;
					}

					// Checking what gym the visit the most
					if ($potentialData['mostVisitGym'] == $userData['mostVisitGym']) {
						// They visit the same gym the most
						$gymMatch = $gymMatch + 1;
					}

				// Checking to see if users are a hobbies match
					$rockClimbing = 0;
					$iceClimbing = 0;
					$hiking = 0;
					$camping = 0;

					$hobbieMatch_sql = mysqli_query($dbConnected, "SELECT ( u1.rockClimbing = u2.rockClimbing ) AS $rockClimbing,
													       ( u1.iceClimbing = u2.iceClimbing) AS $iceClimbing,
													       ( u1.hiking = u2.hiking) AS $hiking,
													       ( u1.camping = u2.camping) AS $camping
													FROM
													  hobbies u1,
													  hobbies u2
													WHERE u1.UserID = $userID
													  AND u2.UserID = $ID");

					$hobbieMatch = $rockClimbing + $iceClimbing + $hiking + $camping;


				// Summing scores for match rating. 0-10, 10 being the best.
				// Only matching based on climbing preferences.  Hobbie match data is store and used as additional info to display
					$rating = $styleMatch + $TRMatch + $boulderMatch + $leadMatch + $gymMatch;

				// Checking whether the match is a good match
					if ($rating >= 5) {
						// Creating match array with matched user ID, profile Pic, and what they matched on
						// Uing $y as array counter instead of $y as not all users will be matches so there would have been gaps in the incrementing of $i
						$matchArray[$y]['matchID'] = $ID; //matches users ID not current users ID
						$matchArray[$y]['profilePic'] = $potentialMatch['profilePic'];
						$matchArray[$y]['username'] = $potentialMatch['username'];
						$matchArray[$y]['fName'] = $potentialMatch['fName'];
						$matchArray[$y]['lName'] = $potentialMatch['lName'];
						$matchArray[$y]['hobbieMatch'] = $hobbieMatch;
						$matchArray[$y]['styleMatch'] = $styleMatch;
						$matchArray[$y]['boulderMatch'] = $boulderMatch;
						$matchArray[$y]['TRMatch'] = $TRMatch;
						$matchArray[$y]['leadMatch'] = $leadMatch;
						$matchArray[$y]['gymMatch'] = $gymMatch;
						$matchArray[$y]['rating'] = $rating;

						$y = $y + 1;
					}



			}  // End of for loop, $y number of matches identified //

			// Checking to see if any matches were found
			if ($y != 0) {
				// Matches were found

				// For loop to loop through as many matches as were found
				for ($i=0; $i < $y; $i++) {

					// Checking how many rows are in the matches table
					// Need to do this each loop as the table will be updated each loop
					// This will act as a double check that there are no duplicate matches
					$matches_sql = mysqli_query($dbConnected, "SELECT * FROM matches");
					$matches_num = mysqli_num_rows($matches_sql);

					// Checking if matches table has any rows
					if ($matches_num == 0) {

						// No rows currently in matches table
						$matches_Insert = "INSERT INTO matches ";
						$matches_Insert .= "(primaryUserID, matchedUserID, hobbieMatch, styleMatch, boulderMatch, TRMatch, leadMatch, gymMatch, rating)";
						$matches_Insert .= "VALUES ('$userID', ";
						$matches_Insert .= "'".$matchArray[$i]['matchID']."', ";
						$matches_Insert .= "'".$matchArray[$i]['hobbieMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['styleMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['boulderMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['TRMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['leadMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['gymMatch']."', ";
						$matches_Insert .= "'".$matchArray[$i]['rating']."')";

						if (mysqli_query($dbConnected, $matches_Insert)) {

					 	} else {

					 		$errormsg = "Oops! Something went wrong. Please refresh the page.";
							echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
					          			'.$errormsg.'
					          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
							echo " (".__LINE__.")";

					 	}

					} else {
						// There are already rows in the matches table to check

						// For loop to loop through all rows in matches table
						for ($x=0; $x < $matches_num; $x++) {

							// Pulling match table row
							$match_row_sql = mysqli_query($dbConnected, "SELECT * FROM matches LIMIT 1 OFFSET $x");
							$match_row = mysqli_fetch_array($match_row_sql);
							$rowID = $match_row['ID'];

							// Checking if the row is a match for the current user and the matched user
							$currentUser = ($userID == $match_row['primaryUserID'] || $userID == $match_row['matchedUserID']);
							$matchedUser = ($matchArray[$i]['matchID'] == $match_row['primaryUserID'] || $matchArray[$i]['matchID'] == $match_row['matchedUserID']);

							if ($currentUser && $matchedUser) {
								// The current row has the current users ID as either the primary or the matched ID
								// and the current row has the match users ID as either the primary or the match ID

								// Updating row
								$matches_Update = "UPDATE matches ";
							  	$matches_Update .= "SET hobbieMatch='".$matchArray[$i]['hobbieMatch']."', ";
							  	$matches_Update .= "styleMatch='".$matchArray[$i]['styleMatch']."', ";
							  	$matches_Update .= "boulderMatch='".$matchArray[$i]['boulderMatch']."', ";
							  	$matches_Update .= "TRMatch='".$matchArray[$i]['TRMatch']."', ";
							  	$matches_Update .= "leadMatch='".$matchArray[$i]['leadMatch']."', ";
							  	$matches_Update .= "gymMatch='".$matchArray[$i]['gymMatch']."', ";
							  	$matches_Update .= "rating='".$matchArray[$i]['rating']."'  ";
							 	$matches_Update .= "WHERE ID='$rowID' ";

							 	if (mysqli_query($dbConnected, $matches_Update)) {

							 		// Breaking out of for loop since row was found and updated
							 		// Then parent loop can move onto next match user check
							 		break;

							 	} else {

							 		$errormsg = "Oops! Something went wrong. Please refresh the page.";
									echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
							          			'.$errormsg.'
							          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>';
									echo " (".__LINE__.")";

							 	}

							}

							// Checking if for loop has reached the end of the matches table and hasn't updated any rows
							if ($x == ($matches_num - 1)) {

								// No rows currently have both users in match listed
								$matches_Insert = "INSERT INTO matches ";
								$matches_Insert .= "(primaryUserID, matchedUserID, hobbieMatch, styleMatch, boulderMatch, TRMatch, leadMatch, gymMatch, rating)";
								$matches_Insert .= "VALUES ('$userID', ";
								$matches_Insert .= "'".$matchArray[$i]['matchID']."', ";
								$matches_Insert .= "'".$matchArray[$i]['hobbieMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['styleMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['boulderMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['TRMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['leadMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['gymMatch']."', ";
								$matches_Insert .= "'".$matchArray[$i]['rating']."')";

								if (mysqli_query($dbConnected, $matches_Insert)) {

									// Breaking out of for loop since row was found and updated
							 		// Then parent loop can move onto next match user check
							 		break;

							 	} else {

							 		$errormsg = "Oops! Something went wrong. Please refresh the page.";
									echo '	<div class="alert alert-dismissable alert-danger text-center" role="alert">
							          			'.$errormsg.'
							          			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>';
									echo " (".__LINE__.")";

							 	}

							}

						} // End of for loop for checking all rows in the matches table

					} // end of else from if statement checking for any rows in matches table

				} // End of the for loop for checking all the matches and entering or updating them in the matches table

			} // end of if checking for matches

			// Checking matches table again for total matches as it was just updated
			$matchCheck = mysqli_query($dbConnected, "SELECT * FROM matches WHERE primaryUserID='$userID'");
			$matchCheck_num = mysqli_num_rows($matchCheck);

			$matchCheck2 = mysqli_query($dbConnected, "SELECT * FROM matches WHERE matchedUserID='$userID'");
			$matchCheck2_num = mysqli_num_rows($matchCheck2);

			$totalMatches = $matchCheck_num + $matchCheck2_num;

		} else {

			// the last update was today
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

		}

?>

	<!-- Profile pictures of matches -->
	<div class="container">

		<div class="row">

		<?php

			// Displaying matches profile pictures
			// SHould also display the characterisitcis that make them a good match (ie style, level, gym)
			for ($i=0; $i < $totalMatches; $i++) {

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

		 ?>

		</div>

	</div>

</div> <!-- wrapper -->


<?php include("./footer.php"); ?>
