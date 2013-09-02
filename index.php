<?php
	ob_start();
	require_once("global/init.php");

	if(is_file("install.php")){header("Location: install.php");} //File exists => installation

	require_once(ROOT_PATH.MODELE_PATH.'login.php');
	
	//Get controller if it exists
	if (!empty($_GET["p"]) && is_file(CONTROLLER_PATH.$_GET["p"].".php")){
		$p = $_GET["p"]; //Get shown page
		require_once(GLOBAL_PATH."header.php");
		require_once(CONTROLLER_PATH.$_GET["p"].".php");
	}
	else{
		$p = ""; //Get shown page
		require_once(GLOBAL_PATH."header.php");
		require_once(CONTROLLER_PATH."home.php");
	}

	require_once(GLOBAL_PATH."footer.php");
	ob_end_flush();
?>