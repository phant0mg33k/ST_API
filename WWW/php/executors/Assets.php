<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 	Assets Executor
 *  UNDER HEAVY DEVELOPMENT
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class Assets extends Executor
{
	private function save_response( $RESPONSE )
	{
		if ( !is_null( $RESPONSE ) )
		{
			$RESPONSE = json_decode($RESPONSE, true);
			$this->RESPONSE = $RESPONSE['data'];
			return true;
		} else {
			return false;
		}
	}

	/* Start Accessor
	*
	*/
	public function get_by_id( $ID, $STATUS='active' )
	{
		$REQUEST = new GetRequest( "/asset/$ID" );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
	public function get_all_by_type( $TYPE, $STATUS='active' )
	{
		$REQUEST = new GetRequest( '/asset', array( 'type' => $TYPE, 'status' => $STATUS ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
	public function get_all_by_location_id( $LOCATION_ID, $STATUS='active,inactive' )
	{
		$REQUEST = new GetRequest( '/asset', array( 'locationId' => $LOCATION_ID, 'status' => $STATUS , 'type' => 'extinguisher' ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}

	/*	Start private mutator code
	*		Used by public mutators
	*/
	private function update_asset( $ASSET_ID, $REQUEST_PARAMS )
	{
		$Assets = new Assets();
		$PutRequest = new PutRequest( '/asset/'.$ASSET_ID, $REQUEST_PARAMS );
		$RESPONSE_HEADER = $PutRequest->get_RESPONSE_HEADER();

		if ( preg_match( "/200/", $RESPONSE_HEADER[0] ) )
		{
			return true;
		}
		return false;
	}

	/*	Start public mutator code
	*		Provide very specific mutations to the properties of the asset.
	*			Currently you can "mark_asset_inspected" with the asset ID which will update the "last_insp_date".
	*/
	public function mark_asset_inspected( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array('properties'=>array("last_insp_date"=>time())) );
		return $this->update_asset( $ASSET_ID, $REQUEST_PARAMS );
	}

	public function mark_asset_inactive( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array( 'status' => 'inactive' ) );
		return $this->update_asset( $ASSET_ID, $REQUEST_PARAMS );
	}

	public function mark_asset_active( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array( 'status' => 'active' ) );
		return $this->update_asset( $ASSET_ID, $REQUEST_PARAMS );	
	}

	public function update_asset_notes( $ASSET_ID, $NOTES )
	{
		// Should probably sanitize the notes here.
		$REQUEST_PARAMS = json_encode( array('properties' => array('notes' => $NOTES)) );
		return $this->update_asset( $ASSET_ID, $REQUEST_PARAMS );
	}
}
?>