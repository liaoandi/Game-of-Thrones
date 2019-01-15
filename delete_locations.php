<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 9: Delete a region</h3>';
echo 'We are expected to see battle being if it is not in the previous database.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());


$region_name = $_REQUEST['region_name'];

$query =  " DELETE FROM Region
			WHERE region_name = '$region_name'";

$result = mysqli_query($dbcon, $query)
	or die('Queryfailed: ' . mysqli_error());
	
if (mysqli_affected_rows($dbcon) > 0){
	echo "Successfully delete the value!";
}
else{
	echo "It seems that the record doesn't exist! Please try again!";
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>