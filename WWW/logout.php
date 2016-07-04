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

if ( session_status() == PHP_SESSION_NONE ) { session_start(); }
/*
 *	TODO: Make you log out.
 */
require_once './php/ST_API.php';
$Logout = new Logout();

?>