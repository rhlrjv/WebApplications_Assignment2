<?php
	/* ------------------------------------------------
	 userRead.php: 

		read user data of the current user for
		displaying in the profile page.

	Parameters: 

		username - required, non-empty string, the users user name
		password - required, non-empty string, the users password
		email - required, non-empty string, the users email
		dob - required, non-empty string, the users date of birth

	Returns: 
		{ status: "ok" ,errors: "{msg: "<error msg array>"}", userinfo: "{username: "<username from db>" , password: "<password from db>" , email: "<email from db>" , dob: "<dob from db>"}"}} on success
		
		

	------------------------------------------------ */

	require 'config.inc';
	require 'Model.php';
	
	header('Content-Type: application/json');

	// ------------------------------------------------
	// Default reply
	// ------------------------------------------------
	$reply=array();
	$errors = array();
	$userinfo = array();

	$currentUserObj = new user();

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------
	$reply['status'] ='error';

	$errors['msg'] = array();

	$userinfo['username'] = "" ;
	$userinfo['password'] = "" ;
	$userinfo['email'] = "" ;
	$userinfo['dob'] = "" ;

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	//if(!isset($_REQUEST['requestType']) )
		//goto leave;

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	$currentUserObj = $GLOBALS['userobj']->getUserObj ($_SESSION['dbconn'], $_SESSION['Username']);
	if($currentUserObj != false)
	{
		$reply['status'] ='ok';
		$userinfo['username'] = $currentUserObj->getUsername(); ;
		$userinfo['password'] = $currentUserObj->getPassword() ;
		$userinfo['email'] = $currentUserObj->getEmail() ;
		$userinfo['dob'] = $currentUserObj->getDob() ; 
	}
	else 
	{
		$errors['msg'][] ='Database error';
	}
	

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['errors'] = $errors;
	$reply['userinfo'] = $userinfo;
	print json_encode($reply);
?>
