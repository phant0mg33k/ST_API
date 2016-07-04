<?php

class Appointments
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
			$this->RESPONSE = $RESPONSE;
			return true;
		} else {
			return false;
		}
	}
	public function get_all()
	{
		$REQUEST = new GetRequest( '/appointment', array(  ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
	public function get_all_by_tech_id( $ID )
	{
		$REQUEST = new GetRequest( '/appointment', array( 'techIds' => $ID ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );
	}
	public function get_all_scheduled_by_tech_id( $ID )
	{
		$REQUEST = new GetRequest( '/appointment', array( 'status' => 'scheduled', 'techIds' => $ID ) );
		$RESPONSE = $REQUEST->get_RESPONSE();
		return $this->save_response( $RESPONSE );	
	}
}
?>