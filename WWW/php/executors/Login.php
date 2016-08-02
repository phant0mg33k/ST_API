<?php

class Login
{
	public function __construct( $USERNAME, $PASSWORD )
	{
		// New post request to AUTH endpoint.
		$REQUEST = new PostRequest( '/auth', array( 'username' => $USERNAME, 'password' => $PASSWORD ) );
		// Convert response to an associative array.
		$response = json_decode($REQUEST->get_RESPONSE(), true);
		if ( isset($response['data']['authenticated']) && $response['data']['authenticated'] )
		{
			// The server responded with a JSON object that contains a "true" value for the "authenticated" key.
			$_SESSION['API_CURRENT_AUTH'] = $response['data']['authenticated'];
			$_SESSION['API_CURRENT_AUTH_TOKEN'] = $response['data']['authToken'];
			$_SESSION['API_USER_ID'] = $response['data']['user']['id'];
		} else {
			// We failed login. unset these values. (Possibly just regenerate the session.)
			unset($_SESSION['API_CURRENT_AUTH']);
			unset($_SESSION['API_CURRENT_AUTH_TOKEN']);
			unset($_SESSION['API_USER_ID']);
		}
	}
}

?>