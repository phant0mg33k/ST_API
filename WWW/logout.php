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

require_once './php/ST_API.php';

SECURITY_ENSURE_AUTHENTICATED();

// Page does not display. If you are logged in or logged out you will end up on the login page.
$Logout = new Logout();
exit;
?>