<?php

if ( session_status() == PHP_SESSION_NONE )
	session_start();

require_once '../ST_API.php';
$Appointments = new Appointments();
$Appointments->get_all_scheduled_by_tech_id( $_SESSION['API_USER_ID'] );
//$Appointments->get_all_by_tech_id( $_SESSION['API_USER_ID'] );

$APPOINTMENTS = $Appointments->RESPONSE;
$APPOINTMENTS = json_decode($APPOINTMENTS, true);
$APPOINTMENTS = $APPOINTMENTS['data']['appointments'];

/* BEGIN EXPERIMENTAL ASSET LISTING LOOPS */
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

$APPOINTMENTS = json_encode($APPOINTMENTS);

echo $APPOINTMENTS;

?>