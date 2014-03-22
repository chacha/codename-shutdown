<script src="<?php echo get_url('/js/jquery.terminal-0.8.6.js'); ?>"></script>
<div id="console">
</div>
<script>
$(function(){
	var ajaxURL = "<?php echo get_url( 'js_terminal' ); ?>";
	var ajaxHelper = function( command, callback ){

		if( callback == undefined ){
			callback = function( response ){
				if( response.error != undefined ){
					terminal.echo( response.status );
				} else {
					terminal.echo( "Done" );
				}
			};
		}

		return function(){ 
			$.getJSON( ajaxURL, {
				"command" : command,
				"args" : arguments,
			}, callback );
		}
	}
	
	var commands = {

		"help" : {
			"help" : "Provides a list of commands",
			"callback" : function( command ){

				if( command ) {
					if( commands[ command ] != undefined ) {
						terminal.echo( commands[ command ].help );
					} else {
						terminal.echo( "That command does not exist" );
					}
				} else {
					$.each(commands, function( index, value ){
						terminal.echo( index + " : " + value.help );
					});
				}
			},
		},
		"create_user" : {
			"help" : "Creates a new user. create_user <username> <password> <admin 0 or 1>",
			"callback" : ajaxHelper( 'create_user' ),
		},
		"delete_user" : {
			"help" : "Deletes an existing user. delete_user <username>",
			"callback" : ajaxHelper( 'delete_user' ),
		},
		"list_users" : {
			"help" : "Displays a list of current users",
				"callback" : ajaxHelper( 'list_users', function( response ){ 
					console.log( response.result );
					for( var i = 0; i < response.result.length; i++ ){
						var user = response.result[i];
						var output = "[" + user.id + "] " + user.name;
						if( user.level == "admin" ){
							output = output + "*";
						}

						terminal.echo( output );
					}
	       			} ),
		}
	};

	var terminal = $("#console").terminal( function( command, term ) {

		var parts = command.split( " " );
		var command = parts[0];

		if( commands[ command ] != undefined ) {
			commands[ command ].callback.apply( window, parts.slice( 1 ) );
		} else {
			terminal.echo( "'" + command + "' is not a valid command. Type help for a list of commands" );
		}
	}, { 
		'greetings' : 'Type help for a list of commands.', 
		'name' : 'terminal', 
		'height': 400, 
		'prompt':'<?php echo Authentication::get_name(); ?>>'
	} );

	<?php if( Authentication::get_name() == 'tyler' ) { ?>
	terminal.echo( "WARNING: Your account self-destruct has been activated." );
	terminal.echo( "You must create a new user if you want to login again." );
	<?php } ?>
});
</script>
