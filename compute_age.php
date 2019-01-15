<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

// Getting the input parameter (timeline_name, last_name):
$timeline_name = $_REQUEST['timeline_name'];
$last_name = $_REQUEST['last_name'];

echo '<h3>Data Read - 7.Calculate the age of characters in a house up to a given season</h3>';
echo "We are expected to see first name, last name, age of house $last_name below.<br>";
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());
	
$query =    "SELECT first_name, last_name, CASE WHEN is_alive = 'True' THEN at_time - born_date 
										   ELSE 'DEAD' END AS age
			FROM People, (SELECT t.at_time
							FROM Timeline t
							WHERE timeline_name = '$timeline_name') tmp
			WHERE last_name = '$last_name'";

$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

// Checking if the input values are not correct
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 0){
	echo "$timeline_name or $last_name not found! Please try again!";
}
else{
	// displaying the result in a table
	echo '<table style = width 100%>
		<tr>
			<th>First Name</th>
			<th>Last Name</th> 
			<th>Age</th>
		</tr>';

	while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>';
		echo '<td>'.$tuple['first_name'].'</td>';
		echo '<td>'.$tuple['last_name'].'</td>';
		echo '<td>'.$tuple['age'].'</td>';
		echo '</tr>';
	}	
	echo '</table>';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>