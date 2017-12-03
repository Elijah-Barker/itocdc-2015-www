<?php
// opens the database connection

//$DATABASE_NAME = "application";

/*	
function connectToDB ()
{
	// define host, database name, username, and password of SQL database
	$DATABASE_IP = "127.0.0.1"; // 76.5.61.21 // Set to the IP address of your database server
	$DATABASE_USERNAME = "applicationuser";
	$DATABASE_PASSWORD = "thi5i5p1aint3xt";
	$connection = mysql_connect($DATABASE_IP, $DATABASE_USERNAME, $DATABASE_PASSWORD) or die ('Error connecting to mysql');
	return $connection;
}//*/

function CreateHandler()
{
	try
	{
		$DATABASE_IP = "127.0.0.1"; // 76.5.61.21 // Set to the IP address of your database server
		$DATABASE_NAME = "application";
		$DATABASE_USERNAME = "applicationuser";
		$DATABASE_PASSWORD = "thi5i5p1aint3xt";
		$handler = new PDO("mysql:host=$DATABASE_IP;dbname=$DATABASE_NAME", $DATABASE_USERNAME, $DATABASE_PASSWORD);
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch( PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues");
		die();
	}

	return $handler;
}

function FetchClips($N)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT host, title, shortname, posted, views FROM clips ORDER BY views DESC, posted DESC LIMIT ".(int)$N);
		$prepStatement->execute();
		
		return $prepStatement;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function FetchUserClips($userID)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT host, title, shortname, posted, views FROM clips WHERE user = ? ORDER BY views DESC, posted DESC");
		$prepStatement->execute(array($userID));
		
		return $prepStatement;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function FetchClip($shortname)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT host, title, description, posted, user, views, extension FROM clips WHERE shortname = ?");
		$prepStatement->execute(array($shortname));
		
		return $prepStatement;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function userIDToUsername($userID)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT username FROM users WHERE id = ?");
		$prepStatement->execute(array($userID));
		
		$userRow = $prepStatement->fetch(PDO::FETCH_ASSOC);
		$username = $userRow['username'];
		
		return $username;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function emailToUserID($email)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT id FROM users WHERE email = ?");
		$prepStatement->execute(array($email));
		
		$userRow = $prepStatement->fetch(PDO::FETCH_ASSOC);
		$userID = $userRow['id'];
		
		return $userID;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function updateHitCount($shortname)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("UPDATE clips SET views=views+1 WHERE shortname=?");
		$prepStatement->execute(array($shortname));
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
		exit();
	}
}

function getUserInfo($username)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("SELECT id, email FROM users WHERE username=?");
		$prepStatement->execute(array($username));
		$userRow = $prepStatement->fetch(PDO::FETCH_ASSOC);
		return $userRow;
	}
	catch(PDOException $exception)
	{
		header('Location: /post.php?message=' . urlencode("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")"));
		exit();
	}
}

function insertVideo($host, $shortname, $title, $description, $userID, $extension)
{
	try
	{
		$handler = CreateHandler();
		$prepStatement = $handler->prepare("INSERT INTO clips (host, shortname, title, description, user, extension) VALUES (:host, :shortname, :title, :description, :userID, :extension)");
		$prepStatement->bindValue(":host", $host);
		$prepStatement->bindValue(":shortname", $shortname);
		$prepStatement->bindValue(":title", $title);
		$prepStatement->bindValue(":description", $description);
		$prepStatement->bindValue(":userID", $userID);
		$prepStatement->bindValue(":extension", $extension);
		$prepStatement->execute();
		
		return true;
	}
	catch(PDOException $exception)
	{
		print("We apologize for the inconvenience. Our Database is having connectivity issues. (".$exception->getMessage().")");
	}
	return false;
}



// $conn = connectToDB();

// connects to the specific database on the MySQL server
//mysql_select_db($DATABASE_NAME);

//unset($DATABASE_NAME);
?>
