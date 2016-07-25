<?php

if ( session_status() == PHP_SESSION_NONE )
	session_start();

require_once '../ST_API.php'; // Require ST_API library

$assetId = null;
$property = null;

if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
// We are trying to make modifications.
	extract( $_POST, EXTR_IF_EXISTS ); // Expand POST array into assetId

	if ( isset($assetId) && !is_null($assetId) )
	{
/* TODO: Clean this **** Up.
 */
		if ( isset($property) && !is_null($property) )
		{
			$Assets = new Assets();

			if ( $property == "last_insp_date" ) {
				$didSucceed = $Assets->mark_asset_inspected( $assetId );
			} elseif ( $property == "last_6_year_test_date" ) {
				$didSucceed = $Assets->mark_asset_6_year_tested( $assetId );
			} elseif ( $property == "last_12_year_test_date" ) {
				$didSucceed = $Assets->mark_asset_12_year_tested( $assetId );
			} else {
				echo json_encode( array( 'error' => 'Requested update to property that can not currently be updated.') );
				exit;
			}

			if ( $didSucceed )
			{
				echo json_encode( array('alert'=>'Asset was successfully marked as inspected.'."\n".'Updated: '.$property) );
				exit;
			} else {
				echo json_encode( array('error'=>'Asset was not successfully marked as inspected.') );
				exit;
			}
		} else {
			echo json_encode( array( 'error' => 'Property to inspect was not specified.' ) );
			exit;
		}
	} else {
		echo json_encode( array('error'=>'No assetId was supplied.') );
		exit;
	}
} elseif ( $_SERVER['REQUEST_METHOD'] == "GET" ) {
// Going GET Route
extract( $_GET, EXTR_IF_EXISTS );
	if ( !isset($assetId) )
	{
		// Return error and cease execution.
		echo json_encode( array( 'error'=>'No assetId was supplied.' ) );
		exit;
	} else {
		$Assets = new Assets();						// New Assets Executor
		$Assets->get_by_id( $assetId );				// Get the Asset by it's ID.
		echo json_encode( array( 'asset'=>$Assets->RESPONSE ) );		// Return the Asset JSON_encoded.
		exit;										// Cease execution.
	}
}

?>