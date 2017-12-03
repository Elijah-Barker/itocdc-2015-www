<?php

include 'headers.php';
include 'sessions.php';
include 'config.php';

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email']))
{
	session_unset();
	session_destroy();
}

// get POST information from login form
$email=$_POST["email"];
$username=$_POST["username"];
$password=$_POST["password"];

// open connection to the database

//include 'opendb.php';//included in sessions.php


// make sure user doesn't already exist
//include 'usercheck.php';
if (EmailExists($email))
{
	header('Location: /registration.php?message='.urlencode("User with email '$email' already exixts."));
}
elseif (UserExists($username))
{
	header('Location: /registration.php?message='.urlencode("User '$username' already exixts."));
}
else
{
	// register user
	$result = CreateUser($email, $username, $password);
	
	// Log them in.
	if ($result)
	{
		// successfully created user, set an active cookie for this username
		$_SESSION['LoggedIn'] = true;
		$_SESSION['Email'] = $_POST["email"];
		$_SESSION['Created'] = time();
		$_SESSION['LastActivity'] = time();
		$_SESSION['IP'] = getenv("REMOTE_ADDR");
		header('Location: /index.php');
	}
	else
	{
		header('Location: /registration.php?message=' . urlencode(mysql_error($conn)));
	}
	
}

// close connection to the database
include 'closedb.php';

?>
