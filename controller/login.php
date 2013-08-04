<?php
	$state_login = "";
	$state_register = "";

	//LOGIN
	if(isset($_GET["action"]) && $_GET["action"] == "login"){
		if(isset($_POST["name"]) && isset($_POST["password"])){
			$connect = testLogin($_POST["name"], sha1($_POST["name"].$_POST["password"]));
			if($connect){
				//Connected => redirection
				logIn($_POST['name'], $_POST['password']);
				header('Location: index.php');
			}
			else{ 
				//Error
				$state_login .= "<div class=\"alert alert-error\">Bad combination login / password</div>";
			}
		}
	}
	//REGISTER
	else if(isset($_GET["action"]) && $_GET["action"] == "register"){
		require_once(ROOT_PATH.MODELE_PATH.'settings.php');
		if(preg_match("/^[a-z0-9_-]{3,16}$/", $_POST["name"])){
			$name = $_POST["name"];
			if(preg_match("/^[a-z0-9_-]{6,255}$/", $_POST["password"])){
				$password = $_POST["password"];

				if(!userAlreadyExists($name)){
					$addUser = addUser($name, $password);
					if($addUser){ //Login
						logIn($name, $password);
						header('Location: index.php');
					}
					else{
						$state_register .= "<div class=\"alert alert-error\">Error while processing. Please try again later.</div>";
					}
				}
				else{
					$state_register .= "<div class=\"alert alert-error\">User already exists.</div>";
				}
			}
			else{
				$state_register .= "<div class=\"alert alert-error\">Error: Your password must contain only letters, numbers and '_', '-', with at least six characters.</div>";
			}
		}
		else{
			$state_register .= "<div class=\"alert alert-error\">Error: Your username can only contain letters, numbers and '_', '-', with 3 to 16 characters.</div>";
		}
	}

	if(isset($_GET['logoff'])){
		//Log off
		logOff();
		header('Location: index.php?p=login');
	}

	//Include the view
	require_once(ROOT_PATH.VIEW_PATH."login.php");
?>