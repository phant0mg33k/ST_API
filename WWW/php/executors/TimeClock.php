<?php
/***********
 *  ServiceTrade API Integration 
 *
 *  Abstracts the ServiceTrade AccessPoint for TimeClock events.
 *    Currently provides the ability to retrieve a list of all "open" clock events
 *    for the currently logged in user.
 *
 *    Organization:
 *        dfreshnet
 *    Authors:
 *        Matthew Jones
 *        Robin Brandt
 *        Douglas Brandstetter
 *
 *    Copyright 2016
 *
 ***********/

class TimeClock extends Executor
{
/* Private Member Functions */
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
  
/* Public Member Functions */
  public function get_open_clock_events()
  {
    $REQUEST = new GetRequest( '/clock', array('userId'=>$_SESSION['API_USER_ID'],'openClockEvents'=>1) );
    return $this->save_response( $REQUEST->get_RESPONSE() );
  }
}

?>