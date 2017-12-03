<?php
// opens the database connection

$DATABASE_NAME = "application";
	
function connectToDB ()
{
	// define host, database name, username, and password of SQL database
	$DATABASE_IP = "127.0.0.1"; // 76.5.61.21 // Set to the IP address of your database server
	$DATABASE_USERNAME = "applicationuser";
	$DATABASE_PASSWORD = "thi5i5p1aint3xt";
	$connection = mysql_connect($DATABASE_IP, $DATABASE_USERNAME, $DATABASE_PASSWORD) or die ('Error connecting to mysql');
	return $connection;
}

$conn = connectToDB();

// connects to the specific database on the MySQL server
mysql_select_db($DATABASE_NAME);

unset($DATABASE_NAME);
?>
