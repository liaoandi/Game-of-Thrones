<?php

// Connection parameters
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

// Getting the input parameter (relation_name):
$relation_name = $_REQUEST['relation_name'];

echo '<h3>Data Read - 3: Find the list of characters by selecting a relationship type</h3>';
echo "We are expected to see all people with relationship type LIKE $relation_name below.<br>";
echo '<br>'; 

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error()); 

// Constructing an extra parameter to handle the like syntax
$modified_relation_name = '%'.$relation_name.'%';
$query =    "SELECT p1.first_name AS first_name_1, p1.last_name AS last_name_1, 
					p2.first_name AS first_name_2, p2.last_name AS last_name_2,
					people_relation
			FROM PeopleFriend p 
			INNER JOIN People p1
				ON p.people_id = p1.people_id
			INNER JOIN People p2
				ON p.people_id_fk = p2.people_id
			WHERE people_relation LIKE '$modified_relation_name'";

$result = mysqli_query($dbcon, $query)
   	or die('Query failed: ' . mysqli_error($dbcon));

// Checking if the input values are not correct
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 0){
	echo "$relation_name not found! Please try again!";
}
else{
	// displaying the result in a table
	echo '<table style = width 100%>
		<tr>
				<th>First Name 1</th>
				<th>Last Name 1</th> 
				<th>First Name 2</th>
				<th>Last Name 2</th>
				<th>Relation</th>
		</tr>';

	while ($tuple = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>';
		echo '<td>'.$tuple['first_name_1'].'</td>';
		echo '<td>'.$tuple['last_name_1'].'</td>';
		echo '<td>'.$tuple['first_name_2'].'</td>';
		echo '<td>'.$tuple['last_name_2'].'</td>';
		echo '<td>'.$tuple['people_relation'].'</td>';
		echo '</tr>';
	}	
	echo '</table>';
}

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>