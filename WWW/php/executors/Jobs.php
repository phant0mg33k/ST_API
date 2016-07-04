<?php

class Jobs
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
			$this->RESPONSE = $RESPONSE['data']['jobs'];
			return true;
		} else {
			return false;
		}
	}
	public function get_all()
	{
		$REQUEST = new GetRequest( '/job' );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
	public function get_all_by_tech_id( $ID )
	{
		$REQUEST = new GetRequest( '/job', array( 'status' => 'scheduled', 'ownerId' => $ID, 'longForm' => true ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
}


?>