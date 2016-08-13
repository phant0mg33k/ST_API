<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  User Executor
 *
 *  The user resource is used to retrieve lists of users or detailed information about a single user. Only returns active users.
 *
 *  POST, PUT, & DELETE are 405 not allowed.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class Users extends Executor
{
  /* Public Accessors */
  public function get_all()
  {
    $REQUEST = new GetRequest( '/user' );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['users'] );
  }

  public function get_all_technicians()
  {
    $REQUEST = new GetRequest( '/user', array( 'isTech' => true ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['users'] ); 
  }

  public function get_all_by_name( $NAME )
  {
    // Searches for Name, Username, Email, and Company
    $REQUEST = new GetRequest( '/user', array( 'name' => $NAME ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['users'] );  
  }

  public function get_by_id( $USER_ID )
  {
    $REQUEST = new GetRequest( "/user/$USER_ID" );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data'] );
  }

}
?>