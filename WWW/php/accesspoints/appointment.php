<?php
/* ServiceTrade API
 *
 * Appointment endpoint remapping.
 *
 *  Purpose: To provide a quick and easy URL for the homepage to hit and retrieve a list of Appointments.
 *
 *      Currently this file will require the ST_API library.
 *      It will create an Appointments executor and ask for "All clocked in appointments by the technician's (current logged in users) ID."
 *      It will then extract the JSON into an Associative array. If the Array is NULL it will respond with an error.
 *
 */

// Require the library.
require_once '../ST_API.php';
SECURITY_ENSURE_AUTHENTICATED();

if ( $_SERVER['REQUEST_METHOD'] != "GET" )
{
  send_alert_message( "error", "This accesspoint only supports GET method." );
} else {
  // Create the Appointments object 
  $Appointments = new Appointments();
  $Appointments->get_all_clocked_in_by_tech_id();
  $APPOINTMENTS = $Appointments->get_response();

  if ( isset( $APPOINTMENTS['data'] )  ) {
    send_json_response( array($APPOINTMENTS['data']) );
  } else {
    send_alert_message( "error", "No appointment was returned from the TimeClock. You must be clocked into an appointment to use this tool." );
  }
}

?>