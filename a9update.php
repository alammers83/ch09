<?php 


$page_title = 'Update the Pennants and World Series';
include ('includes/a9header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('a9mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for team_id:
	if (empty($_POST['team_id'])) {
		$errors[] = 'You forgot to enter the Team ID.';
	} else {
		$t = mysqli_real_escape_string($dbc, trim($_POST['team_id']));
	}

	// Check for the team:
	if (empty($_POST['team'])) {
		$errors[] = 'You forgot to enter the team.';
	} else {
		$tm = mysqli_real_escape_string($dbc, trim($_POST['team']));
	}
	
	// Check for the pennants:
	if (empty($_POST['pennants'])) {
		$errors[] = 'You forgot to enter the Pennants to be updated.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pennants']));
	}
	
	// Check for the world_series:
	if (empty($_POST['worldseries'])) {
		$errors[] = 'You forgot to enter the World Series to be updated';
	} else {
		$ws = mysqli_real_escape_string($dbc, trim($_POST['worldseries']));
	}
	
	if (empty($errors)) {
		// Check that they've entered the right team_id/team combination:
		$q = "SELECT team_id FROM champs_table WHERE team_id='$t' AND team='$tm'";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		if ($num == 1) { // Match was made.
		
			//$errors[] = 'The team id and team name combination does not match any on file. Please view the teams again to see the correct team id and team names to use.';
	
			// Get the team_id:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);

			// Make the UPDATE query:
			$q = "UPDATE champs_table SET pennants='$p', worldseries='$ws' WHERE team_id=$row[0]";		
			$r = @mysqli_query($dbc, $q);
			
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message.
				echo '<h1>Thank you!</h1>
				<p>The Pennants and World Series have been updated!</p><p><br /></p>';	

			} else { // If it did not run OK.

				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">The Pennants and World Series could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
	
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
			}

			mysqli_close($dbc); // Close the database connection.

			// Include the footer and quit the script (to not show the form).
			include ('includes/a9footer.html'); 
			exit();
			// Invalid team/team_id combination.
			
		} else { 
			echo '<h1>Error!</h1>
			<p class="error">The team id and team name combination does not match any on file. Please view the teams again to see the correct team id and team names to use.</p>';
		}
		
	} else { // Report the errors.

	// Invalid team/team_id combination.
		echo '<h1>Error!</h1>
		<p class="error">The team id and team name combination does not match any on file. Please view the teams again to see the correct team id and team names to use.<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
	
	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.
		
} // End of the main Submit conditional.
?>
<h1>Update Champs</h1>
<form action="a9update.php" method="post">
	<p>Team ID: <input type="text" name="team_id" size="20" maxlength="20" value="<?php if (isset($_POST['team_id'])) echo $_POST['team_id']; ?>"  /> </p>
	<p>Team: <input type="text" name="team" size="30" maxlength="40" value="<?php if (isset($_POST['team'])) echo $_POST['team']; ?>"  /></p>
	<p>Pennants: <input type="text" name="pennants" size="10" maxlength="20" value="<?php if (isset($_POST['pennants'])) echo $_POST['pennants']; ?>"  /></p>
	<p>World Series: <input type="text" name="worldseries" size="10" maxlength="20" value="<?php if (isset($_POST['worldseries'])) echo $_POST['worldseries']; ?>"  /></p>
	<p><input type="submit" name="submit" value="Update Champs" /></p>
</form>
<?php include ('includes/a9footer.html'); ?>