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
		
	if(!isset($_SESSION['Page']))
		$_SESSION['Page'] = "home";
		
	if(!isset($_SESSION['ErrMsg']))
		$_SESSION['ErrMsg'] = "";
		
	if(!isset($_SESSION['Msg']))
		$_SESSION['Msg'] = "";
	
	if(!isset($_SESSION['Username']))
		$_SESSION['Username'] = "";
		
	if(!isset($_SESSION['AddTodo']))
		$_SESSION['AddTodo'] = false;
		
	if(!isset($_SESSION['EditTodo']))
		$_SESSION['EditTodo'] = 0;
		
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
				$_SESSION['Page'] = "todo";
				header("Location: ?page=todo"); //reload to new page
				return true;
				break;
			case "logged_out":
				clearSession();
				$_SESSION['AppState'] = "l_out";
				$_SESSION['Page'] = "home";
				header("Location: ");			//reload to new page
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
	
	//changes the current page in the session data
	function setPage($toPage)
	{	
		$_SESSION['Page']=$toPage;
		return true;
	}
	
	//gets the page from the session data
	function getPage()
	{	
		return $_SESSION['Page'];
	}
	
	//sets Error Msg
	function setErrorMsg($errMsg)
	{
		$_SESSION['ErrMsg'] = $errMsg;
		return true;
	}
	
	//returns and Resets Error msg
	function getErrorMsg()
	{
		$errMsg = $_SESSION['ErrMsg'];
		$_SESSION['ErrMsg'] = "";
		return $errMsg;
	}
	
	function setMsg($errMsg)
	{
		$_SESSION['Msg'] = $errMsg;
		return true;
	}
	
	//returns and Resets Error msg
	function getMsg()
	{
		$errMsg = $_SESSION['Msg'];
		$_SESSION['Msg'] = "";
		return $errMsg;
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
	
	function getRandomNumer()
	{
		$_SESSION['rand'] = rand(100,999);
		return $_SESSION['rand'];
	}
	
	function isCorrectRandomNumer($rNo){
		if($_SESSION['rand'] == $rNo)
			return true;
		else
			return false;
	}
	
	function setEditTodoID($id)
	{
		$_SESSION['EditTodo'] = $id;
		return true;
	}
	
	function clrEditTodoID()
	{
		$_SESSION['EditTodo'] = 0;
	}
	
	//returns Username
	function getEditTodoID()
	{
		return $_SESSION['EditTodo'];
	}
?>