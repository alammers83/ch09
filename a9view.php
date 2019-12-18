<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'View the Champs';
include ('includes/a9header.html');

// Page header:
echo '<h1>MLB Champs</h1>';

require ('a9mysqli_connect.php'); // Connect to the db.
		
// Make the query:

$q= "SELECT team, team_id, pennants, worldseries FROM champs_table";	
 // Run the query.
$r= @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many teams there are:
	echo "<p>There are currently $num baseball teams.</p>\n";

	// Table header.
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left"><b>Team</b></td><td align="right"><b>Team ID</b></td><td align="right"><b>Pennants</b></td><td align="right"><b>World Series</b></td></tr>
';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['team'] . '</td><td align="center">' . $row['team_id'] . '</td><td align="center">' . $row['pennants'] . '</td><td align="center">' . $row['worldseries'] . '</td></tr>
		';
	}

	echo '</table>'; // Close the table.
	
	mysqli_free_result ($r); // Free up the resources.	

} else { // If no records were returned.

	echo '<p class="error">There are currently no baseball teams in the database.</p>';

}

mysqli_close($dbc); // Close the database connection.

include ('includes/a9footer.html');
?>