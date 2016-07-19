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

SECURITY_ENSURE_AUTHENTICATED();

// Page Display Variables.
$PAGE['TITLE'] = 'Home Page';
$PAGE['CSS'] = array('bootstrap', 'homepage');
$PAGE['JS'] = array('jquery', 'bootstrap', '_homepage', 'homepage');

require_once './partials/_header.php'; // Require the _header partial.

require_once './partials/_navbar.php'; // Require the _navbar partial.

?>

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