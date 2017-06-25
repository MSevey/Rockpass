<html>
<head>
	<title>Test Select User</title>
</head>
<body>



<?php 

include("../inc/connectDB.php");

echo "Test Page.";

echo "<br>";



?>

<form action="profile.php" method="GET">
	<table>
		<tr>
			<td>Username</td>
			<td><input type="text" id="username" name="username"></td>
		</tr>
		<tr>
			<td><input type="submit" id="submit" name="submit" value="View Profile!"></td>
		</tr>
	</table>
</form>



<script>

</script>


</body>
</html>