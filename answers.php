<?php

// Answers
Router::addRoute( '12', function(){
	load_template( 'header' );
	load_template( 'pages/two' );
	load_template( 'footer' );
} );

Router::addRoute( '44', function(){
	load_template( 'header' );
	load_template( 'pages/three' );
	load_template( 'footer' );
} );

Router::addRoute( '514229', function(){
	load_template( 'header' );
	load_template( 'pages/four' );
	load_template( 'footer' );
} );
