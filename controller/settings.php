<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'settings.php');
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	$state = "";

	//Change user lang
	if(isset($_POST["language"])){
		if(strlen($_POST["language"]) == 2){
			setUserLang($_POST["language"]);
		}
		else{
			$state .= "<div class=\"alert alert-error\">Error: Invalid language.</div>";
		}
	}

	//Refresh books' data
	if(isset($_GET["refresh"])){
		$books = getBooks();
		$IDs = getId();
		
		foreach($books as $book){
			if($book["img_link"] == "http://books.google.fr/googlebooks/images/no_cover_thumb.gif" && empty($book["desc"])){ //No data yet
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
				sleep(10); //Avoid overloading Google API
			}
		}
	}

	//Import CSV
	if(isset($_FILES["file"])){
		if($_FILES["file"]["error"] == 0){
			//Test ext
			$infosFile = pathinfo($_FILES["file"]["name"]);
			$ext = $infosFile["extension"];
			if($ext == "CSV" || $ext == "csv"){
				ini_set('auto_detect_line_endings',TRUE);
				if(($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== false){
					//Get CSV in array
					$books = array();
					$i = 0;
					while(($data = fgetcsv($handle, 1000, ";")) !== false){
						$books[$i] = $data;
						$i++;
					}

					//Get column number of each data
					$titleKey = null;
					$authorKey = null;
					$descKey = null;
					$dateKey = null;
					$markKey = null;
					foreach($books[0] as $id => $key){
						if($key == "Title" || $key == "title") $titleKey = $id;
						if($key == "Author" || $key == "author") $authorKey = $id;
						if($key == "Desc" || $key == "desc") $descKey = $id;
						if($key == "Date" || $key == "date") $dateKey = $id;
						if($key == "Mark" || $key == "mark") $markKey = $id;
					}
					unset($books[0]);

					if($titleKey !== null && $authorKey !== null){ //Check if required data are here
						$IDs = getId();
						foreach($books as $book){
							$book["title"] = (isset($book[$titleKey])) ? utf8_encode($book[$titleKey]):"";
							$book["author"] = (isset($book[$authorKey])) ? utf8_encode($book[$authorKey]):"";

							if(!empty($book["title"]) && !empty($book["author"])){
								//Get data
								$book["desc"] = ($descKey !== null && isset($book[$descKey])) ? utf8_encode($book[$descKey]):"";
								$book["date"] = ($dateKey !== null && isset($book[$dateKey])) ? utf8_encode(date("d-m-Y", strtotime($book[$dateKey]))):"";
								$book["mark"] = ($markKey !== null && isset($book[$markKey])) ? utf8_encode($book[$markKey]):"10";
								$book["img"] = "http://books.google.fr/googlebooks/images/no_cover_thumb.gif";
								
								//Google book API request
								$req = "https://www.googleapis.com/books/v1/volumes?q=inauthor:".urlencode($book["author"])."+intitle:".urlencode($book["title"]);
								$response = file_get_contents($req);  
								$results = json_decode($response);

								if($results->totalItems > 0){
									$bookData = $results->items[0];

									$book["title"] = $bookData->volumeInfo->title;
									$book["author"] = $bookData->volumeInfo->authors[0];
									$book["desc"] = (empty($book["desc"])) ? $bookData->volumeInfo->description:$book["desc"];
									$book["pages"] = (isset($bookData->volumeInfo->pageCount)) ? $bookData->volumeInfo->pageCount:"300";

									if(isset($bookData->volumeInfo->imageLinks)){
										$book["img"] = str_replace('&edge=curl', '', $bookData->volumeInfo->imageLinks->thumbnail);
									}
								}
								else{
									$book["pages"] = "300";
								}

								addBook(getUserDBId($IDs[0]), htmlspecialchars($book["title"]), htmlspecialchars($book["author"]), nl2br(htmlspecialchars($book["desc"])), $book["pages"], $book["img"], $book["date"], $book["mark"]);
							}
						}
						$state .= "<div class=\"alert alert-success\">CSV has been imported.</div>";
					}
					else{
						$state .= "<div class=\"alert alert-error\">Error: invalid CSV file.</div>";
					}
				}
				else{
					$state .= "<div class=\"alert alert-error\">Error while reading file.</div>";
				}
			}
			else{
				$state .= "<div class=\"alert alert-error\">Error: Invalid file type.</div>";
			}
		}
		else{
			$state .= "<div class=\"alert alert-error\">Error while reading file.</div>";
		}
	}

	$lang = getUserLang();
	require_once(ROOT_PATH.VIEW_PATH.'settings.php');
?>