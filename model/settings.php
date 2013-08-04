<?php
	/* 
	Add user
	@params	name			Username
	@params	password		User password
	@return	false if there is an error, true otherwise
	*/
	function addUser($name, $password){
		$password = sha1($name.$password);

		try{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
			$req = $bdd->prepare("INSERT INTO user(name, password) VALUES(:name, :password)");
			$req->execute(array(
				"name"		=>	$name,
				"password"	=>	$password
				));

			return true;
		}
		catch (Exception $e){
			return false;
		}
	}

	/* 
	Get user language
	@return	language or false if there is an error
	*/
	function getUserLang(){
		if(isConnected()){
			$IDs = getId();
			$name = $IDs[0];
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$req = $bdd->prepare("SELECT language FROM user WHERE name = :name");
				$req->execute(array("name"	=>	$name));

				if($data = $req->fetch()){$req->closeCursor();return $data["language"];}
				else{$req->closeCursor();return false;}
			}
			catch (Exception $e){
				return false;
			}
		}
		else return false;
	}

	/* 
	Set user language
	@return	false if there is an error
	*/
	function setUserLang($language){
		if(isConnected()){
			$IDs = getId();
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$query=$bdd->prepare("UPDATE user SET language =:language WHERE name =:name && password =:password");
				$query->execute(array(
					'name'		=> $IDs[0],
					'password'	=> $IDs[1],
					'language'	=> $language
				));
				return true;
			}
			catch (Exception $e){
				return false;
			}
		}
		else return false;
	}

	/* 
	Add book
	@params	id			User IDs
	@params	title		Book title
	@params	author		Book author
	@params	desc		Book desc
	@params	pages		Book pages number
	@params	img_link	Book img link
	@params	date		Book reading date
	@params	mark		Book mark
	@return	false if there is an error, true otherwise
	*/
	function addBook($id, $title, $author, $desc, $pages, $img_link, $date, $mark){
		if(isset($id) && isset($title) && isset($author) && isset($desc) && isset($pages) && isset($img_link) && isset($date) && isset($mark)){
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$req = $bdd->prepare("INSERT INTO read_list(user_id, title, author, `desc`, pages, img_link, date, mark) VALUES(:id, :title, :author, :desc, :pages, :img_link, :date, :mark)");
				$req->execute(array(
					"id"		=>	$id,
					"title"		=>	$title,
					"author"	=>	$author,
					"desc"		=>	$desc,
					"pages"		=>	$pages,
					"img_link"	=>	$img_link,
					"date"		=>	date("Y-m-d", strtotime($date)),
					"mark"		=>	$mark
					));

				return true;
			}
			catch (Exception $e){
				echo $e;
				return false;
			}
		}
		else return false;
	}

	/* 
	Update book
	@params	id			User IDs
	@params	book_id		Book id
	@params	title		Book title
	@params	author		Book author
	@params	desc		Book desc
	@params	pages		Book pages number
	@params	img_link	Book img link
	@params	date		Book reading date
	@params	mark		Book mark
	@return	false if there is an error, true otherwise
	*/
	function updateBook($id, $book_id, $title, $author, $desc, $pages, $img_link, $date, $mark){
		if(isset($id) && isset($book_id) && isset($title) && isset($author) && isset($desc) && isset($pages) && isset($img_link) && isset($date) && isset($mark)){
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$req = $bdd->prepare("UPDATE read_list SET title =:title, author =:author, `desc` =:desc, pages =:pages, img_link =:img_link, date =:date, mark =:mark WHERE user_id =:user_id && id =:id");
				$req->execute(array(
					"user_id"	=>	$id,
					"id"		=>	$book_id,
					"title"		=>	$title,
					"author"	=>	$author,
					"desc"		=>	$desc,
					"pages"		=>	$pages,
					"img_link"	=>	$img_link,
					"date"		=>	date("Y-m-d", strtotime($date)),
					"mark"		=>	$mark
					));

				return true;
			}
			catch (Exception $e){
				echo $e;
				return false;
			}
		}
		else return false;
	}
?>