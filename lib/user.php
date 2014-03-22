<?php

class User {

	public static function login( $username, $password ){
		global $database;

		$password_hash = make_password( $username, $password );

		$string = sprintf( 'SELECT * FROM `users` WHERE name="%s"', $username );
		$data = $database->query( $string );
		if( ! $data ){
			return false;
		}
		
		$user = $data[0];
		if( $user['password'] == $password_hash ){
			Authentication::set_user( $user['name'], $user['level'] );
			return true;
		}

	}

}

Commands::addCommand( 'list_users', function(){

	global $database;

	$data = $database->query( 'SELECT * FROM `users`' );
	if( $data )
		return array( 'result' => $data );
	else
		return array( 'error' => 404, 'status' => 'no users found' );

} );

Commands::addCommand( 'create_user', function(){
	if( ! isset( $_REQUEST['args'][0] ) ){
		return array( 'error' => '400', 'status' => 'must include name argument' );
	}
	$name = $_REQUEST['args'][0];

	if( ! isset( $_REQUEST['args'][1] ) ){
		return array( 'error' => '400', 'status' => 'must include password argument' );
	}
	$password = $_REQUEST['args'][1];

	if( isset( $_REQUEST['args'][2] ) && $_REQUEST['args'][2] == "1" ){
		$level = 'admin';
	} else {
		$level = 'user';
	}

	return create_user( $name, $password, $level );
} );

Commands::addCommand( 'delete_user', function(){
	
	if( ! isset( $_REQUEST['args'][0] ) ){
		return array( 'error' => '400', 'status' => 'must include name argument' );
	}

	$id = $_REQUEST['args'][0];
	return array( delete_user( $id ) );
} );

function create_user( $username, $password, $level ){
	global $database;

	$username = $database->escape( $username );
	$password = $database->escape( $password );
	$level = $database->escape( $level );

	$string = sprintf( 'SELECT * FROM `users` WHERE name="%s" LIMIT 0,1', $username );
	$found = $database->query( $string );
	if( $found ){
		return array( 'error' => '400', 'status' => 'username already taken' );
	}

	$string =  'INSERT INTO `users` (name, password, level) VALUES( "%s", "%s", "%s")';
	$string = sprintf( $string, $username, make_password( $username, $password ), $level );
	$status = $database->query( $string );

	if( ! admin_exists() ){
		return array( 
			'error' => 200, 
			'status' => 'No more admins exists. Are you sure you want to do that?'
		);
	}	
}

function delete_user( $user_id ){
	global $database;
	$string =  'DELETE FROM `users` WHERE id="%d"';

	$user_id = intval( $user_id );
	$string = sprintf( $string, $user_id );
	return $database->query( $string );
}

function make_password( $username, $password ){
	return crypt( $password, $username );
}

function admin_exists(){
	global $database;

	$string = 'SELECT * FROM `users` WHERE level="admin" LIMIT 0,1';
	$found = $database->query( $string );
	if( ! $found ){
		return false;
	} else {
		return true;
	}
}
