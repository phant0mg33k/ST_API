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


if ( !isset($_SESSION['API_CURRENT_AUTH_TOKEN']) )
{

  header("location:/login.php");
  exit;

}

$DECODED_RESPONSE = null;

  // checking if API_CURRENT_AUTH is set then checking that it is set to True.
if ( isset($_SESSION['API_CURRENT_AUTH']) && $_SESSION['API_CURRENT_AUTH'] )
{

  $data_opts = array (  );
  $data_opts = http_build_query($data_opts);

  $STRequest = new STRequest();
  $STRequest->set_REQUEST_METHOD('GET');
  $STRequest->set_REQUEST_HEADERS("Accept-language:en\r\n"."Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\n");
  $STRequest->set_REQUEST_PARAMS($data_opts);
  $STRequest->create_context();
  $DECODED_RESPONSE = $STRequest->get_RESPONSE($API_BASE_URL.'job');

}
// If we have successfully logged in and received a response then $DECODED_RESPONSE should not be null.

?>

  <div class="container">
    <div class="well">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Job ID</th>
            <th>Job Status</th>
            <th>Job Type</th>
            <th>Scheduled Date</th>
          </tr>
        </thead>
        <tbody>
<?php
if ( !is_null($DECODED_RESPONSE) )
{
  foreach ( $DECODED_RESPONSE->data->jobs as $JOB ) 
  {

    $JOB_CUSTOMER   = new Company( $JOB->customer->id, $JOB->customer->name, $JOB->customer->uri );
    $JOB_OWNER    = new User( $JOB->owner );

?>
          <tr>
            <td><?php echo htmlentities($JOB_CUSTOMER->name); ?></td>
            <td><?php echo htmlentities($JOB->id); ?></td>
            <td><?php echo htmlentities($JOB->status); ?></td>
            <td><?php echo htmlentities($JOB->type); ?></td>
            <td><?php echo date('M/d/Y', $JOB->scheduledDate); ?></td>
          </tr>
          <tr>
            <td colspan='5'><?php echo $JOB_OWNER; ?></td>
          </tr>
<?php /*
          <tr>
            <td colspan='5'><?php echo htmlentities(var_dump($JOB)); ?></td>
          </tr>
 */ ?>
<?php
  }
}
?>
        </tbody>
      </table>
    </div>
  </div>

<?php
  require_once './_templates/_header.php';
?>
