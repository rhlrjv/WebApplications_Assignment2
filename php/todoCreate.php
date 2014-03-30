<?php
	/* ------------------------------------------------
	 todoCreate.php: 

		create a todo with an id which is unique
		if all form fields are valid,
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
		{ status: "error" , errors: "{msg: "<error msg array>" , username: "<error in user?>" , taskname: "<taskname Error?>" , totalhrs: "<total hrs Error?>" , completedhrs: "<completed hrs Error?>", imp: "<imp Error?>"}"}"} on failure
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
	$requestTaskname = $data["TodoName"];
	$requestTotalHrs = $data["TodoHours"];
	$requestCompletedhrs = $data["TodoHoursCompleted"];

	if($data["TodoHoursCompleted"] == "")
		$requestCompletedhrs = 0;
	else
		$requestCompletedhrs = $data["TodoHoursCompleted"];

	if(isset($data["TodoImportant"]))
		$requestImp = true;
	else
		$requestImp = false;

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	if(empty($requestTaskname))
	{
		$errors['msg'][] ='No task name';
		$errors['taskname'] = true;
	}

	if(strlen($requestTaskname) > 40)
	{
		$errors['msg'][] ='Task name should be less than 40 characters';
		$errors['taskname'] = true;
	}

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $requestTaskname))
	{
	    $errors['msg'][] ='Taskname cannot have special characters';
	    $errors['taskname'] = true;
	}

	if($requestTotalHrs < $requestCompletedhrs)
	{
		$errors['msg'][] ='Total number of hours lesser than hours completed.';
		$errors['totalhrs'] = true;
		$errors['completedhrs'] = true;
	}

	if($requestTotalHrs == "" || $requestTotalHrs <= 0 )
	{
		$errors['msg'][] ='Invalid total hours.';
		$errors['totalhrs'] = true;
	}

	if($requestCompletedhrs < 0)
	{
		$errors['msg'][] ='Invalid hours completed.';
		$errors['completedhrs'] = true;
	}

	if (count($errors['msg']) > 0)
		goto leave;

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	if($GLOBALS['taskobj']->addtodo($_SESSION['dbconn'], $requestTaskname, $requestTotalHrs, $requestCompletedhrs, $requestImp, $requestUsername))
	{
		$reply['status']= 'ok';
	} 
	else 
	{
		$errors['msg'][] ='Incorrect task details';
	}

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>
