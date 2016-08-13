<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  Locations Executor
 *
 *  The location resource is used to interact with locations.
 *
 *  Supports getting locations and modifying a single location.
 *
 *    LIMITS default=10 maximum=5000
 *
 *  GET, PUT, and DELETE (API Says POST will 400 but their documentation is shoddy.)
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

class Locations extends Executor
{
  /* Public Accessors */
  public function get_all( $LIMIT=5000, $PAGE=1 )
  {
    $REQUEST = new GetRequest( '/location', array( 'limit' => $LIMIT, 'page' => $PAGE ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['locations'] );
  }
  public function get_all_customers( $LIMIT=5000, $PAGE=1 )
  {
    $REQUEST = new GetRequest( '/location', array( 'isCustomer'=>true, 'limit' => $LIMIT, 'page' => $PAGE ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['locations'] );
  }
  public function get_all_vendors( $LIMIT=5000, $PAGE=1 )
  {
    $REQUEST = new GetRequest( '/location', array( 'isVendor'=>true, 'isCustomer'=>false, 'limit' => $LIMIT, 'page' => $PAGE ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['locations'] );
  }


  public function get_all_by_name( $NAME, $LIMIT=50, $PAGE=1 )
  {
    // NAME must be in the Location Name or the Store Number
    $REQUEST = new GetRequest( '/location', array( 'name' => $NAME, 'limit' => $LIMIT, 'page' => $PAGE ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['locations'] ); 
  }

  public function get_all_by_company_id( $COMPANY_ID, $LIMIT=50, $PAGE=1 )
  {
    $REQUEST = new GetRequest( '/location', array( 'companyId' => $COMPANY_ID, 'limit' => $LIMIT, 'page' => $PAGE ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data']['locations'] ); 
  }

  public function get_by_id( $LOCATION_ID )
  {
    $REQUEST = new GetRequest( "/location/$LOCATION_ID");
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data'] );
  }


  /* Experimental function to expose PARAMS to caller
   *
   *  This would allow the caller to specify the mix-match of params they want to query.
   */
  public function get_EXPERIMENTAL( $PARAMS )
  {
    $REQUEST = new GetRequest( "/location", $PARAMS);
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE['data'] );
  }

}
?>