<?php
/* This is a very raw file for testing purposes only.
*
*/

	session_start();

require_once '../php/ST_API.php';

$SITE_TITLE = 'Demo Page';

require_once __T_ROOT__.'_header.php';

/* TODO:
 *		Allow Appointments to be opened into an "Appointment View"
 *
 */

$Appointments = new Appointments();
//$Appointments->get_all_scheduled_by_tech_id( $_SESSION['API_USER_ID'] );
$Appointments->get_all_by_tech_id( $_SESSION['API_USER_ID'] );

$APPOINTMENTS = json_decode($Appointments->RESPONSE, true);
$APPOINTMENTS = $APPOINTMENTS['data']['appointments'];


foreach ( range(0, ( count($APPOINTMENTS) - 1 ) ) as $IDX )
{
	foreach ( range( 0, ( count($APPOINTMENTS[$IDX]['serviceRequests']) - 1 ) ) as $JDX )
	{
		if ( empty($APPOINTMENTS[$IDX]['serviceRequests']) ) // serviceRequests is Empty so let's skip this one.
			continue;

		if ( preg_match( "/Location/", $APPOINTMENTS[$IDX]['serviceRequests'][$JDX]['asset']['name']) )
		{
			$Assets = new Assets();
			$Assets->get_all_by_location_id( $APPOINTMENTS[$IDX]['location']['id'] );
			
			$APPOINTMENTS[$IDX]['serviceRequests'][$JDX]['ASSETS'] = array();

			foreach( $Assets->RESPONSE['assets'] as $ASSET )
			{

				array_push( $APPOINTMENTS[$IDX]['serviceRequests'][$JDX]['ASSETS'] , $ASSET);
			}
		} else {
			$Assets = new Assets();
			$Assets->get_by_id( $APPOINTMENTS[$IDX]['serviceRequests'][$JDX]['asset']['id'] );
			$ASSET = $Assets->RESPONSE;
			$APPOINTMENTS[$IDX]['serviceRequests'][$JDX]['asset'] = $ASSET;
		}
	}
}

?>

<div class="container">

<?php
foreach( $APPOINTMENTS as $APPOINTMENT )
{
	if ( empty( $APPOINTMENT['serviceRequests'] ) )
	{
		continue;
	}
	echo '<pre>';
	var_dump($APPOINTMENT);
	echo '</pre>';
}
?>

</div>

<?php
require_once __T_ROOT__.'_footer.php';
?>