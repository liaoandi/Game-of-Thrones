<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 8: Add a continent</h3>';
echo 'We are expected to see the new location just added if it is not in the previous database.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$continent_name = $_REQUEST['continent_name'];
$continent_details = $_REQUEST['continent_details'];

function mysqli_last_result($link) {
		while (mysqli_more_results($link)) {
			mysqli_use_result($link); 
			mysqli_next_result($link);
		}
		return mysqli_store_result($link);
	}

	$query =  " INSERT INTO Continent(continent_name, continent_details)
							Values('$continent_name', '$continent_details');
				SELECT continent_name, continent_details
				FROM Continent
				WHERE continent_id = (SELECT MAX(continent_id) FROM Continent);";

	mysqli_multi_query($dbcon, $query);
	$result = mysqli_last_result($dbcon)
			  or die('Queryfailed: ' . mysqli_error($dbcon).". <br><br> $continent_name already exists! Please try again!");

	$row = $result->fetch_row(); 

	echo "Successfully insert the new value!";
	echo '<br>';
	echo '<br>'; 

	// Echoing information in HTML
	echo '<table style = width 100%>
		<tr>
			<th>Continent Name</th>
			<th>Continent Details</th> 
		</tr>';

		echo '<tr>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '</tr>';
		
	echo '</table>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>