<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

// Getting the input parameter (timeline_name):
$timeline_name = $_REQUEST['timeline_name'];

echo '<h3>Data Read - 5.Find the list of dead people in a season</h3>';
echo "We are expected to see all people died in and before $timeline_name below.<br>";
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$query =    "SELECT DISTINCT first_name, last_name, death_date, timeline_name
			FROM People p, Timeline t
			WHERE p.death_date <= (SELECT t.at_time
								   FROM Timeline t
								   WHERE timeline_name = '$timeline_name')
			AND p.death_date = t.at_time";

$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

// Checking if the input values are not correct
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 0){
	echo "$timeline_name not found! Please try again!";
}
else{
	// displaying the result in a table
	echo '<table style = width 100%>
		<tr>
			<th>First Name</th>
			<th>Last Name</th> 
			<th>Death Date</th>
			<th>Season</th>
		</tr>';

	while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>';
		echo '<td>'.$tuple['first_name'].'</td>';
		echo '<td>'.$tuple['last_name'].'</td>';
		echo '<td>'.$tuple['death_date'].'</td>';
		echo '<td>'.$tuple['timeline_name'].'</td>';
		echo '</tr>';
	}	
	echo '</table>';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>