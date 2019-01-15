<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Read - 1: List all tables</h3>';
echo 'Testing if we have all the tables needed. We are expected to see twelve tables below.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

// Listing tables in the database
$query = 'SHOW TABLES';
$result = mysqli_query($dbcon, $query)
	or die('Show tables failed: ' . mysqli_error());

echo "The tables in $database database are:<br>";

// Echoing table names in HTML
echo '<ul>';
$compare = 'large';
while ($tuple = mysqli_fetch_row($result)) {
	if (strpos($tuple[0], $compare) === false) {
		echo '<li>'.$tuple[0].'</li>';
	}
}
echo '</ul>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>