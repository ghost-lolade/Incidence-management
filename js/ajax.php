<?php
/*
Site : http:www.smarttutorials.net
Author :muni
*/
define('DB_HOST', 'localhost');
define('DB_NAME', 'laravel_mercyland');
define('DB_USERNAME','root');
define('DB_PASSWORD','');


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

if($_POST['type'] == 'country_table'){
	$row_num = $_POST['row_num'];
	$name = $_POST['name_startsWith'];
	$query = "SELECT name, numcode, phonecode, iso3 FROM country where UPPER(name) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['name'].'|'.$row['numcode'].'|'.$row['phonecode'].'|'.$row['iso3'].'|'.$row_num;
		array_push($data, $name);	
	}	
	echo json_encode($data);
}


