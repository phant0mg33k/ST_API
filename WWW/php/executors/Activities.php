<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  Activities Executor
 *
 *  The activity resource is used to retrieve lists of available permissions that can be assigned to user roles
 *
 *  Supports get all activies or single activity by "activity ID"
 *
 *  POST, PUT, & DELETE are 405 not allowed.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class Activities extends Executor
{
  /* Public Accessors */
  public function get_all()
  {
    $REQUEST = new GetRequest( '/activity' );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['activities'] );
  }
  public function get_activity( $ACTIVITY_ID )
  {
    $REQUEST = new GetRequest( "/activity/$ACTIVITY_ID" );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data'] );
  }

}
?>