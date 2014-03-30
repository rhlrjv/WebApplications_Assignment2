<?php
	/* ------------------------------------------------
	 todoUpdateRate.php: 

		update rate of todo with an id which is unique
		for a specific username,
		otherwise the user is requested to refill/retry.

	Parameters: 
		
		requestType - unimportant
		TodoRate - required, non-empty string, the rate of todo
		
	Returns: 
		{ status: "ok" ,errors: "<unimportant>"} on success
		{ status: "error" , errors: "{msg: "<error msg array>" , todorate: "<error in rate?>"}"}"} on failure
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
	$errors['todorate'] = false ;//no error

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	if(!isset($_REQUEST['data']) )
		goto leave;

	$data = json_decode($_REQUEST['data'],true);
	//$requestType = $_REQUEST["requestType"];
	$requestTodorate = $data["TodoRate"];

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	if($requestTodorate < 0 || $requestTodorate > 24 || !is_numeric($requestTodorate))
	{
		$errors['msg'][] ='Invalid todo rate. Choose number between 0 - 24';
		$errors['todorate'] = true;
		goto leave;
	}

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	$_SESSION['TodoRate'] = $requestTodorate;
	$reply['status'] ='ok';

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	print json_encode($reply);
?>
