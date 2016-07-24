<?php
/* ServiceTrade API
 *
 * Appointment endpoint remapping.
 *
 *	Purpose: To provide a quick and easy URL for the homepage to hit and retrieve a list of Appointments.
 *
 *
 */

// Start the session.
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

// Require the library.
require_once '../ST_API.php';

// Create the Appointments object 
$Appointments = new Appointments();
// Currently we are asking for all of the schedule appointments by tech ID.
// We can also ask for All appointments for the technician
// And we can ask for only the appointments which the technician is clocked into.

//$Appointments->get_all();
//$Appointments->get_all_by_tech_id();
//$Appointments->get_all_scheduled_by_tech_id();
$Appointments->get_all_clocked_in_by_tech_id();

$APPOINTMENTS = json_decode( $Appointments->RESPONSE , true);

if ( ! isset( $APPOINTMENTS['data']['appointments'] )  )
{
	$Assets = new Assets();
	$Assets->get_all_by_location_id( $APPOINTMENTS['data']['location']['id'] );

	$APPOINTMENTS['data']['serviceRequests'][0]['ASSETS'] = $Assets->RESPONSE['assets'];

	echo json_encode( array( $APPOINTMENTS['data'] ) );

} elseif ( isset( $APPOINTMENTS['data']['appointments'] ) && count($APPOINTMENTS['data']['appointments']) > 0 ) {

// Loop through ServiceRequests and expand the ASSETS array to contain every asset for that LOCATION ID


	echo json_encode($APPOINTMENTS['data']['appointments']);

} else {

	echo json_encode(array("error"=>"No appointments to display."));

}

?>