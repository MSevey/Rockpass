<?php

include("./chooseHeader.php");

/*   Here are some notes on how the payment code could run  */


/*******************************************************************
	HOW TO MAKE IT AUTOMATED


*********************************************************************/



		/*First of the Month*/
		$FOM = date("Y-m-01");
		echo '$FOM from line 46 is '.$FOM;

		echo "<br>";

		/*Last first of the Month*/
		$lastMonth = date("m")-1;
		$LFOM = date("Y-$lastMonth-01");
		echo '$LFOM is equal to '.$LFOM;

		echo "<br>";


/*********************************************************
	PRE-DEFINED VARIABLES

	1) price per pass or membership
	2) day pass rates per gym
	3) membership prices per gym
	4) gym weighting

***************************************************************/

	$gymRate = 18;


/*************************************************************
	NEEDED VARIABLES

	1) users who used passes last month and which gyms they went to
	2) how the gyms should be paid based on the passes used.

***************************************************************/


/********************************************
		10 PACK
**********************************************/

	/*	PULL ALL PASSES USED FOR EACH GYM LAST MONTH 	*/

	/* Execute this code for each gym to find all passes used for each past*/
	/* This code could also be reapply to be used in a report page for passes used per month or in ny date range*/
	$gym = "RSpotSB";
	$passesUsed = "SELECT * WHERE (dateDay BETWEEN $FOM AND $LFOM) AND emailSent='Yes' AND gym='$gym'";
	$passesUsedQuery = mysqli_query($dbConnected, $passesUsed);
	$passesUsedRow = mysqli_num_rows($passesUsedQuery);

	echo 'There were '.$passesUsedRow.' passes used at '.$gym.' last month';

		echo "<br>";

	$dueGym = $gymRate * $passesUsedRow;

	echo 'You need to pay '.$gym.' $'.$dueGym.'.';


/****************************************
		Membership

		--> There should be a way to have a function to cycle through the gyms
			instead of define new variables for each gym
				--> Would be more important for adding new gyms

******************************************/

	/* Columns H and J from excel file */
	/* RockSpot */
	$dailyRS = 14;
	$monthlyRS = 45;

	/* Metro */
	$dailyMetro = 18;
	$monthlyMetro = 85;

	/* CRG */
	$dailyCRG = 20;
	$monthlyCRG = 89;

	/* Column G and cell E4 */
	/* Multipliers and Adjustments */
	$maxMonthly = max($monthlyRS, $monthlyMetro, $monthlyCRG);

	$multiplierRS = $monthlyRS / $maxMonthly;
	$multiplierMetro = $monthlyMetro / $maxMonthly;
	$multiplierCRG = $monthlyCRG / $maxMonthly;


	/* Column M */
	/* Finding Passes Used */


	// THis would be select statements from the database
	$visitsRS = 1;
	$visitsMetro = 1;
	$visitsCRG = 1;


	/* Column N */
	/* Adjusting passes used for pricing compensation */
	$adjVisitsRS = $visitsRS * $multiplierRS;
	$adjVisitsMetro = $visitsMetro * $multiplierMetro;
	$adjVisitsCRG = $visitsCRG * $multiplierCRG;

	$totalAdjVisits = $adjVisitsRS + $adjVisitsMetro + $adjVisitsCRG;


	/* Column I */
	/* Payments bases on visits */
	$perPassDueRS = $visitsRS * $dailyRS;
	$perPassDueMetro = $visitsMetro * $dailyMetro;
	$perPassDueCRG = $visitsCRG * $dailyCRG;

	$totalPerPassDue = $perPassDueRS + $perPassDueMetro + $perPassDueCRG;


	/* Column K */
	/* Calculating Payments

		1) See if we can combine it into one decision tree.
		2) Needs to never pay more than gym monthly membership
		3) Needs to pay per price if there are available funds
		4) Needs to some how compare determined prices and loop back through to find
			best deal.



	*/

	/* Rock Spot */
		//Checks to see if any passes were used
		if ($totalAdjVisits=0) {
			//No Passes used. So gym isn't paid
			$dueRS = 0;
		}
		//There were passes Used
		//Checks if gym was the only gym visited
		elseif ($adjVisitsRS=$totalAdjVisits) {
			//Gym was the only one visited
			//Checks if paying the gym per pass used is greater than the monthly membership
			if ($perPassDueRS>$monthlyRS) {
				//Paying per pass used is greater than the monthly membership
				//Pay gym the monthly membership
				$dueRS = $monthlyRS;
			}
			//Paying per pass used is less than the monthly membership
			else {
				//Pay the gym per pass used
				$dueRS = $perPassDueRS;
			}
		}
		//There were passes used
		//The gym was not the only one visited
		//Checks to see if the weighted portion of the total amount is greater than the monthly rate
		elseif (($adjVisitsRS/$totalAdjVisits)*$maxMonthly>$monthlyRS) {
			//Weighted portion is greater than monthly rate
			//Pay gym monthly rate
			$dueRS = $monthlyRS;
		}
		//There were passes used
		//The gym was not the only one visited
		//Weighted Portion is less than monthly rate
		//Checks to see if weighted amount is greater than the per pass price
		elseif (($adjVisitsRS/$totalAdjVisits)*$maxMonthly > $perPassDueRS) {
			//weighted portion is greater than the per pass price
			//Pay Gym weighted amount
			$dueRS = ($adjVisitsRS/$totalAdjVisits)*$maxMonthly;
		}
		//There were passes used
		//The gym was not the only one visited
		//Weighted Portion is less than monthly rate
		//Weighted amount is less than the per pass price
		else {
			//Pay gym per pass price
			$dueRS = $perPassDueRS;
		}

	/* Metro/CRG */
	/* From Excel
	=IF($N$9=0,0,IF(N7=$N$9,IF(I7>J7,J7,I7),IF((N7/$N$9)*$E$4>I7,I7,(N7/$N$9)*$E$4)))
	*/


include("./footer.php");

?>
