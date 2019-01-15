<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Warehouse - 2: Change of Location Owner Data Warehouse</h3>';
echo 
'Show the changes of location owners. The owners of locations change a lot during the war time. Creating a record for the owner change can help us to keep track of the territory of each house easily.
</br>
</br>
The following mini datawarehouse stores the information of all the changes of location owners in the TV show, including the location name, previous and present owner, and how the change happened. 
</br>
</br>
It involves table House, Timeline, Battle and Location and changes to these records. By putting all the relevant records into a data warehouse table, we can quickly know the details without joining four tables. More specifically, operations like updating the ruler_house_id in table Region are converted to a full record in this warehouse.
</br>';

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

// Listing tables in the database
$query = 'SELECT record_id, location_name, previous_owner, present_owner, change_date, battle, outcome
		  FROM LocationInfo';
$result = mysqli_query($dbcon, $query)
	or die('Find records failed: ' . mysqli_error());

echo '<br>';
echo "The owner changing records in database are:<br>";
echo '<br>';

// Echoing info in HTML
echo '<table style = width 100%>
	<tr>
		<th>Record ID</th>
		<th>Location Name</th> 
		<th>Previous Owner</th>
		<th>Present Owner</th>
		<th>Change Date</th>
		<th>Battle</th>
		<th>Outcome</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	echo '<td>'.$tuple['record_id'].'</td>';
	echo '<td>'.$tuple['location_name'].'</td>';
	echo '<td>'.$tuple['previous_owner'].'</td>';
	echo '<td>'.$tuple['present_owner'].'</td>';
	echo '<td>'.$tuple['change_date'].'</td>';
	echo '<td>'.$tuple['battle'].'</td>';
	echo '<td>'.$tuple['outcome'].'</td>';
	echo '</tr>';
}	
echo '</table>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>