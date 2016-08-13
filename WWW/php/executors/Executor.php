<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  Executor base class.
 *  UNDER HEAVY DEVELOPMENT
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

abstract class Executor
{
  /* PROTECTED DATA MEMBERS */
  protected $RESPONSE;


  /* PUBLIC MEMBER FUNCTIONS */
  // Constructor
  public function __construct() { $this->RESPONSE = null; }

  // Accessors
  public function get_response() { return $this->RESPONSE; }
  
  // Mutators
  /* save_response( array )
   * Currently, it expects the response to be json_decoded from the calling function.
   */
  public function save_response( $RESPONSE )
  {
    if ( !is_null( $RESPONSE ) )
    {
      $this->RESPONSE = $RESPONSE;
      return true;
    } else {
      $this->RESPONSE = null;
      return false;
    }
  }

}
?>