<?php
// this is a simple test script that can be used as reference 
// while working with json data transfer
	require 'config.inc';
	session_save_path("$session_save_path");
	session_start();

	header('Content-Type: application/json');

	if(!isset($_SESSION['counter']))
		$_SESSION['counter'] = 0;

	$data = json_decode($_REQUEST['data'],true);

	$reply = array();
	$reply['status']='ok';
	$reply['request']= $_REQUEST["requestType"];
	$reply['username']= $data["UserName"];
	$reply['password']= $data["Password"];

	print json_encode($reply);
?>