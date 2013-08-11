<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'settings.php');
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	$state = "";

	if(isset($_GET["del"]) && !is_nan($_GET["del"])){ //Delete book
		$state = delBook($_GET["del"]);
		if($state) header('Location: index.php');
		else $state = "<div class=\"alert alert-error\">Error while processing. Please try again later.</div>";
	}
	else if(isset($_GET["update"]) && isset($_GET["id"]) && !is_nan($_GET["id"])){ //Update book data
		$IDs = getId();
		$book = getBooks($_GET["id"]);
		$book["date"] = date("d-m-Y", strtotime($book["date"]));
				
		//Google book API request
		$req = "https://www.googleapis.com/books/v1/volumes?q=inauthor:".urlencode($book["author"])."+intitle:".urlencode($book["title"]);
		$response = file_get_contents($req);  
		$results = json_decode($response);

		if($results->totalItems > 0){
			$bookData = $results->items[0];

			$book["title"] = $bookData->volumeInfo->title;
			$book["author"] = $bookData->volumeInfo->authors[0];
			$book["desc"] = (empty($book["desc"]) && isset($bookData->volumeInfo->description)) ? $bookData->volumeInfo->description:$book["desc"];
			$book["pages"] = (isset($bookData->volumeInfo->pageCount)) ? $bookData->volumeInfo->pageCount:"300";

			if(isset($bookData->volumeInfo->imageLinks)){
				$book["img"] = str_replace('&edge=curl', '', $bookData->volumeInfo->imageLinks->thumbnail);
			}
			else $book["img"] = "http://books.google.fr/googlebooks/images/no_cover_thumb.gif";

			updateBook(getUserDBId($IDs[0]), $book["id"], htmlspecialchars($book["title"]), htmlspecialchars($book["author"]), nl2br(htmlspecialchars($book["desc"])), $book["pages"], $book["img"], $book["date"], $book["mark"]);
		}
	}

	if(isset($_GET["id"]) && !is_nan($_GET["id"])){ //Get book details
		$book = getBooks($_GET["id"]);
		$book["date"] = date("d-m-Y", strtotime($book["date"]));

		//Google book API request
		$req = "https://www.googleapis.com/books/v1/volumes?q=inauthor:".urlencode($book["author"])."+intitle:".urlencode($book["title"]);
		$response = file_get_contents($req);  
		$results = json_decode($response);

		if($results->totalItems > 0){
			$bookData = $results->items[0];
			$book["google"] = $bookData->volumeInfo->infoLink;
		}
	}

	require_once(ROOT_PATH.VIEW_PATH.'detail.php');
?>