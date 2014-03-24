<?php
// this is a simple test script that returns a count in json
	require 'config.inc';
	session_save_path("$session_save_path");
	session_start();

	header('Content-Type: application/json');

	if(!isset($_SESSION['counter']))
		$_SESSION['counter'] = 0;


	if(empty($_REQUEST['addValue']))
		$_SESSION['counter'] += 1;
	else
		$_SESSION['counter'] += $_REQUEST['addValue'];

	$reply = array();
	$reply['status']='ok';
	$reply['count']=$_SESSION["counter"];

	print json_encode($reply);
?>