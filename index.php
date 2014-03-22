<?php

define( 'DOMAIN', 'http://192.168.1.73' );
define( 'STARTURI', '/play/' );
define( 'ABSPATH', __DIR__ );

error_reporting(E_ALL);

include ABSPATH . '/config.php';

include ABSPATH . '/lib/database.php';
include ABSPATH . '/lib/authentication.php';
include ABSPATH . '/lib/navigation.php';
include ABSPATH . '/lib/router.php';
include ABSPATH . '/lib/commands.php';
include ABSPATH . '/lib/user.php';
include ABSPATH . '/lib/system.php';

new System();

$database = new Database( DB_HOST, DB_USER, DB_PASS, DB_NAME );
$database->connect();


Authentication::init();

function get_url( $path = '' ){
	return DOMAIN . STARTURI . $path;
}

function load_template( $template_name ) {
	include ABSPATH . '/templates/' . $template_name . '.php';
}

Router::addRoute( '', function(){
	load_template( 'header' );
	load_template( 'pages/index' );
	load_template( 'footer' );
} );

include ABSPATH . '/commands.php';
Router::addRoute( 'js_terminal', function(){
	if ( ! isset( $_REQUEST['command'] ) ) {
		die( json_encode( array( 'error' => '400', 'status' => 'Bad Request' ) ) );
	}

	$callback = Commands::getCommand( $_REQUEST['command'] );
	if( !$callback ){
		die( json_encode( array( 'error' => '404', 'status' => 'Command Not Found' ) ) );
	}

	$value = $callback();
	die( json_encode( $value ) );
} );

Router::addRoute( 'start', function(){
	load_template( 'header' );
	load_template( 'pages/start' );
	load_template( 'footer' );
} );

Router::addRoute( 'login', function(){

	if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
		$loggedIn = User::login( $_POST['username'], $_POST['password'] );
		if( $loggedIn ){
			header( 'Location: ' . get_url( 'dashboard' ) );
		}
	}

	load_template( 'header' );
	load_template( 'login' );
	load_template( 'footer' );

} );

Router::addRoute( 'logout', function(){
	require_login();

	Authentication::clear_user();
	header( 'Location: ' . get_url( '' ) );

} );

Router::addRoute( 'dashboard', function(){
	require_admin();

	Navigation::setMessage( 'Welcome back, Tyler.' );
	load_template( 'header' );
	load_template( 'dashboard' );
	load_template( 'footer' );

} );

// Load Answers Routes
include ABSPATH . '/answers.php';

$callback = Router::getRoute();
if( !$callback ){

	load_template( 'header' );
	echo 'You have come to a place that does not exist. Good job. Try again.';
	load_template( 'footer' );

} else {
	
	$callback();

}
