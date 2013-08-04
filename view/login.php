<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form class="form-signin" action="index.php?p=login&action=login" method="post">
				<h2 class="form-signin-heading">Log in</h2>
				<?php echo $state_login;?>
				<input type="text" name="name" class="input-block-level" placeholder="Name" autofocus><br/><br/>
				<input type="password" name="password" class="input-block-level" placeholder="Password">
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> Remember me
				</label>
				<button class="btn btn-large btn-primary btn-block" type="submit">Log in</button>
			</form>
		</div>
		<div class="col-lg-6">
			<form class="form-signin" action="index.php?p=login&action=register" method="post">
				<h2 class="form-signin-heading">Register</h2>
				<?php echo $state_register;?>
				<input type="text" name="name" class="input-block-level" placeholder="Name"><br/><br/>
				<input type="password" name="password" class="input-block-level" placeholder="Password"><br/><br/>
				<button class="btn btn-large btn-primary btn-block" type="submit">Register</button>
			</form>
		</div>
	</div>
</div>