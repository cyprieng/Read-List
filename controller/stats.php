<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	$books = getBooks();

	//Total books number
	$booksNumber = count($books);

	//Init var
	$pagesNumber = 0;
	$count = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	$monthList = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jui", "Aug", "Sep", "Oct", "Nov", "Dec");
	$countYear = array();

	foreach($books as $book){
		$pagesNumber += $book["pages"]; //Number of pages

		date_default_timezone_set('UTC');
		if(strtotime($book["date"]) != 0){ //If date is not default value
			$count[date("m", strtotime($book["date"])) -1]++; //Increase month books number

			//Increase year books number
			if(!isset($countYear[date("Y", strtotime($book["date"]))])) $countYear[date("Y", strtotime($book["date"]))] = 0;
			$countYear[date("Y", strtotime($book["date"]))]++;
		}
	}

	//Total time reading
	$time = 2*$pagesNumber; //2min per page
	$date = "";
	if(floor($time / (60*24*365)) != 0){$year = floor($time / (60*24*365)); $date .=  $year."y "; $time -= $year * (60*24*365);}
	if(floor($time / (60*24*30)) != 0){$month = floor($time / (60*24*30)); $date .=  $month."m "; $time -= $month * (60*24*30);}
	if(floor($time / (60*24)) != 0){$day = floor($time / (60*24)); $date .=  $day."d "; $time -= $day * (60*24);}
	if(floor($time / (60)) != 0){$hour = floor($time / (60)); $date .=  $hour."h "; $time -= $hour * (60);}
	if($time != 0){$date .=  $time."m ";}

	require_once(ROOT_PATH.VIEW_PATH.'stats.php');
?>