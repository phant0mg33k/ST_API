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
		$REQUEST = new GetRequest( '/asset', array( 'locationId' => $LOCATION_ID, 'status' => $STATUS ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
}
?>