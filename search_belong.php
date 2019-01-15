<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Read - 8: Search Character-House Connection</h3>';
echo 'We are expected to see all characters who are connected with the selected house name.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$house_name = $_REQUEST['house_name'];
$house_name_revised = 'House '.$house_name;

$query =  " SELECT h.house_name AS house_name, p2.first_name AS first_name, 
			p2.last_name AS last_name, p1.connect AS connect
			FROM PeopleBelongHouse p1
			NATURAL JOIN House h
			NATURAL JOIN People p2
			WHERE house_name = '$house_name_revised';";

$result = mysqli_query($dbcon, $query)
	or die('Queryfailed: ' . mysqli_error());

// Echoing information in HTML
echo '<table style = width 100%>
	<tr>
		<th>House Name</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Connection</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	echo '<td>'.$tuple['house_name'].'</td>';
	echo '<td>'.$tuple['first_name'].'</td>';
	echo '<td>'.$tuple['last_name'].'</td>';
	echo '<td>'.$tuple['connect'].'</td>';
	echo '</tr>';
}	
echo '</table>
	  <br>'; 

echo '<br>
	 We can update the connection if needed:
	 <br>
	 <br>';
echo '<form method = get class="form-inline" action="update_connection.php">
		<div class="form-group">
			<label for="first_name">First Name:</label>
			<input type="text" class="form-control" placeholder="Theon" name="first_name">
		</div>
		<br>
		<div class="form-group">
			<label for="last_name">Last Name:</label>
			<input type="text" class="form-control" placeholder="Greyjoy" name="last_name">
		</div>
		<br>
		<div class="form-group">
			<label for="house_name">House Name:</label>
			<select name = "house_name">
				<option value = '.$house_name.'>'.$house_name.'</option>
			</select>
		</div>
		<br>
		<div class="form-group">
			<label for="connect">New Connection:</label>
				<select class="form-control" name = "connect">
					<option value = "By Birth">By Birth</option>
					<option value = "By Marriage">By Marriage</option>
					<option value = "By Law">By Law</option>
					<option value = "By Adoption">By Adoption</option>
				</select>
		</div>
		<br>
		<button type="submit" class="btn btn-danger">Submit</button>
	</form>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>