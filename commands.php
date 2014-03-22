<?php

Commands::addCommand( 'list_users', function(){

	global $database;

	$data = $database->query( 'SELECT * FROM `users`' );
	return array( 'result' => $data );

} );
