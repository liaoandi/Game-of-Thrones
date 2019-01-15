<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 4: Update a Character-House Connections</h3>';
echo 'We are expected to see changes of connections for the given character to the selected house.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$house_name = 'House '.$_REQUEST['house_name'];
$connect = $_REQUEST['connect'];

$query =  " UPDATE PeopleBelongHouse AS p
			INNER JOIN(
				SELECT people_id
				FROM People
				WHERE first_name = '$first_name'
				AND last_name = '$last_name') t1 ON p.people_id = t1.people_id
			INNER JOIN (
				SELECT house_id
				FROM House
				WHERE house_name = '$house_name') t2 ON p.house_id = t2.house_id
			SET connect = '$connect';
			SELECT h.house_name AS house_name, p2.first_name AS first_name, 
				p2.last_name AS last_name, p1.connect AS connect
			FROM PeopleBelongHouse p1
			INNER JOIN House h
				ON p1.house_id = h.house_id
			INNER JOIN People p2
				ON p1.people_id = p2.people_id
			WHERE house_name = '$house_name'
			AND first_name = '$first_name'
			AND last_name = '$last_name';";

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
	echo "Successfully change the connection as follows!";
	echo '<br>';
	echo '<br>'; 

	$row = $result->fetch_row(); 

	echo '<table style = width 100%>
		<tr>
			<th>House Name</th>
			<th>First Name</th>
			<th>Last Name</th> 
			<th>Connection</th>
		</tr>';

		echo '<tr>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.$row[2].'</td>';
		echo '<td>'.$row[3].'</td>';
		echo '</tr>';
		
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