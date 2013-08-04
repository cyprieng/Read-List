<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Read List</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo CSS_PATH; ?>bootstrap.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>customBootstrap.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>datepicker.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>bootstrap-sortable.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>bootstrap-glyphicons.css" rel="stylesheet">
		<link href="<?php echo CSS_PATH; ?>main.css" rel="stylesheet">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
						<li <?php if($p == "") echo 'class="active"' ?>>
							<a href="index.php">List</a>
						</li>
						<li <?php if($p == "stats") echo 'class="active"' ?>>
							<a href="index.php?p=stats">Stats</a>
						</li>
						<li <?php if($p == "add") echo 'class="active"' ?>>
							<a href="index.php?p=add">Add</a>
						</li>
						<li <?php if($p == "settings") echo 'class="active"' ?>>
							<a href="index.php?p=settings">Settings</a>
						</li>
						<li>
							<a href="index.php?p=login&logoff=1">Log off</a>
						</li>
					</ul>
				</div>
			</div>
		</div>