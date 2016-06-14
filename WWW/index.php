<?php
/* Prototype for Interfacing with ServiceTrade
 *
 *
 */

// Begin execution flow.
if ( session_status() == PHP_SESSION_NONE )
{
    session_start();
}

require_once './apivars.php';
require_once './funcs.php';
require_once './classes/STClasses.php';
require_once './classes/STRequest.php';

if ( !isset($_SESSION['API_CURRENT_AUTH_TOKEN']) ) {

	// We will change this to be part of a login script.
	$data = array( 'username' => $API_USERNAME, 'password' => $API_PASSWORD );
	$data = http_build_query($data);

	$context_options = array(
	'http' => array(
		'method' => 'POST',
		'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
					"Content-Length: " . strlen($data) . "\r\n",
		'content' => $data
		)
	);

	$context = stream_context_create($context_options);

	try {

		$fp = fopen( $API_BASE_URL.'auth', 'r', false, $context );
		// Login Submitted
		if ( !$fp )
		{
			throw new Exception('Failed to open File Pointer');
		}

		// Retrieve JSON response from server
		$JSON_response = stream_get_contents($fp);

		// Decode JSON object into PHP array
		$DECODED_RESPONSE = json_decode($JSON_response);

		$isAuthenticated = $DECODED_RESPONSE->data->authenticated;
		$authToken = $DECODED_RESPONSE->data->authToken;


		$API_USER = new User( $response->data->user );

		$user = $DECODED_RESPONSE->data->user->name;

		if ( $isAuthenticated )
		{ // Successful Authentication
			fclose($fp);
			$_SESSION['API_CURRENT_AUTH'] = true;
			$_SESSION['API_CURRENT_AUTH_USER'] = $user;
			$_SESSION['API_CURRENT_AUTH_TOKEN'] = $authToken;
		} else {
			var_dump($JSON_response);
		}
	} catch ( Exception $e ) {
		echo $e->getMessage();
	}
	// End Authentication

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

<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width">
	<meta charset="utf-8">

	<title>Service Trade API Prototype</title>

	<link rel="stylesheet" href="./css/style.css">

	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>

</head>
<body>

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

		$JOB_CUSTOMER 	= new Company( $JOB->customer->id, $JOB->customer->name, $JOB->customer->uri );
		$JOB_OWNER 		= new User( $JOB->owner );

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

</body>
</html>
