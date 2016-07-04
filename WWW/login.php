<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Login page. User's found to be unauthenticated will be forced to this login portal.
 * Requests made to this page after a user is authenticated will redirect to the root of the site.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

require_once './php/ST_API.php'; // Require our library

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) )
		$Login = new Login( $_POST['username'], $_POST['password'] ); // Attempt login with POSTed username and password

if ( isset($_SESSION['API_CURRENT_AUTH']) && $_SESSION['API_CURRENT_AUTH'] ) { header("location:/"); exit; }

// Page Display Variables.
$PAGE['TITLE'] = 'Login'; // Page Title
$PAGE['CSS'] = array('bootstrap', 'signin');
$PAGE['JS'] = array('jquery', 'bootstrap');

require_once './partials/_header.php';

?>

	<div class="container">
		<form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<h2 class="">Login</h2>
			<input class="form-control" type="text" name="username" required autofocus />
			<input class="form-control" type="password" name="password" required />
			<button class="btn btn-lg btn-primary btn-block">Sign In</button>
		</form><!--/.form-signin -->
	</div><!--/.container-->

<?php require_once './partials/_footer.php'; ?>