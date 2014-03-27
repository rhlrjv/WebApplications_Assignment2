<?php
	/* ------------------------------------------------
	 userCreate.php: 

		sign up as a new user if username is unique
		and all other form fieldds are valid,
		otherwise the user is requested to refill/retry.

	Parameters: 

		username - required, non-empty string, the users user name
		password - required, non-empty string, the users password
		re-enter password - required, non-empty string, same as the users password
		email - required, non-empty string, the users email
		dob - required, non-empty string, the users date of birth

	Returns: 
		{ status: "ok" } on success
		{ status: "<error messages>" } on failure
	
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
	$_SESSION["is_logged_in"]="false";

	$reply['status'] ='error';

	$errors['msg'] = array();
	$errors['username'] = false ;//no error
	$errors['password'] = false ;//no error
	$errors['reenterpassword'] = false ;//no error
	$errors['email'] = false ;//no error
	$errors['dob'] = false ;//no error

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	if(!isset($_REQUEST['data']) || !isset($_REQUEST['requestType']) )
		goto leave;

	$data = json_decode($_REQUEST['data'],true);
	$requestType = $_REQUEST["requestType"];
	$requestUsername = $data["UserName"];
	$requestPassword = $data["Password"];
	$requestReenterpassword = $data["reEnterPassword"];
	$requestEmail = $data["email"];
	$requestDob = $data["dob"];

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	if(empty($requestUsername) || empty($requestPassword) || empty($requestReenterpassword) || empty($requestEmail) || empty($requestDob)){
		$errors['msg'][] ='Incomplete form fields';

		if(empty($requestUsername))
			$errors['username'] = true;
		if(empty($requestPassword))
			$errors['password'] = true;
		if(empty($requestReenterpassword))
			$errors['reenterpassword'] = true;
		if(empty($requestEmail))
			$errors['email'] = true;
		if(empty($requestDob))
			$errors['dob'] = true;
	}

	if($requestPassword != $requestReenterpassword)
	{
		$errors['msg'][] ='Passwords dont match';
		$errors['password'] = true;
		$errors['reenterpassword'] = true;
	}

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $requestUsername))
	{
	    $errors['msg'][] ='Username cannot have special characters';
	    $errors['username'] = true;
	    $errors['reenterpassword'] = true;
	}

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $requestPassword))
	{
	    $errors['msg'][] ='Password cannot have special characters';
	    $errors['password'] = true;
	}

	if($GLOBALS['userobj']->duplicateUsername($_SESSION['dbconn'], $requestUsername))
	{
		$errors['msg'][] ='Username already exists';
		$errors['username'] = true;
	}

	if (count($errors['msg']) > 0)
		goto leave;

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	if($GLOBALS['userobj']->signup($_SESSION['dbconn'], $requestUsername, $requestPassword, $requestEmail, $requestDob) == true)
	{
		$reply['status']= 'ok';
		goto leave;
	} 

	else 
	{
		$errors['msg'][] ='Incorrect sign up details';
	}

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>
