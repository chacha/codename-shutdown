<?php

class Commands {

	private static $commands = array();
	public static function addCommand( $command, $callback ) {
		self::$commands[ $command ] = $callback;
	}

	public static function getCommand( $command ) {
		if( array_key_exists( $command, self::$commands ) ){
			return self::$commands[ $command ];
		} else {
			return false;
		}
	}

}
