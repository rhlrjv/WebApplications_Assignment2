<?php
	// initialization
	
	session_save_path("$session_save_path");
	session_start();
	
	require ("userclass.php");
	$userobj = new user();	//Instantiate object of user class
	
	require ("taskclass.php");
	$taskobj = new task();
		
	/*Connect to database*/
	$dbhostname = "localhost";
	$dbport = "5432";
	$dbname = $db_name;
	$dbuser = $db_user;
	$dbpwd = $db_password;
	$connectionString = "host=$dbhostname port=$dbport dbname=$dbname user=$dbuser password=$dbpwd";
	
	$_SESSION['dbconn'] = pg_connect($connectionString);
	if(!$_SESSION['dbconn'])
		setErrorMsg("Can't connect to the database");
	/* end: Connect to database*/
	
	if(!isset($_SESSION['AppState']))
		$_SESSION['AppState'] = "l_out";
		
		
	if(!isset($_SESSION['TodoRate']))
		$_SESSION['TodoRate'] = 6;

			
	function clearSession()
	{
		session_unset();
	}
	
	function setState($toState)
	{
		switch($toState)
		{
			case "logged_in":
				$_SESSION['AppState'] = "l_in";
				return true;
				break;
			case "logged_out":
				clearSession();
				return true;
				break;
			default:
				return false;
				break;
		}
	}
	
	function isLoggedIn()
	{
		if($_SESSION['AppState'] == "l_in")
			return true;
		else
			return false;
	}

	//sets Username
	function setSessionUsername($uName)
	{
		$_SESSION['Username'] = $uName;
		return true;
	}
	
	//returns Username
	function getSessionUsername()
	{
		return $_SESSION['Username'];
	}
	
?>