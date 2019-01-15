<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Read - 4: Search a character</h3>';
echo 'We are expected to see all characters with the selected last name.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$last_name = $_REQUEST['last_name'];

$query =  " SELECT first_name, last_name, born_date, death_date, title, is_alive
			FROM People
			WHERE last_name = '$last_name';";

$result = mysqli_query($dbcon, $query)
	or die('Queryfailed: ' . mysqli_error());

// Echoing information in HTML
echo '<table style = width 100%>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Born Date</th>
		<th>Death Date</th>
		<th>Title</th>
		<th>Is alive</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	echo '<td>'.$tuple['first_name'].'</td>';
	echo '<td>'.$tuple['last_name'].'</td>';
	echo '<td>'.$tuple['born_date'].'</td>';
	echo '<td>'.$tuple['death_date'].'</td>';
	echo '<td>'.$tuple['title'].'</td>';
	echo '<td>'.$tuple['is_alive'].'</td>';
	echo '</tr>';
}	
echo '</table>
	  <br>'; 

echo '<br>
	 We can update the title if needed:
	 <br>
	 <br>';
echo '<form method = get class="form-inline" action="update_title.php">
		<div class="form-group">
			<label for="first_name">First Name:</label>
			<input type="text" class="form-control" placeholder="Sansa" name="first_name">
		</div>
		<br>
		<div class="form-group">
			<label for="last_name">Last Name:</label>
			<input type="text" class="form-control" placeholder="Stark" name="last_name">
		</div>
		<br>
		<div class="form-group">
			<label for="value">New Title:</label>
			<input type="text" class="form-control" placeholder="Princess" name="value">
		</div>
		<br>
		<button type="submit" class="btn btn-danger">Submit</button>
	</form>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>