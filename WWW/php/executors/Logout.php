<?php

class Logout
{
	public function __construct()
	{
		if ( !isset( $_SESSION['API_CURRENT_AUTH_TOKEN'] ) )
		{
			if ( session_status() != PHP_SESSION_NONE ) { session_destroy(); }// Destroy the session for fun.
			header( "Location:/login.php" );
			exit;
		}
		$REQUEST = new DeleteRequest( '/auth' );
		$RESPONSE_HEADERS = $REQUEST->get_RESPONSE_HEADER();


		if ( preg_match("/204/", $RESPONSE_HEADERS[0]) )
		{
			trigger_error('Logout was successful.');
		} elseif ( preg_match( "/404/", $RESPONSE_HEADERS[0] ) ) {
			trigger_error('User is already logged out');
		}

		
		session_destroy();
		header( "Location:/login.php" );
		exit;
	}
}

?>