<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'settings.php');
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	//Get all data from form
	$state = "";
	$showall = false; //Show all the field
	$author = (isset($_POST["author"])) ? $_POST["author"]:"";
	$title = (isset($_POST["title"])) ? $_POST["title"]:"";
	$data["desc"] = (isset($_POST["desc"])) ? $_POST["desc"]:"";
	$data["img"] = (isset($_POST["img"])) ? $_POST["img"]:"";
	$data["pages"] = (isset($_POST["pages"])) ? $_POST["pages"]:"300";
	$date = (isset($_POST["date"])) ? $_POST["date"]:date("d-m-Y");
	$mark = (isset($_POST["mark"])) ? $_POST["mark"]:"";

	if(isset($_GET["id"]) && !is_nan($_GET["id"])){ //Modify
		$book = getBooks($_GET["id"]);

		if($book !== false){ //Book exists
			$showall = true;
			$author = $book["author"];
			$title = $book["title"];
			$data["desc"] = $book["desc"];
			$data["img"] = $book["img_link"];
			$data["pages"] = $book["pages"];
			$date = date("d-m-Y", strtotime($book["date"]));
			$mark = $book["mark"];
		}
	}

	//Add or modify a book
	if(isset($_POST["date"]) && isset($_POST["mark"]) && isset($_POST["img"]) && isset($_POST["desc"]) && isset($_POST["author"]) && isset($_POST["title"]) && isset($_POST["pages"])){
		$showall = true;
		if($_POST["date"] == date("d-m-Y", strtotime($_POST["date"]))){ //Test date
			if(!is_nan($_POST["mark"])){
				if(!is_nan($_POST["pages"])){
					$IDs = getId();
					
					if(isset($_GET["id"]) && !is_nan($_GET["id"])){
						$add = updateBook(getUserDBId($IDs[0]), $_GET["id"], htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["author"]), nl2br(htmlspecialchars($_POST["desc"])), $_POST["pages"], $_POST["img"], $_POST["date"], $_POST["mark"]);
					}
					else{
						$add = addBook(getUserDBId($IDs[0]), htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["author"]), nl2br(htmlspecialchars($_POST["desc"])), $_POST["pages"], $_POST["img"], $_POST["date"], $_POST["mark"]);
					}
					if($add){
						header('Location: index.php');
					}
					else{
						$state .= "<div class=\"alert alert-error\">Error while processing. Please try again later.</div>";
					}
				}
				else{
					$state .= "<div class=\"alert alert-error\">Error: Pages number invalid.</div>";
				}
			}
			else{
				$state .= "<div class=\"alert alert-error\">Error: Mark invalid.</div>";
			}
		}
		else{
			$state .= "<div class=\"alert alert-error\">Error: Date invalid.</div>";
		}
	}
	else if(isset($_POST["author"]) && isset($_POST["title"])){ //Search book
		$showall = true;

		//Google book API request
		$req = "https://www.googleapis.com/books/v1/volumes?q=inauthor:".urlencode($_POST["author"])."+intitle:".urlencode($_POST["title"]);
		$response = file_get_contents($req);  
		$results = json_decode($response);

		if($results->totalItems > 0){
			$book = $results->items[0];

			$data["title"] = $book->volumeInfo->title;
			$data["author"] = $book->volumeInfo->authors[0];
			$data["desc"] = $book->volumeInfo->description;
			$data["pages"] = (isset($book->volumeInfo->pageCount)) ? $book->volumeInfo->pageCount:"300";

			if(isset($book->volumeInfo->imageLinks)){
				$data["img"] = str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail);
			}
			else $data["img"] = "http://books.google.fr/googlebooks/images/no_cover_thumb.gif";
		}
		else{
			$state .= "<div class=\"alert alert-error\">Error: Book not found.</div>";
			$data["img"] = "http://books.google.fr/googlebooks/images/no_cover_thumb.gif";
			$data["desc"] = "";
		}
	}

	require_once(ROOT_PATH.VIEW_PATH.'add.php');
?>