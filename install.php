<?php
	include 'global/init.php';
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Read List</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo CSS_PATH; ?>bootstrap.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>customBootstrap.css" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_PATH; ?>favicon.png" />
	</head>
	<body>
    
		<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav">
			<div class="container">
				<a href="index.php" class="navbar-brand">Read List</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="nav-collapse collapse bs-navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="index.php">Setup</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			<h3>Installation</h3>
			
			<?php
				if(isset($_POST["name"]) && isset($_POST["password"]) && !empty($_POST["serverSQL"]) && !empty($_POST["userSQL"]) && isset($_POST["passwordSQL"]) && !empty($_POST["baseSQL"])){
					try{
						ini_set("display_errors", 0); //Hide SQL warning
						$bdd = new PDO("mysql:host=".$_POST["serverSQL"].";dbname=".$_POST["baseSQL"]."", $_POST["userSQL"], $_POST["passwordSQL"]);

						$rootPath = dirname(__FILE__).DIRECTORY_SEPARATOR; //PHP directory
						$htmlPath = mb_substr($_SERVER["REQUEST_URI"],0,-mb_strlen(strrchr($_SERVER["REQUEST_URI"],"/"))).DIRECTORY_SEPARATOR; //HTML directory

						if(preg_match("/^[a-z0-9_-]{3,16}$/", $_POST["name"])){
							$name = $_POST["name"];
							if(preg_match("/^[a-z0-9_-]{6,255}$/", $_POST["password"])){
								$password = $_POST["password"];
								$password = sha1($name.$password);

								$bdd->exec("CREATE TABLE user (id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(16) NOT NULL, password VARCHAR(255) NOT NULL, language VARCHAR(2) NOT NULL DEFAULT 'en', admin BOOLEAN NOT NULL DEFAULT '0', PRIMARY KEY (id))ENGINE=INNODB;");
								$bdd->exec("CREATE TABLE read_list (id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, user_id SMALLINT UNSIGNED NOT NULL, title TEXT NOT NULL, author VARCHAR(255) NOT NULL, `desc` TEXT NOT NULL, pages INT(5) NOT NULL DEFAULT '300', img_link TEXT NOT NULL, date DATE NOT NULL, mark INT(2) NOT NULL, PRIMARY KEY (id))ENGINE=INNODB;");

								$req = $bdd->prepare("INSERT INTO user(name, password, admin) VALUES(:name, :password, '1')");
								$req->execute(array(
									"name"		=>	$name,
									"password"	=>	$password
									));

								//Create config
								$configFile = fopen(GLOBAL_PATH."config.php", "a");

								ftruncate($configFile,0);
								fputs($configFile, "<?php\n");
								fputs($configFile, "	define(\"ROOT_PATH\", 		\"".preg_replace('/\\\\/', '/', $rootPath)."\");\n");
								fputs($configFile, "	define(\"ROOT_PATH_HTML\",	\"".preg_replace('/\\\\/', '/', $htmlPath)."\");\n");
								fputs($configFile, "\n");
								fputs($configFile, "	//DB IDs\n");
								fputs($configFile, "	define(\"SQL_DSN\",			\"mysql:dbname=".$_POST['baseSQL'].";host=".$_POST['serverSQL']."\");\n");
								fputs($configFile, "	define(\"SQL_USERNAME\",	\"".$_POST['userSQL']."\");\n");
								fputs($configFile, "	define(\"SQL_PASSWORD\",	\"".$_POST['passwordSQL']."\");\n");
								fputs($configFile, "\n");
								fputs($configFile, "	//Directories\n");
								fputs($configFile, "	define(\"MODELE_PATH\",		\"model/\");\n");
								fputs($configFile, "	define(\"CONTROLLER_PATH\",	\"controller/\");\n");
								fputs($configFile, "	define(\"VIEW_PATH\",		\"view/\");\n");
								fputs($configFile, "	define(\"GLOBAL_PATH\",		\"global/\");\n");
								fputs($configFile, "	define(\"IMAGE_PATH\",		\"assets/img/\");\n");
								fputs($configFile, "	define(\"CSS_PATH\",		\"assets/css/\");\n");
								fputs($configFile, "	define(\"JS_PATH\",			\"assets/js/\");\n");
								fputs($configFile, "?>");

								fclose($configFile);


								die("<div class=\"alert alert-success\">The installation was successful. You can delete the file install.php</div>");
							}
							else{
								echo "<div class=\"alert alert-error\">Error: Your password must contain only letters, numbers and '_', '-', with at least six characters.</div>";
							}
						}
						else{
							echo "<div class=\"alert alert-error\">Error: Your username can only contain letters, numbers and '_', '-', with 3 to 16 characters.</div>";
						}

					}
					catch (Exception $e){
						echo "<div class=\"alert alert-error\">Error: " . $e->getMessage()."</div>";
					}
				}

				//Define variables to insert in the form
				$name = (isset($_POST["name"])) ? $_POST["name"] : "";
				$password = (isset($_POST["password"])) ? $_POST["password"] : "";
				$serverSQL = (isset($_POST["serverSQL"])) ? $_POST["serverSQL"] : "";
				$userSQL = (isset($_POST["userSQL"])) ? $_POST["userSQL"] : "";
				$passwordSQL = (isset($_POST["passwordSQL"])) ? $_POST["passwordSQL"] : "";
				$baseSQL = (isset($_POST["baseSQL"])) ? $_POST["baseSQL"] : "";
			?>
			<form action="install.php" method="post">
				<div class="form-group">
					<label for="inputName">Admin name</label>
					<input type="text" class="form-control" name="name" id="inputName" placeholder="Admin name" value="<?php echo $name;?>">
				</div>

				<div class="form-group">
					<label for="inputPassword">Admin password</label>
					<input type="password" class="form-control" name="password" id="inputPassword" placeholder="Admin password" value="<?php echo $password;?>">
				</div>

				<div class="form-group">
					<label for="inputServerSQL">MySQL server</label>
					<input type="text" class="form-control" name="serverSQL" id="inputServerSQL" placeholder="MySQL server" value="<?php echo $serverSQL;?>">
				</div>

				<div class="form-group">
					<label for="inputUserSQL">MySQL user</label>
					<input type="text" class="form-control" name="userSQL" id="inputUserSQL" placeholder="MySQL user" value="<?php echo $userSQL;?>">
				</div>

				<div class="form-group">
					<label for="inputPasswordSQL">MySQL password</label>
					<input type="password" class="form-control" name="passwordSQL" id="inputPasswordSQL" placeholder="MySQL password" value="<?php echo $passwordSQL;?>">
				</div>

				<div class="form-group">
					<label for="inputBaseSQL">MySQL DB</label>
					<input type="text" class="form-control" name="baseSQL" id="inputBaseSQL" placeholder="MySQL DB" value="<?php echo $baseSQL;?>">
				</div>

				<button type="submit" class="btn btn-default">Submit</button>
			</form>			
		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="<?php echo JS_PATH; ?>bootstrap.js"></script>
	</body>
</html>