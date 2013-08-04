<?php
	mustConnected();
	require_once(ROOT_PATH.MODELE_PATH.'home.php');

	$books = getBooks();

	//Search
	$search = (isset($_POST["search"])) ? $_POST["search"]:"";
	if(!empty($search)){
		$patterns = explode(' ', $_POST["search"]); //Get all words in array
		foreach($books as $key => $book){
			$keep = false;
			foreach($patterns as $pattern){
				if(stripos(implode(' ', $book), $pattern) !== false) $keep = true; //Pattern found
			}
			if(!$keep) unset($books[$key]); //Delete case if pattern is not found
		}
	}

	echo <<<END
		<div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-8">
				<button type="button" class="btn" id="minimize"><span class="glyphicon glyphicon-align-justify"></span></button>
			</div>
 			<div class="col-lg-2">
				<form action="index.php" method="post">
					<div class="input-group">
						<input type="text" name="search" class="form-control" placeholder="Search" value="$search">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<table class="table table-hover sortable">
			<thead>
				<tr>
					<th></th>
					<th>Author</th>
					<th>Title</th>
					<th>Description</th>
					<th data-defaultsort="desc">Date</th>
					<th>Mark</th>
				</tr>
			</thead>
			<tbody>
END;
	
	if($books === false || count($books) == 0){ //No books
		echo "</tbody></table><h3 class=\"center\">No book</h3>";
	}
	else{
		foreach($books as $book){ //Get all books
			$book["date"] = date("d-m-Y", strtotime($book["date"]));
			include(ROOT_PATH.VIEW_PATH.'home.php');
		}
		echo '</tbody></table>';
	}
?>