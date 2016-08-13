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
/* Public Member Functions */
  public function get_open_clock_events()
  {
    $REQUEST = new GetRequest( '/clock', array('userId'=>$_SESSION['API_USER_ID'],'openClockEvents'=>1) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['events'] );
  }
}

?>