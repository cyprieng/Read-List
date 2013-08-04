<div class="container">
	<form action="index.php?p=settings" method="post">
		<fieldset>
			<legend>Settings</legend>
			<?php echo $state; ?>
			<div class="form-group">
				<label for="language">Language</label>
				<select class="form-control" id="language" name="language">
					<option value="en" <?php if($lang == "en") echo "selected"; ?>>English</option>
					<option value="es" <?php if($lang == "es") echo "selected"; ?>>Español</option>
					<option value="fr" <?php if($lang == "fr") echo "selected"; ?>>Français</option>
				</select>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</fieldset>
	</form><br/><br/>
	<form action="index.php?p=settings" method="post" enctype="multipart/form-data">
		<input id="file" type="file" name="file" style="display:none" onchange="$('button[id=CSV]').click();"/>
		<a class="btn btn-primary" onclick="$('input[id=file]').click();">Import CSV</a>
		<button type="submit" id="CSV" class="btn btn-primary" style="display:none"></button>
	</form><br/><br/>
	<form action="index.php?p=settings&refresh=true" method="post">
		<button type="submit" class="btn btn-primary">Refresh books data</button>
	</form>
</div>