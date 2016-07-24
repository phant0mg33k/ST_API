<?php

class Assets
{
	public $RESPONSE;

	public function __construct()
	{
		$this->RESPONSE = null;
	}

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
	public function get_all_by_location_id( $LOCATION_ID, $STATUS='active' )
	{
		$REQUEST = new GetRequest( '/asset', array( 'locationId' => $LOCATION_ID, 'status' => $STATUS , 'type' => 'extinguisher' ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}


	public function mark_asset_inspected( $ASSET_ID )
	{
		$Assets = new Assets();
		$REQUEST_PARAMS = json_encode( array('properties' => array('last_insp_date' => time())) );
		$PutRequest = new PutRequest( '/asset/'.$ASSET_ID, $REQUEST_PARAMS );
		$RESPONSE_HEADER = $PutRequest->get_RESPONSE_HEADER();

		if ( preg_match( "/200/", $RESPONSE_HEADER[0] ) )
		{
			// success
			return true;
		} else {
			// failed
			//echo $RESPONSE_HEADER[0];
			return false;
		}
	}


}
?>