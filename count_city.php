<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name'];

// Getting the input parameter (continent_name, is_capital):
$continent_name = $_REQUEST['continent_name'];
$is_capital = $_REQUEST['is_capital'];

echo '<h3>Data Read - 11.Find the number of city by condition</h3>';
if ($is_capital == "True"){
	echo "We are expected to see regions in $continent_name with capitals below.<br>";
	}
else{
	echo "We are expected to see the count of locations in each region inside $continent_name excluding the capital city below.<br>";
}
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
  	or die('Could not connect: ' . mysqli_connect_error());

$query =    "SELECT continent_name, r.region_name AS region_name, city_num
			FROM Region r
			NATURAL JOIN (SELECT continent_id, region_id, COUNT(location_id) AS city_num
							FROM Location
							WHERE is_capital = '$is_capital'
							GROUP BY continent_id, region_id
							ORDER BY city_num DESC)tmp
			NATURAL JOIN Continent c
			WHERE continent_name = '$continent_name'";

$result = mysqli_query($dbcon, $query)
   	or die('Query failed: ' . mysqli_error($dbcon));

// Displaying the result in two different ways.
if ($is_capital == "True"){
	echo "Here are regions in $continent_name with capital:";
	echo '<ul>';
	while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<li>'.$tuple['region_name'].'</li>';
	}	
	echo '</ul>';
}
else{
	echo '<table style = width 100%>
		<tr>
				<th>Region name</th>
				<th>City count</th> 
		</tr>';

	while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>';
		echo '<td>'.$tuple['region_name'].'</td>';
		echo '<td>'.$tuple['city_num'].'</td>';
		echo '</tr>';
	}	
	echo '</table>';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>