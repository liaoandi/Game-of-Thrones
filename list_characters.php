<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Read - 2: List all characters</h3>';
echo 'We are expected to see all characters in the database below. This can help users to know about the most important characters in the Game of Thrones TV show.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

// Listing characters in the database
$query = 'SELECT first_name, last_name, title, is_alive FROM People';
$result = mysqli_query($dbcon, $query)
	or die('Queryfailed: ' . mysqli_error());

echo "The characters in database are:<br>";
echo '<br>';
// Echoing information in HTML
echo '<table style = width 100%>
	<tr>
		<th>First Name</th>
		<th>Last Name</th> 
		<th>Title</th>
		<th>Is alive</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	if ($tuple['first_name'] == 'Arya'){
		echo '<td><a href = "funny.php">'.$tuple['first_name'].'</a></td>';
	}
	else{
		echo '<td>'.$tuple['first_name'].'</td>';
	}
	echo '<td>'.$tuple['last_name'].'</td>';
	echo '<td>'.$tuple['title'].'</td>';
	echo '<td>'.$tuple['is_alive'].'</td>';
	echo '</tr>';

}	
echo '</table>';


// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>