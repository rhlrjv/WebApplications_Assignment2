<?php
	class user{
		
		var $username;
		var $password;
		var $email;
		var $dob;
		
		//Hash generated of the string provided
		// HASH FUNCTION USED: Blowfish algorithm
		// SALT USED: Randomly generated or each password
		function generateHash($password)
		{
			if(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
			{
				$salt = '$2y$11$'.substr(md5(uniqid(rand(), true)), 0, 22);
				$hashedPassword = crypt($password, $salt);
				return $hashedPassword;
			}

		}

		//Get user info when username is provided
		function getUserObj ($dbconn, $argUsername)
		{
			$username_query="SELECT * FROM users where username = $1;";
			$result = pg_prepare($dbconn, "user_query", $username_query);
			$result = pg_execute($dbconn, "user_query", array($argUsername));
			if($result)
			{
				$rows = pg_num_rows($result); 
				if($rows)
				{
					$row = pg_fetch_row($result);
					

					$this->username = $row[0];
					$this->password = $row[1];
					$this->email = $row[2];
					$this->dob = $row[3];
					
					return $this;
				}
				else
					return false;
			}
		}
		
		//Checking if given username already exists in the user table
		function duplicateUsername ($dbconn, $argUsername)
		{
			$duplicate_username_query="SELECT * FROM users where username = $1;";
			$result = pg_prepare($dbconn, "my_query", $duplicate_username_query);
			$result = pg_execute($dbconn, "my_query", array($argUsername));
			
			if($result)
			{
				$rows = pg_num_rows($result);
				if($rows)
					return true;
				else
					return false;
			}
		}
		//Sign up as new user
		function signup($dbconn, $argUsername, $argPassword, $argEmail, $argDob)
		{
			if($dbconn != '')
			{
				$hashedPassword = $this->generateHash($argPassword);
				
				$signup_query="INSERT INTO users (username, pwd, email, dob) values($1, $2, $3, $4);";
				$result = pg_prepare($dbconn, "newuser_query", $signup_query);
				$result = pg_execute($dbconn, "newuser_query", array($argUsername, $hashedPassword, $argEmail, $argDob));
				if($result)
					return true; 
				else
					return false;
			}
		}
		
		//Update user profile
		function updateProfile($dbconn, $argUsername, $argPassword, $argEmail, $argDob)
		{
			if($dbconn != '')
			{
				$hashedPassword = $this->generateHash($argPassword);
				$update_query="UPDATE users SET pwd = $1, email = $2, dob = $3 WHERE username = $4;";
				$result = pg_prepare($dbconn, "updateProfile_query", $update_query);
				$result = pg_execute($dbconn, "updateProfile_query", array($hashedPassword, $argEmail, $argDob, $argUsername));
				if($result)
				{
						$this->username = $argUsername;
						$this->password = $argPassword;
						$this->email = $argEmail;
						$this->dob = $argDob;
						return true;
					} 
				else
					return false;
			}
		}
		
		//Login to app
		function login($dbconn, $argUsername, $argPassword)
		{
			if($dbconn != '')
			{
				$login_query="SELECT * FROM users WHERE username = $1;";
				$result = pg_prepare($dbconn, "my_query", $login_query);
				$result = pg_execute($dbconn, "my_query", array($argUsername));				
				if($result)
				{
					$rows = pg_num_rows($result); 
					if($rows)
					{
						$rowContent = pg_fetch_row($result);
						if(crypt($argPassword, $rowContent[1]) == $rowContent[1])
						{
							$this->username = $rowContent[0];
							$this->password = $rowContent[1];
							$this->email = $rowContent[2];
							$this->dob = $rowContent[3];
							return true;
						}
					}
					else
						return false;
				}
			}
		}
		
		function logout(){
			$_SESSION['isloggedin'] = "";
		}
		
		/* Get and set function for member variables*/
		function getUsername()
		{
			return $this->username;
		}
		
		function setUsername($argUsername)
		{
			$this->username = $argUsername;
		}
		
		function getPassword()
		{
			return $this->password;
		}
		
		function setPassword($argPassword)
		{
			$this->password = $argPassword;
		}
		
		function getEmail()
		{
			return $this->email;
		}
		
		function setEmail($argEmail)
		{
			$this->email = $argEmail;
		}
		
		function getDob()
		{
			return $this->dob;
		}
		
		function setDob($argDob)
		{
			$this->dob = $argDob;
		}
		/* end: Get and set function for member variables*/
		
	}

?>