<?php
	header('Content-Type: application/json');
	$reply = array();
	$reply['status'] ='ok';
	$reply['state'] ='logged_in';
	// $reply['state'] ='logged_out';
	print json_encode($reply);
?>