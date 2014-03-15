<?php

class Router{

	static $routes = array();

	public static function addRoute( $identifier, $callback ){
		self::$routes[ $identifier ] = $callback;
	}

	public static function getRoute( $identifier ){
		if( array_key_exists( $identifier, self::$routes ) ) {
			return self::$routes[ $identifier ];
		} else {
			return false;
		}
	}
}
