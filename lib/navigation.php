<?php

class Navigation {

	public static $message = '';

	public static function setMessage( $message ){
		self::$message = $message;
	}

	public static function getMessage(){
		return self::$message;
	}

	public static function getMessageHTML(){
		if( self::$message ){
			echo '<div class="message">Notice: ' . self::$message . '</div>';
		}
	}

}
