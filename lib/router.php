<?php

class Router{

	static $routes = array();

	public static function addRoute( $identifier, $callback ){
		self::$routes[ $identifier ] = $callback;
	}

	public static function getRoute( $identifier = '' ) {
		if( ! $identifier ) {
			$identifier = self::getCurrentPage();
		}

		if( array_key_exists( $identifier, self::$routes ) ) {
			return self::$routes[ $identifier ];
		} else {
			return false;
		}
	}

	public static function getCurrentPage(){
		return str_replace( STARTURI, '', $_SERVER['REQUEST_URI'] );
	}
}
