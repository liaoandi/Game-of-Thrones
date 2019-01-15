<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

// Getting the input parameter (last_name, role, outcome):
$last_name = $_REQUEST['last_name'];
$role = $_REQUEST['role'];
$outcome = $_REQUEST['outcome'];

echo '<h3>Data Read - 10.Find the battle satisfying the input condition</h3>';
echo "We are expected to see the battle name if there exists one or more records.<br>";
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$modified_last_name = '%'.$last_name.'%';
$query =    "SELECT battle_name
			FROM House h
			NATURAL JOIN BattleParticipateHouse b1
			NATURAL JOIN Battle b2
			WHERE h.house_name LIKE '$modified_last_name'
			AND b1.role = '$role'
			AND b1.outcome = '$outcome'";

$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

// Checking if the input values are not correct
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 0){
	echo "Can not find any battle by selected condition! Please try another combination!";
}
else{
	echo '<ul>';
	while ($tuple = mysqli_fetch_row($result)) {
		echo '<li>'.$tuple[0].'</li>';
	}
	echo '</ul>';
}


echo '<br>
	 We can update the casualty if needed:
	 <br>
	 <br>';
echo '<form method = get class="form-inline" action="update_outcome.php">
		<div class="form-group">
			<label for="battle_name">Battle Name:</label>
			<input type="text" class="form-control" placeholder="Battle of the Blackwater" name="battle_name">
		</div>
		<br>
		<div class="form-group">
			<label for="value">New Casualty:</label>
			<input type="text" class="form-control" placeholder="Boom" name="value">
		</div>
		<br>
		<button type="submit" class="btn btn-danger">Submit</button>
	</form>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>