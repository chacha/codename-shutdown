<?php 

class Authentication{

	private static $is_logged_in = false;
	private static $user = array();

	public static function init(){

		session_start();

		if( isset( $_SESSION['user'] ) ){
			self::$user = $_SESSION['user'];
			self::$is_logged_in = true;
		}

	}

	public static function set_user( $name, $level ) {
		$_SESSION['user'] = array(
			'name' => $name,
			'level' => $level,
			'data' => $data
		);
	}

	public static function clear_user( ) {

		unset( $_SESSION['user'] );
		self::$user = array();
		self::$is_logged_in = false;

	}

	public static function get_user(){
		if( ! self::$is_logged_in )
			return false;

		return self::$user;
	}

	public static function get_name(){
		if( ! self::$is_logged_in )
			return false;

		return self::$user['name'];	
	}

	public static function is_admin(){
		if( ! self::$is_logged_in )
			return false;
		
		if( self::$user['level'] == 'admin' )
			return true;
		else
			return false;
	}

	public static function is_logged_in(){
		return self::$is_logged_in;
	}

}

function is_logged_in(){
	return Authentication::is_logged_in();
}

function require_login(){
	if( ! is_logged_in() ){
		header( 'Location: ' . get_url( 'login' ) );
	}
}

function require_admin(){
	if( ! Authentication::is_admin() ){
		header( 'Location: ' . get_url( 'login' ) );
	}
}
