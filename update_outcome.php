<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 7: Update Outcome of Battle</h3>';
echo 'We are expected to see changes of outcome for the given battle.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$battle_name = $_REQUEST['battle_name'];
$new_casualty = $_REQUEST['value'];


$query =  " UPDATE BattleParticipateHouse AS b1
			SET casualty = '$new_casualty'
			WHERE battle_id IN
				(SELECT battle_id
				FROM Battle 
				WHERE battle_name = '$battle_name');
			SELECT battle_name, role, outcome, casualty
			FROM Battle
			NATURAL JOIN BattleParticipateHouse 
			WHERE battle_name = '$battle_name';";

function mysqli_last_result($link) {
	while (mysqli_more_results($link)) {
		mysqli_use_result($link); 
		mysqli_next_result($link);
	}
	return mysqli_store_result($link);
}

mysqli_multi_query($dbcon, $query);
$result = mysqli_last_result($dbcon)
		  or die('Queryfailed: ' . mysqli_error($dbcon));

if (mysqli_affected_rows($dbcon) > 0){  
	echo "Successfully change the outcome as follows!";
	echo '<br>';
	echo '<br>'; 

	echo '<table style = width 100%>
		<tr>
			<th>Battle Name</th>
			<th>Role</th>
			<th>Outcome</th> 
			<th>Casualty</th>
		</tr>';

	while($row = $result->fetch_row()){ 
		echo '<tr>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.$row[2].'</td>';
		echo '<td>'.$row[3].'</td>';
		echo '</tr>';
		
	}
	echo '</table>';
}
else{
	echo 'Update Failure! Please check your input carefully!';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>