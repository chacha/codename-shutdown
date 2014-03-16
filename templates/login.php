<div id="dashboard-login">

	<?php if( $_POST ) { ?>
	<div class="warning">
		The username or password you have entered is incorrect.
	</div>
	<?php } ?>

	<form id="login" action="" method="POST">
		<div class="field">
			Username
			<input type="text" name="username" value="tyler" />
		</div>
		<div class="field">
			Password
			<input type="password" name="password" />
			<span class="hint">Password Hint: Best Robotics Team Ever</span>
		</div>
		<input type="submit">
	</form>
</div>

