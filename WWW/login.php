<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Login page. User's found to be unauthenticated will be forced to this login portal by the SECURITY_ENSURE_AUTHENTICATED() function.
 * Requests made to this page after a user is authenticated will redirect to the root of the site.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

require_once './php/ST_API.php'; // Require our library

HANDLE_LOGIN_PAGE();

// Page Display Variables.
$PAGE['TITLE'] = 'Login'; // Page Title
$PAGE['CSS'] = array('bootstrap', 'signin');
$PAGE['JS'] = array('jquery', 'bootstrap');

require_once './partials/_header.php';

require_once './partials/_login.php';

require_once './partials/_footer.php';
?>