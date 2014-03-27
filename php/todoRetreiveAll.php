<?php
	header('Content-Type: application/json');
	$reply = array();
	$todos = array(); 
	$todo = array();

	$reply['status'] ='ok';

	for($i = 0;$i<10;$i++) {
		$todo['todoName'] = "Todo Name $i";
		$todo['completedHrs'] = rand(0,5);
		$todo['totalHrs'] = $todo['completedHrs'] + rand(0,5);
		if (rand(0,2) == 0)
			$todo['important'] = true;
		else
			$todo['important'] = false;
		$todos[]=$todo;
	}
	
	$reply['todos'] = $todos;
	print json_encode($reply);
?>
