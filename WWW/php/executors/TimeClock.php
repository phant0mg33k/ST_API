<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Abstracts the ServiceTrade AccessPoint for TimeClock events.
 *		Currently provides the ability to retrieve a list of all "open" clock events
 *		for the currently logged in user.
 *
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class TimeClock
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
			$RESPONSE = json_decode( $RESPONSE, true );
			$RESPONSE = json_encode( $RESPONSE['data']['events'] );
			$this->RESPONSE = $RESPONSE;
			return true;
		} else {
			return false;
		}
	}

	public function get_open_clock_events()
	{
		$REQUEST = new GetRequest( '/clock', array('userId'=>$_SESSION['API_USER_ID'],'openClockEvents'=>1) );
		return $this->save_response( $REQUEST->get_RESPONSE() );
	}
}

?>