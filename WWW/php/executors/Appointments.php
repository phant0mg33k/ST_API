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

/* PUBLIC MEMBER FUNCTIONS */
  public function get_all()
  {
    $REQUEST = new GetRequest( '/appointment', array(  ) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE );
  }
  public function get_all_by_tech_id()
  {
    $REQUEST = new GetRequest( '/appointment', array( 'techIds' => $_SESSION['API_USER_ID']) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE );
  }
  public function get_all_scheduled_by_tech_id()
  {
    $REQUEST = new GetRequest( '/appointment', array( 'status' => 'scheduled', 'techIds' => $_SESSION['API_USER_ID']) );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE ); 
  }
  public function get_by_id( $ID )
  {
    $REQUEST = new GetRequest( '/appointment/'.$ID );
    $RESPONSE = $REQUEST->get_RESPONSE();
    return $this->save_response( $RESPONSE );
  }


/* ADVANCED MEMBER FUNCTIONS (Utilize other public functions.) */
  public function get_all_clocked_in_by_tech_id()
  {
    $TimeClock = new TimeClock();
    $TimeClock->get_open_clock_events();

    $RESPONSE = json_decode($TimeClock->RESPONSE, true);
    // Might be more than one clock event. TODO: Need to loop and return more than one appointment. Multiple requests. ( Not Good. )
    if ( empty($RESPONSE) )
    {
      return json_encode(array("error"=>"You are not currently clocked in."));
    } elseif ( isset( $RESPONSE[0]['appointment']['id'] ) ) {
      return $this->get_by_id( $RESPONSE[0]['appointment']['id'] );
    } else {
      return json_encode( array("error"=>"No appointment ID was available to retrieve the list of assets.") );
    }
  }
}
?>