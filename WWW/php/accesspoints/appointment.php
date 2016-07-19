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
//$Appointments->get_all_scheduled_by_tech_id();
//$Appointments->get_all_by_tech_id();
$Appointments->get_all_clocked_in_by_tech_id();

$APPOINTMENTS = json_decode( $Appointments->RESPONSE , true);

echo "<pre>";
var_dump($APPOINTMENTS);
echo "</pre>";

if ( $APPOINTMENTS['data'] )
{

} elseif ( isset( $APPOINTMENTS['data']['appointments'] ) && count($APPOINTMENTS['data']['appointments']) > 0 ) {

$APT_LIST = array();

foreach( $APPOINTMENTS['data']['appointments'] as $APPOINTMENT )
{
	$apt = array( 
		'id' => $APPOINTMENT['id'],
		'status' => $APPOINTMENT['status'],
		'windowStart' => $APPOINTMENT['windowStart'],
		'windowEnd' => $APPOINTMENT['windowEnd'],
		'serviceRequests' => $APPOINTMENT['serviceRequests']
	);
	array_push($APT_LIST, $apt);
}

echo json_encode($APPOINTMENTS['data']['appointments']);

echo json_encode($APT_LIST);

} else {

echo json_encode(array("error"=>"No appointments to display."));

}

?>