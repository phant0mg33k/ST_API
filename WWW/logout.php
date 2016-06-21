<?php
/***********
 * ServiceTrade API Integration 
 * 
 *    Logout Page
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

if ( session_status() == PHP_SESSION_NONE )
{
    session_start();
}

require_once './funcs.php';
require_once './classes/ST_AuthUser.php';

if ( isset( $_SESSION['API_CURRENT_AUTH'] ) && $_SESSION['API_CURRENT_AUTH'] )
{
	try {
		perform_logout();
	} catch ( Exception $e ) {
	}
}
header('location:/');
exit;

?>