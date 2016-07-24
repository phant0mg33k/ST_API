<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Auxiliary functions to be used across pages.
 * 
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/


/* ------ BEGIN SECURITY SECTION ------ */

/* SECURITY_ENSURE_AUTHENTICATED
 *
 *	Helper function to be called at the beginning of any secured page to redirect
 *  	users who do not have an authenticated session to the login page.
 */
function SECURITY_ENSURE_AUTHENTICATED()
{
	if ( !isset( $_SESSION['API_CURRENT_AUTH'] ) || 
		 !isset( $_SESSION['API_CURRENT_AUTH_TOKEN'] ) ||
		 !$_SESSION['API_CURRENT_AUTH'] )
	{
		header("location:./login.php"); // Force redirect to login page.
		exit; // Discontinue execution.
	}
}

/* ------ END SECURITY SECTION ------ */


?>