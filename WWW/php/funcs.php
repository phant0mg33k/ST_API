<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Auxiliary functions to be used across pages.
 * 
 *
 *    Organization:
 *        dfreshnet
 *    Authors:
 *        Matthew Jones
 *        Robin Brandt
 *        Douglas Brandstetter
 *
 *    Copyright 2016
 *
 ***********/


/* ------ BEGIN SECURITY SECTION ------ */

/* SECURITY_ENSURE_AUTHENTICATED
 *
 *  Helper function to be called at the beginning of any secured page to redirect
 *      users who do not have an authenticated session to the login page.
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

/* HANDLE_LOGIN_PAGE
 *
 *
 */
function HANDLE_LOGIN_PAGE()
{
  // Check if we are trying to perform a login... Should probably go into the Access Points.
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) )
      $Login = new Login( $_POST['username'], $_POST['password'] ); // Attempt login with POSTed username and password

  // If the login was successful then we will redirect to the home page.
  // This will also redirect an already logged in user who is not trying to log in.
  if ( isset($_SESSION['API_CURRENT_AUTH']) && $_SESSION['API_CURRENT_AUTH'] ) { header("location:/"); exit; }
}

/* ------ END SECURITY SECTION ------ */

?>