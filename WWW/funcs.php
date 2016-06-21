<?php
/* Prototype for Interfacing with ServiceTrade
 *
 *  This file contains functions
 */
$GLOBALS['API_BASE_URL'] = 'https://api.servicetrade.com/api/';
require_once './classes/STClasses.php';
require_once './classes/STRequest.php';
require_once './classes/ST_AuthUser.php';

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

	$user = new AuthUser($DECODED_RESPONSE->data->user);

	if ( $isAuthenticated )
	{ // Successful Authentication
		$_SESSION['API_CURRENT_AUTH'] = true;
		$_SESSION['API_CURRENT_AUTH_USER'] = $user->props['name'];
		$_SESSION['API_CURRENT_AUTH_TOKEN'] = $authToken;
		$_SESSION['API_CURRENT_AUTH_USER_ID'] = $user->props['id'];
		return true;
	} else {
		var_dump($JSON_response);
	}
	// End Authentication
	return false;
}

function get_auth_info()
{
	$STRequest = new STRequest();
	$STRequest->set_REQUEST_METHOD('GET');
	$STRequest->set_REQUEST_HEADERS('Cookie: PHPSESSID='.$_SESSION['API_CURRENT_AUTH_TOKEN']);
	$STRequest->set_REQUEST_PARAMS('');
	$STRequest->create_context();
	return $STRequest->get_RESPONSE($GLOBALS['API_BASE_URL'].'auth');
}

function perform_logout()
{
	$STRequest = new STRequest();
	$STRequest->set_REQUEST_METHOD('DELETE');
	$STRequest->set_REQUEST_HEADERS("Cookie: PHPSESSID=".$_SESSION['API_CURRENT_AUTH_TOKEN']);
	$STRequest->set_REQUEST_PARAMS("");
	$STRequest->create_context();
	$DECODED_RESPONSE = $STRequest->get_RESPONSE($GLOBALS['API_BASE_URL'].'auth');
	session_destroy();
	session_start();
	session_regenerate_id();
}


?>