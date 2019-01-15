<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data - Read 9. List all battles</h3>';
echo 'We are expected to see all battles in the database below. This can help users to know about the important events in the Game of Thrones TV show.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

// Listing battles in the database
$query = 'SELECT battle_name, timeline_id, conflict, result FROM Battle';
$result = mysqli_query($dbcon, $query)
	or die('Queryfailed: ' . mysqli_error());

echo "The battles in database are:<br>";
echo '<br>';

// Echoing info in HTML
echo '<table style = width 100%>
	<tr>
		<th>Battle Name</th>
		<th>Season</th> 
		<th>Conflict</th>
		<th>Result</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	echo '<td>'.$tuple['battle_name'].'</td>';
	echo '<td>'.$tuple['timeline_id'].'</td>';
	echo '<td>'.$tuple['conflict'].'</td>';
	echo '<td>'.$tuple['result'].'</td>';
	echo '</tr>';
}	
echo '</table>';


// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>