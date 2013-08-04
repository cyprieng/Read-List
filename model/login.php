<?php
	/* 
	Test login
	@params	login	User name
	@params	pass	User password hash
	@return	true if IDs are ok
	*/
	function testLogin($login, $pass){
		if(isset($login) && isset($pass)){
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
			$query=$bdd->prepare("SELECT COUNT(*) AS nbr FROM user WHERE name =:name && password =:password");
			$query->execute(array(
				"name" => $login,
				"password" => $pass
			));
			$connect=($query->fetchColumn()==0)?0:1;
			$query->CloseCursor();	

			if($connect){return true;}
			else{return false;}
		}
		else{return false;}
	}

	/* 
	Test if user already exists in DB
	@params	login	User name
	@return	true if he already exists
	*/
	function userAlreadyExists($login){
		if(isset($login)){
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
			$query=$bdd->prepare("SELECT COUNT(*) AS nbr FROM user WHERE name =:name");
			$query->execute(array("name" => $login));

			$alreadyExists=($query->fetchColumn()==0)?0:1;
			$query->CloseCursor();	

			if($alreadyExists){return true;}
			else{return false;}
		}
		else{return false;}
	}

	/* 
	Log in the user creating cookies and session variables
	@params	login	User name
	@params	pass	User password
	*/
	function logIn($login, $pass){
		$_SESSION["name"] = $login;
		$_SESSION["pass"] = sha1($login.$pass);

		setcookie("name", $login, time() + 365*24*3600, null, null, false, true);
		setcookie("pass", sha1($login.$pass), time() + 365*24*3600, null, null, false, true);
	}

	/* 
	Log off the user by deleting the cookies and session variables
	*/
	function logOff(){
		session_destroy();

		setCookie("name", "", (time() - 3600));
		setCookie("pass", "", (time() - 3600));
	}

	/* 
	Test if the user is logged
	@return	true if connected
	*/
	function isConnected(){
		static $connected = null; //Static variable to avoid running several SQL queries
		if($connected == null){
			$id = getId();
			if(is_array($id)){ //check Ids
				$connected = testLogin($id[0], $id[1]); //check Ids
				return $connected;
			}
			else{
				$connected = false;
				return false;
			}
		}
		else{
			return $connected;
		}
	}

	/* 
	Forward the user to the login page if it is not
	*/
	function mustConnected(){
		if(!isConnected()){
			header('Location: index.php?p=login');
		}
	}

	/* 
	Retrieves IDs of the current user based on cookies and session
	@return	array(login, hash pass) or false if there is an error
	*/
	function getId(){
		if(isset($_SESSION["name"]) && isset($_SESSION["pass"])){
			return array($_SESSION["name"], $_SESSION["pass"]);
		}
		else if(isset($_COOKIE["name"]) && isset($_COOKIE["pass"])){
			$_SESSION["name"] = $_COOKIE["name"];
			$_SESSION["pass"] = $_COOKIE["pass"];
			return array($_COOKIE["name"], $_COOKIE["pass"]);
		}
		else{
			return false;
		}
	}

	/* 
	Retrieves id of the current user
	@params name	Username
	@return	id or false if there is an error
	*/
	function getUserDBId($name){
		if(isConnected()){
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$req = $bdd->prepare("SELECT id FROM user WHERE name = :name");
				$req->execute(array("name"	=>	$name));

				if($data = $req->fetch()){$req->closeCursor();return $data["id"];}
				else{$req->closeCursor();return false;}
			}
			catch (Exception $e){
				return false;
			}	
		}
		else return false;
	}
?>