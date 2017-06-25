<html>
<head>
	<title>Test Profile <?php echo $fName; ?></title>
</head>
<body>

<?php 

include("../inc/connectDB.php");



// Check if the form has been submitted
if (isset($_GET['username'])) {
	$username = $_GET['username'];
	$userquery = mysql_query("SELECT * FROM users WHERE username='$username'") or die("user query failed");
	if (mysql_num_rows($userquery) != 1) {
		die("THat username was not found");
	}
	$row = mysql_fetch_array($userquery);
		$fName = $row['fName'];
		$lName = $row['lName'];
		$ID = $row['ID'];
		$dbusername = $row['username'];
		$state = $row['state'];
		$admin = $row['admin'];
	
	if ($username != $dbusername) {
		die("Usernames do not match");
		
	} 
?>

	<h2><?php echo $fName; ?> <?php echo $lName ?>'s Profile</h2>
	<br>
	<table>
		<tr>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Username</td>
			<td>ID</td>
			<td>State</td>
			<td>Is Admin?</td>
		</tr>
		<tr>
			<td><?php echo $fName; ?></td>
			<td><?php echo $lName; ?></td>
			<td><?php echo $dbusername; ?></td>
			<td><?php echo $ID; ?></td>
			<td><?php echo $state; ?></td>
			<td><?php echo $admin; ?></td>
		</tr>
	</table>

<?php 

} else die("You need to specify a username");

?>

</body>
</html>


<script>

</script>


