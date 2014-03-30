<?php
	/* ------------------------------------------------
	 todoIncrement.php: 

		increment the completed hours of a todo 

	Parameters: 

		username - required, non-empty string, the users user name
		id - required, non-empty string, the unique task id across users

	Returns: 
		{ status: "ok" ,errors: "<unimportant>"} on success
		{ status: "error" , errors: "{msg: "<error msg array>" , id: "<id Error?>" , "}"}"} on failure
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
	$errors['id'] = false ;//no error


	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	if(!isset($_REQUEST['data']) || !isset($_REQUEST['requestType']) )
		goto leave;

	$data = json_decode($_REQUEST['data'],true);
	$requestType = $_REQUEST["requestType"];
	$requestUsername = $_SESSION['Username'];
	$requestId = $data["TodoID"];


	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	if(!$GLOBALS['taskobj']->checkIdExists($_SESSION['dbconn'], $requestId, $requestUsername))
	{
		$errors['msg'][] ='Task ID changed maliciously';
		$errors['id'] = true;
		goto leave;
	}
	else
	{
		$timeinfo = $GLOBALS['taskobj']->getHrsById($_SESSION['dbconn'], $requestId, $requestUsername);
		if($timeinfo['completedhrs'] == $timeinfo['totalhrs'])
		{
			$errors['msg'][] ='Completed hours equal total hours';
			$errors['completedhrs'] = true;
			goto leave;
		}
	}

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	if($GLOBALS['taskobj']->incrementCompletedHrs($_SESSION['dbconn'], $requestId))
	{
		$reply['status'] ='ok';
	}
	else
	{
		$errors['msg'][] ='Error incrementing completed hours';
	} 

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>
