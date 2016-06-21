<?php
/***********
 * ServiceTrade API Integration 
 * 
 *    Testing Job Endpoint
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

if ( session_status() == PHP_SESSION_NONE )
{
  session_start();
}

if ( !isset($_SESSION['API_CURRENT_AUTH']) || !$_SESSION['API_CURRENT_AUTH'] )
{
  header("location:/login.php");
  exit;
}

require_once './_templates/_header.php';

require_once './funcs.php';
require_once './classes/STClasses.php';
require_once './classes/ST_Job.php';


if ( !isset($_SESSION['API_CURRENT_AUTH_TOKEN']) )
{

  header("location:/login.php");
  exit;

}

$DECODED_RESPONSE = null;

  // checking if API_CURRENT_AUTH is set then checking that it is set to True.
if ( isset($_SESSION['API_CURRENT_AUTH']) && $_SESSION['API_CURRENT_AUTH'] )
{

  $data_opts = array ( 'status' => 'scheduled' );
  $data_opts = http_build_query($data_opts);

  $STRequest = new STRequest();
  $STRequest->set_REQUEST_METHOD('GET');
  $STRequest->set_REQUEST_HEADERS("Accept-language:en\r\n"."Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\n");
  $STRequest->set_REQUEST_PARAMS($data_opts);
  $STRequest->create_context();
  $DECODED_RESPONSE = $STRequest->get_RESPONSE($API_BASE_URL.'job/');

}

foreach ( $DECODED_RESPONSE->data->jobs as $JOB )
{
  $JOB_OBJ = new Job( $JOB );
  echo $JOB_OBJ;
  echo '<br />';
}

  require_once './_templates/_header.php';
?>
