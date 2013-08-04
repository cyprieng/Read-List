<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	$state = "";

	if(isset($_GET["del"]) && !is_nan($_GET["del"])){ //Delete book
		$state = delBook($_GET["del"]);
		if($state) header('Location: index.php');
		else $state = "<div class=\"alert alert-error\">Error while processing. Please try again later.</div>";
	}

	if(isset($_GET["id"]) && !is_nan($_GET["id"])){ //Get book details
		$book = getBooks($_GET["id"]);
		$book["date"] = date("d-m-Y", strtotime($book["date"]));
	}

	require_once(ROOT_PATH.VIEW_PATH.'detail.php');
?>