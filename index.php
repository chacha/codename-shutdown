<?php

define( 'DOMAIN', 'http://localhost' );
define( 'STARTURI', '/play/' );
define( 'ABSPATH', __DIR__ );

error_reporting(E_ALL);

include ABSPATH . '/lib/navigation.php';

function get_url( $path = '' ){
	return DOMAIN . STARTURI . $path;
}

function get_page_identifier(){
	return str_replace( STARTURI, '', $_SERVER['REQUEST_URI'] );
}

function load_template( $template_name ) {
	include ABSPATH . '/templates/' . $template_name . '.php';
}

Navigation::setMessage ('Hello World!');

load_template( 'header' );
load_template( 'footer' );
