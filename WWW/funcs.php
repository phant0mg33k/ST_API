<?php
/* Prototype for Interfacing with ServiceTrade
 *
 *  This file contains functions
 */
$GLOBALS['API_BASE_URL'] = 'https://api.servicetrade.com/api/';
require_once './classes/STClasses.php';
require_once './classes/STRequest.php';

function perform_login( $username, $password )
{
	// We will change this to be part of a login script.
	$data = array( 'username' => $username, 'password' => $password );
	$data = http_build_query($data);

	$STRequest = new STRequest();
	$STRequest->set_REQUEST_METHOD('POST');
	$STRequest->set_REQUEST_HEADERS("Content-Type: application/x-www-form-urlencoded\r\n"."Content-Length: ".strlen($data)."\r\n");
	$STRequest->set_REQUEST_PARAMS($data);
	$STRequest->create_context();
	$DECODED_RESPONSE = $STRequest->get_RESPONSE($GLOBALS['API_BASE_URL'].'auth');

	$isAuthenticated = $DECODED_RESPONSE->data->authenticated;
	$authToken = $DECODED_RESPONSE->data->authToken;

	$API_USER = new User( $DECODED_RESPONSE->data->user );

	$user = $DECODED_RESPONSE->data->user->name;

	if ( $isAuthenticated )
	{ // Successful Authentication
		$_SESSION['API_CURRENT_AUTH'] = true;
		$_SESSION['API_CURRENT_AUTH_USER'] = $user;
		$_SESSION['API_CURRENT_AUTH_TOKEN'] = $authToken;
		return true;
	} else {
		var_dump($JSON_response);
	}
	// End Authentication
	return false;
}


?>