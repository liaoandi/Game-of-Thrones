<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 2: Update the title</h3>';
echo 'We are expected to see changes of title for the given character.<br>';
echo '<br>'; 

$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$new_title = $_REQUEST['value'];

$query =  " UPDATE People
			SET title = '$new_title'
			WHERE first_name  = '$first_name'
			AND last_name = '$last_name';
			SELECT first_name, last_name, title
			FROM People
			WHERE first_name  = '$first_name'
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
	echo "Successfully change the title as follows!";
	echo '<br>';
	echo '<br>'; 

	$row = $result->fetch_row(); 

	echo '<table style = width 100%>
		<tr>
			<th>First Name</th>
			<th>Last Name</th> 
			<th>Title</th>
		</tr>';

		echo '<tr>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.$row[2].'</td>';
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