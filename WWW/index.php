<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Hompage for the site.
 * 
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

require_once './php/ST_API.php'; // Require our library

if ( // Make sure we are logged in.
	!isset( $_SESSION['API_CURRENT_AUTH'] ) || 
	!isset( $_SESSION['API_CURRENT_AUTH_TOKEN'] ) ||
	!$_SESSION['API_CURRENT_AUTH'] 
	) { header("location:/login.php"); exit; }

// Page Display Variables.
$PAGE['TITLE'] = 'Home Page';
$PAGE['CSS'] = array('bootstrap', 'homepage');
$PAGE['JS'] = array('jquery', 'bootstrap', '_homepage', 'homepage');

require_once './partials/_header.php'; // Require the _header partial.
?>

<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Asset Inspector</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="#">Homepage</a></li>
				<li><a href="/logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="viewbox">
	<div class="leftpane">
		<div class="container" id="content"></div><!--/#content -->
	</div><!--/.leftpane -->
	<div class="rightpane">
		<div class="container" id="appointment_box">
			<div id="asset_list"></div>
		</div><!--/#appointment_box -->
	</div><!--/.rightpane -->
</div><!--/.viewbox -->

<div class="modal" id="loading"><p class="loading-message">Loading... Please Wait.</p></div><!--/#loading -->

<?php
require_once './partials/_footer.php';
?>