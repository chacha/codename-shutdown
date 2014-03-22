<?php
global $questions;

$questions = array(
	'12' => array(
		'template' => 'two',
		'answer' => '44',
	),
	'44' => array(
		'template' => 'three',
		'answer' => '514229'
	),
	'514229' => array(
		'template' => 'four',
		'answer' => '?'
	)
);

foreach( $questions as $route => $options ){

	Router::addRoute( $route, function() use ( $route, $options ) {
		load_template( 'header' );
		load_template( 'pages/' . $options['template'] );
		load_template( 'footer' );
	} );

}
