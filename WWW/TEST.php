<?php

session_start();

require_once './php/ST_API.php';

$Assets = new Assets();

if ( isset($_REQUEST['id']) )
{
	if ( preg_match("/;/", $_REQUEST['id']) )
	{
		// we found a semi-colon so we are assuming a list of IDs.
		$retVal = "";
		foreach( explode( ';', $_REQUEST['id'] ) as $ASSET_ID )
		{
			$retVal += ($Assets->mark_asset_inspected( $ASSET_ID )) ? 'True' : 'False';
			$retVal += "\n";
		}
		echo $retVal;
	} else {
		echo ($Assets->mark_asset_inspected( $_REQUEST['id'] )) ? 'True' : 'False';	
	}
} else {
	echo 'No id supplied!';
}

?>