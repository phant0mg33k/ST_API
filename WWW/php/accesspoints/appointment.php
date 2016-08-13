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
 *      If the array contains a location id for the appointment, that ID will be used to retrieve a list of every asset at that location.
 *      They will be appended to the first ServiceRequest and returned in JSON format.
 *
 */

// Require the library.
require_once '../ST_API.php';
SECURITY_ENSURE_AUTHENTICATED();

// Create the Appointments object 
$Appointments = new Appointments();
$Appointments->get_all_clocked_in_by_tech_id();
$APPOINTMENTS = $Appointments->get_response();

if ( isset( $APPOINTMENTS['data'] )  ) {
  $Assets = new Assets();
  $Assets->get_all_by_location_id( $APPOINTMENTS['data']['location']['id'] );
  $APPOINTMENTS['data']['serviceRequests'][0]['ASSETS'] = $Assets->get_response();
  $RESPONSE = json_encode( array($APPOINTMENTS['data']) );
} else {
  $RESPONSE = json_encode( array("error"=>"No appointment was returned from the TimeClock. You must be clocked into an appointment to use this tool.") );
}

// If we got to this point there was no appointment.
echo $RESPONSE;
exit; // EXECUTION MAY END HERE IF NO APPOINTMENT IS CLOCKED IN.
?>