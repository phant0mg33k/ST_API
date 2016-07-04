<?php

if ( session_status() == PHP_SESSION_NONE )
	session_start();

if ( !isset($_GET['assetId']) )
{
	echo 'No Asset ID supplied';
	exit;
} else {

	require_once '../ST_API.php'; // Require ST_API library

	$Assets = new Assets();	 // New Assets Executor
	$Assets->get_by_id( $_GET['assetId'] );	// Get the Asset by it's ID.

	echo json_encode($Assets->RESPONSE);	// Return the Asset JSON_encoded.

	exit;	// Cease execution.
}

?>