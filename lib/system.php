<?php

class System{

	public function __construct(){
		Commands::addCommand( 'system', array( $this, 'dispatch' ) );
	}

	public function dispatch(){

		if( ! isset( $_REQUEST['args'][0] ) ){
			return array( 'error' => 400, 'status' => 'Bad system command.' );
		}

		$command = $_REQUEST['args'][0];
		if( method_exists( $this, $command ) ){
			return $this->$command();
		} else {
			return array( 'error' => 400, 'status' => 'System command not found.' );
		}

	}

	public function install(){
		global $database;

		$database->query( "DROP TABLE IF EXISTS `users`" );

		$sql = "Create TABLE IF NOT EXISTS `users` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`name` varchar(255) NOT NULL default '',
			`password` varchar(255) NOT NULL default '',
			`level` varchar(255) NOT NULL default '',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";

		$database->query( $sql );

		create_user( "tyler", "test123", "admin" );
	}
}
