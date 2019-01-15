<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Warehouse - 1: Death</h3>';
echo 
'Show the details information for death. It is interesting to analyze how people died in Game of Thrones, as people said that there are more than a thousand ways to kill a preson in this TV show. And indeed, people can die of all kinds of reasons.
</br>
</br>
The following mini datawarehouse stores the information of all the deaths in the TV show, including the character name, his house, death season, which battle or event leads to his death. 
</br>
</br>
It involves table People, House, Timeline, Battle and BattleParticipateHouse and changes to these records. By putting all the relevant records into a data warehouse table, we can quickly know the details without joining five tables, and summarize which season witnesses the most deaths, or calculate the average age of deaths.
</br>';

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

// Listing tables in the database
$query = 'SELECT death_id, first_name, last_name, house_name, age, death_season, death_reason, in_what_way
		  FROM Death';
$result = mysqli_query($dbcon, $query)
	or die('Find records failed: ' . mysqli_error());

echo '<br>';
echo "The death records in database are:<br>";
echo '<br>';

// Echoing info in HTML
echo '<table style = width 100%>
	<tr>
		<th>Death ID</th>
		<th>First Name</th> 
		<th>Last Name</th>
		<th>House Name</th>
		<th>Age</th>
		<th>Death Season</th>
		<th>Death Reason</th>
		<th>In What Way</th>
	</tr>';

while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>';
	echo '<td>'.$tuple['death_id'].'</td>';
	echo '<td>'.$tuple['first_name'].'</td>';
	echo '<td>'.$tuple['last_name'].'</td>';
	echo '<td>'.$tuple['house_name'].'</td>';
	echo '<td>'.$tuple['age'].'</td>';
	echo '<td>'.$tuple['death_season'].'</td>';
	echo '<td>'.$tuple['death_reason'].'</td>';
	echo '<td>'.$tuple['in_what_way'].'</td>';
	echo '</tr>';
}	
echo '</table>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>