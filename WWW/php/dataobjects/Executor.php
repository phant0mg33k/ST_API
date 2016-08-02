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
  /* PUBLIC DATA MEMBERS */
  public $RESPONSE;

  /* PUBLIC MEMBER FUNCTIONS */
  public function __construct() { $this->RESPONSE = null; }
}
?>