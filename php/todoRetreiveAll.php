<?php
	/* ------------------------------------------------
	 login.php: 

		login to the application if valid credentials 
		are supplied, otherwise the user is logged out.

		$_SESSION['is_logged_in']=="true" on success
		$_SESSION['is_logged_in']=="false" on failure

	Parameters: 

		username - required, non-empty string, the users user name
		password - required, non-empty string, the users password

	Returns: 
		{ status: "ok" } on success
		{ status: "<error messages>" } on failure
	
	------------------------------------------------ */

	session_save_path("sess");
	session_start(); 
	header('Content-Type: application/json');

	// ------------------------------------------------
	// Default reply
	// ------------------------------------------------
	$reply=array();
	$reply['status']='ok';

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------
	$_SESSION["is_logged_in"]="false";

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------
	if(empty($_REQUEST['user'])){
		$reply['status']='user must be supplied';
	}
	if(empty($_REQUEST['password'])){
		// Below is conceptually wrong! You should not return HTML.
		// These scripts should only return data. It is not concerned
		// with user interface.
		$reply['status'] = $reply['status'] . '<br/> password must be supplied';
	}

	if($reply['status']!='ok'){
		goto leave;
	}

	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	if($_REQUEST['user']!="arnold" || $_REQUEST['password']!="spiderman"){
		$reply['status']="invalid login";
		$_SESSION["is_logged_in"]="true";
		goto leave;
	} else {
		$_SESSION["is_logged_in"]="true";
	}

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	print json_encode($reply);
?>
