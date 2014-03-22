<html>
	<head>
		<title>Codename: Shutdown</title>
		<link rel="stylesheet" type="text/css" href="<?php echo get_url( 'style.css' ); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo get_url( 'css/jquery.terminal.css' ); ?>">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	</head>
	<body>
		<div id="navigation">
			<div class="title">
				Moros' Playground
			</div>
			<?php Navigation::getMessageHTML(); ?>
			<div class="user">
			<?php if( ! Authentication::is_logged_in() ) { ?>
				<a href="<?php echo get_url( 'login' ); ?>">Login</a>
			<?php } else { ?>
				Welcome <?php echo Authentication::get_name(); ?>!
				<?php if( Authentication::is_admin() ) { ?>
					<span class="admin">(Administrator)</span>
					<a href="<?php echo get_url( 'logout' ); ?>">Logout</a>
				<?php } ?>
			<?php } ?>
			</div>
		</div>
