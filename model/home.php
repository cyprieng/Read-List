<?php
	/* 
	Get user books
	@params id		id of the book (optionnal)	
	@return	array of books
	*/
	function getBooks($id = null){
		if(isConnected()){
			$IDs = getId();
			$user_id = getUserDBId($IDs[0]);
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				
				if($id != null && !is_nan($id)){ //Specific book
					$req = $bdd->prepare("SELECT * FROM read_list WHERE user_id = :user_id AND id = :id");
					$req->execute(array(
						"user_id" =>	$user_id,
						"id" => 		$id));

					if($data = $req->fetch()){$req->closeCursor();return $data;}
					else{$req->closeCursor();return false;}
				}
				else{ //All books
					$req = $bdd->prepare("SELECT * FROM read_list WHERE user_id = :user_id");
					$req->execute(array("user_id" =>	$user_id));
				}

				//Create array
				$i = 0;
				$data = array();
				while ($temp = $req->fetch()){
					$data[$i] = $temp;
					$i++;
				}
				
				$req->closeCursor();
				return $data;
			}
			catch (Exception $e){
				return false;
			}
		}
		else return false;
	}

	/* 
	Delete a book
	@params id		id of the book
	@return	true if it is ok
	*/
	function delBook($id){
		if(isConnected()){
			$IDs = getId();
			$user_id = getUserDBId($IDs[0]);
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD, $pdo_options);
				$req = $bdd->prepare("DELETE FROM read_list WHERE user_id = :user_id AND id = :id");
				$req->execute(array(
					"user_id" =>	$user_id,
					"id" => 		$id));

				return true;
			}
			catch (Exception $e){
				return false;
			}
		}
		else return false;
	}
?>