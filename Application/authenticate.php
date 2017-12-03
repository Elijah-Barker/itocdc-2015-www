<?php

// session utils
include 'sessions.php';

// get POST information from login form
$email=$_POST["email"];
$password=$_POST["password"];

// open connection to the database
include 'config.php';
include 'opendb.php';

// ***** implement new session here *****

// use prepared statement
// select password where email = email
// then check password
//// get user data from the users table (assumes users table already exists!)
$result = mysql_query("SELECT * FROM users WHERE email='" . $email . "'" . " AND password=" . "'" . $password . "'");

// authenticate user
$login = mysql_num_rows($result) > 0;


//create new session
if($login)
{
	// set an active cookie for this username
	$_SESSION['LoggedIn'] = true;
	$_SESSION['Email'] = $_POST["email"];
	$_SESSION['Created'] = time();
	$_SESSION['LastActivity'] = time();
	$_SESSION['IP'] = getenv("REMOTE_ADDR");
	header('Location: /index.php');
}
else
{
	// logout
	session_unset();
	session_destroy();
	header('Location: /login.php?message=Login%20Failed');
}
// *****  *****


// close connection to the database
include 'closedb.php';

?>
