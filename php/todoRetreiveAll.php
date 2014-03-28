<?php
	/* ------------------------------------------------
	 todoRetrieveAll.php: 

		Retrieve all the todos for the user logged in
	Parameters: 
	Returns: 
		{status: "ok", todos: "{todoID: "<unique value>", todoName: "<name of the task>", completedHrs: "<# of hours completed>", totalHrs: "<total hours for completion>", important: "<if task is imp, true>"}"}  on success

	------------------------------------------------ */
	require 'config.inc';
	require 'Model.php';
	
	header('Content-Type: application/json');

	// ------------------------------------------------
	// Default reply
	// ------------------------------------------------
	$reply = array();
	$todos = array(); 
	$todo = array();

	// ------------------------------------------------
	// Default resulting state
	// ------------------------------------------------
	$reply['status'] ='ok';

	$todo['todoID'] = "" ;//no value
	$todo['todoName'] = "" ;//no value
	$todo['completedHrs'] = "" ;//no value
	$todo['totalHrs'] = "" ;//no value
	$todo['important'] = "" ;//no value

	// ------------------------------------------------
	// retreive assessed data
	// ------------------------------------------------

	$requestUsername = $_SESSION['Username'];

	// ------------------------------------------------
	// Check parameters
	// ------------------------------------------------


	// ------------------------------------------------
	// Perform operation 
	// ------------------------------------------------

	// Check the database...SELECT FROM ... $1 ... $2
	$viewTaskObjects = $GLOBALS['taskobj']->viewAlltodo($_SESSION['dbconn'], $_SESSION['Username']);
	$n = count($viewTaskObjects)-1;
	
	$viewTaskObj = new task();
	for($i=0; $i<$n; $i++)
	{
		$viewTaskObj = array_pop($viewTaskObjects);
		
		$todo['todoID'] = $viewTaskObj->getId();
		$todo['todoName']= $viewTaskObj->getTaskname();
		$todo['completedHrs'] = $viewTaskObj->getCompletedHrs();
		$todo['totalHrs'] = $viewTaskObj->getTotalHrs();
		$todo['important'] = $viewTaskObj->getImp();

		$todos[] = $todo;
	}

	// ------------------------------------------------
	// Send reply 
	// ------------------------------------------------
	leave:
	$reply['todos'] = $todos;
	print json_encode($reply);
?>
