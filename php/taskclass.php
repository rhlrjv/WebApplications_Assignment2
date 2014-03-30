<?php
	class task{

		var $id ;
		var $taskname;     
		var $totalhrs;		
		var $completedhrs;	
		var $imp;				
		var $username;			
		

		function getNextId ($dbconn)
		{
			if($dbconn != '')
			{
				$largestId_query="SELECT MAX(id) FROM task;";
				$result = pg_query($dbconn, $largestId_query);
				if($result)
				{
					$row = pg_fetch_row($result);
					$maxId = $row[0] +1;
					return ($maxId); 
				}
				else 
					return 1;
			}
		}
		
		function checkIdExists ($dbconn, $argId, $argUsername)
		{
			if($dbconn != '')
			{
				$checkIdExists_query="SELECT * FROM task WHERE id = $1 AND username = $2;";
				$result = pg_prepare($dbconn, "checkId_query", $checkIdExists_query);
				$result = pg_execute($dbconn, "checkId_query", array($argId, $argUsername));
				if(pg_num_rows($result))
					return true; 
				else
					return false;
			}
		}
		
		//Add a new to do
		function addtodo($dbconn, $argTaskname, $argTotalHrs, $argCompletedhrs, $argImp, $argUsername)
		{
			if(($dbconn)  != '')
			{
				$argId = $this->getNextId($dbconn);
				$addtodo_query="INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) values($1, $2, $3, $4, $5, $6);";
				$result = pg_prepare($dbconn, "add_query", $addtodo_query);
				$result = pg_execute($dbconn, "add_query", array($argId, $argTaskname, $argTotalHrs, $argCompletedhrs, $argImp, $argUsername));
				if($result)
					return true; 
				else
					return false;
			}
		}
		
		//Delete any existing to do 
		function deletetodo($dbconn, $argId)
		{
			if(($dbconn)  != '')
			{
				$deletetodo_query="DELETE FROM task WHERE id = $1;";
				$result = pg_prepare($dbconn, "delete_query", $deletetodo_query);
				$result = pg_execute($dbconn, "delete_query", array($argId));
				if($result)
					return true; 
				else
					return false;
			}
		}
		
		//Edit to do
		function edittodo($dbconn, $argId, $argTaskname, $argTotalHrs, $argCompletedhrs, $argImp, $argUsername)
		{
			if($dbconn != '')
			{
				$edittodo_query="UPDATE task SET taskname = $1, totalhrs = $2, completedhrs = $3, important = $4 WHERE id = $5 AND username = $6;";
				$result = pg_prepare($dbconn, "edit_query", $edittodo_query);
				$result = pg_execute($dbconn, "edit_query", array($argTaskname, $argTotalHrs, $argCompletedhrs, $argImp, $argId, $argUsername));
				if($result)
				{
					$this->taskname = $argTaskname;     
					$this->totalhrs = $argTotalHrs;		
					$this->completedhrs = $argCompletedhrs;	
					$this->imp = $argImp;				
					return true;
				} 
				else
					return false;
			}
		}
		
		//Decrement completed hours of a to do 
		function decrementCompletedHrs($dbconn, $argId)
		{
			if(($dbconn)  != '')
			{
				$decrementCompletedHrs_query="UPDATE task SET completedhrs = completedhrs - 1 WHERE id = $1;";
				$result = pg_prepare($dbconn, "decrement_query", $decrementCompletedHrs_query);
				$result = pg_execute($dbconn, "decrement_query", array($argId));
				if($result)
					return true; 
				else
					return false;
			}
		}
		
		//Increment completed hours of a to do 
		function incrementCompletedHrs($dbconn, $argId)
		{
			if(($dbconn)  != '')
			{
				$incrementCompletedHrs_query="UPDATE task SET completedhrs = completedhrs + 1 WHERE id = $1;";
				$result = pg_prepare($dbconn, "increment_query", $incrementCompletedHrs_query);
				$result = pg_execute($dbconn, "increment_query", array($argId));
				if($result)
					return true; 
				else
					return false;
			}
		}
		
		//View all to do on the TODO Page
		function viewAlltodo($dbconn, $argUsername)
		{
			if(($dbconn)  != '')
			{
				
				$viewAlltodo_query="SELECT * FROM task WHERE username = $1 ORDER BY important ASC, id DESC;";
				$result = pg_prepare($dbconn, "viewAll_query", $viewAlltodo_query);
				$result = pg_execute($dbconn, "viewAll_query", array($argUsername));
				if($result)
				{
					$rowcnt = pg_num_rows($result);
					$viewTaskObjects = array("");
					while($row = pg_fetch_row($result)) 
					{
						$viewTaskObj = new task();
						$viewTaskObj->id = $row[0];
						$viewTaskObj->taskname = $row[1];
						$viewTaskObj->totalhrs = $row[2];
						$viewTaskObj->completedhrs = $row[3];
						
						if ($row[4] == 't')
							$viewTaskObj->imp = 1;
						else
							$viewTaskObj->imp = 0;
						
						array_push($viewTaskObjects, $viewTaskObj);
					}
						
					return $viewTaskObjects;
					
				}
				/*else
				{
					return false;
				}*/
			}
		}
		
		function getId()
		{
			return $this->id;
		}
		
		function setId($argId)
		{
			$this->id = $argId;
		}
		
		function getTaskname()
		{
			return $this->taskname;
		}
		
		function setTaskname($argTaskname)
		{
			$this->taskname = $argTaskname;
		}
		
		function getTotalHrs()
		{
			return $this->totalhrs;
		}
		
		function setTotalHrs($argTotalHrs)
		{
			$this->totalhrs = $argTotalHrs;
		}
		
		function getCompletedHrs()
		{
			return $this->completedhrs;
		}
		
		function setCompletedHrs($argCompletedHrs)
		{
			$this->completedhrs = $argCompletedHrs;
		}
		
		function getImp()
		{
			return (bool)$this->imp;
		}
		
		function setImp($argImp)
		{
			$this->imp = $argImp;
		}
		
	}

?>