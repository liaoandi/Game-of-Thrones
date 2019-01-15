<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 


// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$battle_name = $_REQUEST['battle_name'];
$conflict = $_REQUEST['conflict'];
$battle_result = $_REQUEST['result'];

function mysqli_last_result($link) {
		while (mysqli_more_results($link)) {
			mysqli_use_result($link); 
			mysqli_next_result($link);
		}
		return mysqli_store_result($link);
	}

if (isset($_REQUEST['add'])) {
	echo '<h3>Data Write - 6: Add a battle</h3>';
	echo 'We are expected to see the new battle just added if it is not in the previous database.<br>';
	echo '<br>'; 

	$query =  " INSERT INTO Battle(battle_name, conflict, result)
							Values('$battle_name', '$conflict', '$battle_result');
				SELECT battle_name, conflict, result
				FROM Battle
				WHERE battle_id = (SELECT MAX(battle_id) FROM Battle);";

	mysqli_multi_query($dbcon, $query);
	$result = mysqli_last_result($dbcon)
			  or die('Queryfailed: ' . mysqli_error($dbcon).". <br><br> $battle_name already exists! Please try again!");

	$row = $result->fetch_row(); 

	echo "Successfully insert the new value!";
	echo '<br>';
	echo '<br>'; 

	// Echoing information in HTML
	echo '<table style = width 100%>
		<tr>
			<th>Battle Name</th>
			<th>Conflict</th> 
			<th>Result</th>
		</tr>';

		echo '<tr>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.$row[2].'</td>';
		echo '</tr>';
		
	echo '</table>';
}
elseif (isset($_REQUEST['delete'])) {
	echo '<h3>Data Write - 7: Delete a battle</h3>';
	echo 'We are expected to see battle being deleted if it is  in the previous database.<br>';
	echo '<br>'; 

	$query =  " DELETE FROM Battle
				WHERE battle_name = '$battle_name'
				OR conflict = '$conflict_name'
				OR result = '$battle_result';";
	$result = mysqli_query($dbcon, $query)
		or die('Queryfailed: ' . mysqli_error());
	if (mysqli_affected_rows($dbcon) > 0){
		echo "Successfully delete the value!";
	}
	else{
		echo "It seems that the record doesn't exist! Please try again!";
	}
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>