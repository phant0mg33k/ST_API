<?php

class Logout
{
  public function __construct()
  {
    if ( !isset( $_SESSION['API_CURRENT_AUTH_TOKEN'] ) )
    { // API_CURRENT_AUTH_TOKEN is not set. (Session is not "authenticated")
      if ( session_status() != PHP_SESSION_NONE ) { session_destroy(); /* Destroy the session to ensure */ }
      // Redirect user to login page.
      header( "Location:/login.php" );
    } else { // API_CURRENT_AUTH_TOKEN is set...
      // Create a new DeleteRequest to the '/auth' endpoint.
      $REQUEST = new DeleteRequest( '/auth' );
      /* We are assuming that the request to logout was successful.
       *  We are destroying the session so there will not be an API_CURRENT_AUTH_TOKEN.
       *  This does not ensure that ServiceTrade responded that the token was successfully marked.
       *
       * TODO: Add RESPONSE HEADER checking to ensure that the auth token was successfully deleted. ( 204 )
       *      There is the chance for a 404 error, this could mean that the token is already invalid. WHAH!
       */
      // Nuke the session.
      session_destroy();
      // Send user to login page.
      header( "Location:/login.php" );
    }
    exit; // Make sure nothing else happens
  }
}

?>