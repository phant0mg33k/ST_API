<?php

class Login
{
	public function __construct( $USERNAME, $PASSWORD )
	{
		$REQUEST = new PostRequest( '/auth', array( 'username' => $USERNAME, 'password' => $PASSWORD ) );
		$response = json_decode($REQUEST->get_RESPONSE(), true);
		if ( isset($response['data']['authenticated']) && $response['data']['authenticated'] )
		{
			$_SESSION['API_CURRENT_AUTH'] = true;
			$_SESSION['API_CURRENT_AUTH_TOKEN'] = $response['data']['authToken'];
			$_SESSION['API_USER_ID'] = $response['data']['user']['id'];
		} else {
			unset($_SESSION['API_CURRENT_AUTH']);
			unset($_SESSION['API_CURRENT_AUTH_TOKEN']);
			unset($_SESSION['API_USER_ID']);
		}
	}
}

?>