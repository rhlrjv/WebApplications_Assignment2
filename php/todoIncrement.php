<?php
	/* ------------------------------------------------
	 todoDelete.php: 

		delete a todo with an id which is unique
		for a specific username,
		otherwise the user is requested to refill/retry.

	Parameters: 

		username - required, non-empty string, the users user name
		id - required, non-empty string, the unique task id across users
		taskname - required, non-empty string, name of the task
		totalhrs - required, non-empty string, total hours for completion
		completedhrs - required, non-empty string, # of hours completed
		imp - required, non-empty string, is a task important

	Returns: 
		{ status: "ok" ,errors: "<unimportant>"} on success
		{ status: "error" , errors: "{msg: "<error msg array>" , username: "<error in user?>" , id: "<id Error?>" , taskname: "<taskname Error?>" , totalhrs: "<total hrs Error?>" , completedhrs: "<completed hrs Error?>", imp: "<imp Error?>"}"}"} on failure
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
	$errors['id'] = false ;//no error
	$errors['taskname'] = false ;//no error
	$errors['totalhrs'] = false ;//no error
	$errors['completedhrs'] = false ;//no error
	$errors['imp'] = false ;//no error

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

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	if($GLOBALS['taskobj']->decrementCompletedHrs ($_SESSION['dbconn'], $requestId))
	{
		$reply['status'] ='ok';
	}
	else
	{
		$errors['msg'][] ='Error decrementing completed hours';
	} 

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>
