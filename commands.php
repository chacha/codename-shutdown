<?php

Commands::addCommand( 'find_answers', function(){
	global $questions;

	if( ! isset( $_REQUEST['args'][0] ) ) {
		return array( 'error' => 400, 'status' => 'Must provide question id' );
	}

	$question_id = $_REQUEST['args'][0];

	if( array_key_exists( $question_id, $questions ) ) {

		$question = $questions[ $question_id ];
		if( array_key_exists( 'password', $question ) ) {
			
			if( ! isset( $_REQUEST['args'][1] ) ) {
				return array( 
					'code' => 403,
					'hint' => $question['hint']
				);
			}

			if( $_REQUEST['args'][1] == $question['password'] ) {
				return array(
					'code' => 200,
					'result' => $question
				);
			} else {
				return array( 
					'code' => 403,
					'hint' => $question['hint'],
					'input' => $_REQUEST['args'][1],
				);
			}

		} else {
			return array( 
				'code' => '200',
				'result' => $question 
			);
		}

	}


} );
