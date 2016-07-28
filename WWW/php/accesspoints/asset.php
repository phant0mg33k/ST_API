<?php

if ( session_status() == PHP_SESSION_NONE )
	session_start();

require_once '../ST_API.php'; // Require ST_API library

$assetId = null;
$property = null;
$status = null;

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
			} else {
				echo json_encode( array( 'error' => 'Requested update to property that can not currently be updated.') );
				exit;
			}

			if ( $didSucceed )
			{
				echo json_encode( array('alert'=>"Asset was successfully marked as inspected.\nUpdated: $property") );
				exit;
			} else {
				echo json_encode( array('error'=>'Asset was not successfully marked as inspected.') );
				exit;
			}
		} elseif ( isset($status) && !is_null($status) ) {
			$Assets = new Assets();

			if ( $status == "inactive" )
			{
				// mark status inactive
				$didSucceed = $Assets->mark_asset_inactive( $assetId );
			} elseif ( $status == "active" ) {
				// mark status as active... may need to perform some testing here.
				$didSucceed = $Assets->mark_asset_active( $assetId );
			} else {
				// some error man... status was not "inactive | active"
				echo json_encode( array( 'error' => "Asset status was not updated. Status supplied was not 'active' or 'inactive'.") );
				exit;
			}

			if ( $didSucceed )
			{
				echo json_encode( array('alert'=>"Asset was successfully marked as $status.") );
				exit;
			} else {
				echo json_encode( array('error'=>"Asset was not successfully marked as $status.") );
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