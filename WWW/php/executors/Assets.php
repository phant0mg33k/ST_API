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
	public function get_all_by_location_id( $LOCATION_ID, $STATUS='active' )
	{
		$REQUEST = new GetRequest( '/asset', array( 'locationId' => $LOCATION_ID, 'status' => $STATUS , 'type' => 'extinguisher' ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}

	/*	Start private mutator code
	*		Used by public mutators
	*/
	private function mark_asset( $ASSET_ID, $REQUEST_PARAMS )
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
	*			If you mark_asset_6_year_tested
	*/
	public function mark_asset_inspected( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array("properties"=>array("last_insp_date"=>time())) );
		return $this->mark_asset( $ASSET_ID, $REQUEST_PARAMS );
	}
	public function mark_asset_6_year_tested( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array("properties"=>array("last_insp_date"=>time(),"last_6_year_test_date"=>time())) );
		return $this->mark_asset( $ASSET_ID, $REQUEST_PARAMS );
	}
	public function mark_asset_12_year_tested( $ASSET_ID )
	{
		$REQUEST_PARAMS = json_encode( array("properties"=>array("last_insp_date"=>time(),"last_6_year_test_date"=>time(),"last_12_year_test_date"=>time())) );
		return $this->mark_asset( $ASSET_ID, $REQUEST_PARAMS );
	}
}
?>