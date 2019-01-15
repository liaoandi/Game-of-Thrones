<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

// Getting the input parameter (house_name):
$house_name = $_REQUEST['house_name'];

echo '<h3>Data Read - 6.Calculate the victory rate of a house</h3>';
echo "We are expected to see $house_name along with its victory rate below.<br>";
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$query =    "SELECT house_name, sub_cnt/cnt AS victory_rate
			FROM (SELECT house_id, outcome, COUNT(*) AS sub_cnt
				  FROM BattleParticipateHouse 
				  WHERE outcome = 'Win'
				  GROUP BY house_id, outcome)t1,
				 (SELECT house_id, COUNT(*) AS cnt
				  FROM BattleParticipateHouse b
				  GROUP BY house_id)t2,
				  House h
			WHERE t1.house_id = t2.house_id
			AND t1.house_id = h.house_id
			AND house_name = '$house_name'";

$result = mysqli_query($dbcon, $query)
   	or die('Query failed: ' . mysqli_error($dbcon));

// Checking if the house name is not correct
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 0){
	echo "The input $house_name is not valid! Please try again!";
}
else{
	$tuple = mysqli_fetch_array($result, MYSQLI_ASSOC);
	//echoing result in HTML
	echo '<ul>';
	echo '<li> House name: '.$tuple['house_name'];
	echo '<li> Victory rate: '.$tuple['victory_rate'];
	echo '</ul>';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>
