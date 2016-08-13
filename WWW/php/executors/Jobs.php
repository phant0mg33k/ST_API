<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  Jobs Executor
 *  UNDER HEAVY DEVELOPMENT
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class Jobs extends Executor
{

/* Public Member Functions. Provide an interface to retrieve Job objects.
 *
 *    Currently you can ask for:
 *      1) All jobs
 *      2) All jobs with a status of scheduled which are assigned to the signed in technician.
 */
  public function get_all()
  {
    $REQUEST = new GetRequest( '/job' );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['jobs'] );
  }
  public function get_all_by_tech_id( $ID )
  {
    $REQUEST = new GetRequest( '/job', array( 'status' => 'scheduled', 'ownerId' => $ID, 'longForm' => true ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['jobs'] );
  }
}


?>