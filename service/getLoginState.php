<?php
	/* ------------------------------------------------
	 getloginState.php: 

		returns if the application is looged in or not

	Parameters: 
		
		RequestType - required, non-empty string, not used in this case

	Returns: 
		{ status: "ok" statte: "logged_in"/"logged_out"} on success
		{ status: "error"} of failure
	
	------------------------------------------------ */

	require 'config.inc';
	require 'Model.php';

	header('Content-Type: application/json');

	// ------------------------------------------------
	// Default reply
	// ------------------------------------------------
	$reply=array();

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------	
	$reply['status'] ='error';

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	// ------------------------------------------------
	// check Parameters
	// ------------------------------------------------

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	if (isLoggedIn())
		$reply['state'] ='logged_in';
	else 
		$reply['state'] ='logged_out';
	$reply['status']= 'ok';
	
	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------

	print json_encode($reply);
?>