<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 3: Add a house</h3>';
echo 'We are expected to see the new house just added if it is not in the previous database.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$house_name = $_REQUEST['house_name'];
$motto = $_REQUEST['motto'];
$flag = $_REQUEST['flag'];

$query =  " INSERT INTO House(house_name, motto, flag)
						Values('$house_name', '$motto', '$flag');
			SELECT house_name, motto, flag
			FROM House
			WHERE house_id = (SELECT MAX(house_id) FROM House);";

function mysqli_last_result($link) {
	while (mysqli_more_results($link)) {
		mysqli_use_result($link); 
		mysqli_next_result($link);
	}
	return mysqli_store_result($link);
}

mysqli_multi_query($dbcon, $query);
$result = mysqli_last_result($dbcon)
		  or die('Queryfailed: ' . mysqli_error($dbcon).". <br><br> $house_name already exists! Please try again!");

$row = $result->fetch_row(); 

echo "Successfully insert the new value!";
echo '<br>';
echo '<br>'; 

// Echoing information in HTML
echo '<table style = width 100%>
	<tr>
		<th>House Name</th>
		<th>Motto</th> 
		<th>Flag</th>
	</tr>';

	echo '<tr>';
	echo '<td>'.$row[0].'</td>';
	echo '<td>'.$row[1].'</td>';
	echo '<td>'.$row[2].'</td>';
	echo '</tr>';
	
echo '</table>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>