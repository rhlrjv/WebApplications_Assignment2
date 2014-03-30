<?php
	/* ------------------------------------------------
	 todoUpdateRate.php: 

		update rate of todo with an id which is unique
		for a specific username,
		otherwise the user is requested to refill/retry.

	Parameters: 
		
	Returns: 
		{ status: "ok" ,rate: "<rate>"} on success
		{ status: "error" } on failure
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

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------
	$reply['status'] ='error';
	$reply['rate'] = 0;

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------


	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	$reply['rate'] = $_SESSION['TodoRate'];
	$reply['status'] ='ok';

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	print json_encode($reply);
?>
