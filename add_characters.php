<?php

// Connection parameters 
$ini = parse_ini_file('config.ini');
$host = $ini['db_host'];
$username = $ini['db_user'];  
$password = $ini['db_password'];  
$database = $ini['db_name']; 

echo '<h3>Data Write - 5: Add a character</h3>';
echo 'We are expected to see the new character just added if it is not in the previous database. A trigger is also added to set the default is_alive value as false.<br>';
echo '<br>'; 

// Attempting to connect 
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];

$query =  " DROP TRIGGER IF EXISTS PeopleAliveTrigger;
			CREATE TRIGGER PeopleAliveTrigger
			BEFORE INSERT ON People
			FOR EACH ROW	
				BEGIN	
					IF (NEW.death_date IS NULL) 
					THEN SET NEW.is_alive = 'False';
					END IF;	
				END; 
			INSERT INTO People(first_name, last_name)
						Values('$first_name', '$last_name');
			SELECT first_name, last_name, is_alive
				FROM People
				WHERE people_id = (SELECT MAX(people_id) FROM People);";

function mysqli_last_result($link) {
	while (mysqli_more_results($link)) {
		mysqli_use_result($link); 
		mysqli_next_result($link);
	}
	return mysqli_store_result($link);
}

mysqli_multi_query($dbcon, $query);
$result = mysqli_last_result($dbcon)
		  or die('Queryfailed: ' . mysqli_error($dbcon).". <br><br> $first_name , $last_name already exists! Please try again!");

$row = $result->fetch_row(); 

echo "Successfully insert the new value!";
echo '<br>';
echo '<br>'; 

// Echoing information in HTML
echo '<table style = width 100%>
	<tr>
		<th>First Name</th>
		<th>Last Name</th> 
		<th>Is alive</th>
	</tr>';

	echo '<tr>';
	echo '<td>'.$row[0].'</td>';
	echo '<td>'.$row[1].'</td>';
	echo '<td>'.$row[2].'</td>';
	echo '</tr>';
	
echo '</table>';

// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?>