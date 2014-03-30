<?php
	/* ------------------------------------------------
	 userLogout.php: 

		logout to the application if valid credentials 
		are supplied, otherwise the user is logged out.

	Parameters: 
		
		RequestType - required, non-empty string, not used in this case

	Returns: 
		{ status: "ok" } on success
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

	clearSession();
	setState("logged_out");
	$reply['status']= 'ok';
	
	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------

	print json_encode($reply);
?>