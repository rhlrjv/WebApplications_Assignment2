<?php
	/* ------------------------------------------------
	 userLogin.php: 

		login to the application if valid credentials 
		are supplied, otherwise the user is logged out.

		$_SESSION['is_logged_in']=="true" on success
		$_SESSION['is_logged_in']=="false" on failure

	Parameters: 
		
		RequestType - required, non-empty string, not used in this case
		UserName - required, non-empty string, the users user name
		Password - required, non-empty string, the users password

	Returns: 
		{ status: "ok" ,errors: "<unimportant>"} on success
		{ status: "error" , errors: "{msg: "<error msg array>" , username: "<error in user?>" , password: "<passwordError?>"}"} on failure
			error message codes = true/false 
				any true value -> field marked as error field in front end
	
	------------------------------------------------ */

	require 'config.inc';
	require 'Model.php';

	header('Content-Type: application/json');

	// ------------------------------------------------
	// Default reply
	// ------------------------------------------------
	$reply = array();
	$errors = array();

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------	
	$reply['status'] ='error';

	$errors['msg'] = array();
	$errors['username'] = false ;//no error
	$errors['password'] = false ;//no error

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	if(!isset($_REQUEST['data']) || !isset($_REQUEST['requestType']) )
		goto leave;

	$data = json_decode($_REQUEST['data'],true);
	$requestType = $_REQUEST["requestType"];
	$requestUsername = $data["UserName"];
	$requestPassword = $data["Password"];

	// ------------------------------------------------
	// check Parameters
	// ------------------------------------------------

	if(empty($requestUsername) || empty($requestPassword)){
		$errors['msg'][] ='Incomplete form fields';

		if(empty($requestPassword))
			$errors['password'] = true;
		if(empty($requestUsername))
			$errors['username'] = true;
	}

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $requestUsername))
	{
	    $errors['msg'][] ='Username cannot have special characters';
	    $errors['username'] = true;
	}

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $requestPassword))
	{
	    $errors['msg'][] ='Password cannot have special characters';
	    $errors['password'] = true;
	}

	if (count($errors['msg']) > 0)
		goto leave;
	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	if($GLOBALS['userobj']->login($_SESSION['dbconn'], $requestUsername, $requestPassword) == true)
	{
		$reply['status']= 'ok';
		setState("logged_in");
		$_SESSION['Username'] = $requestUsername;
	}
	else
	{
		setState("logged_out");
		$errors['msg'][] ='Incorrect login details';
	}

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>