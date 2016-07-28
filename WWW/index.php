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
$PAGE['JS'] = array('jquery', 'bootstrap', 'homepage', 'jquery.searchable-1.0.0.min');

require_once './partials/_header.php'; // Require the _header partial.

require_once './partials/_navbar.php'; // Require the _navbar partial.

?>

<div class="container">
	<div class="well" id="search-box">
		<input type="search" id="searchBox" value="" class="form-control text-center"
			placeholder="Filter by any property">
	</div><!--/#search-box-->
</div><!--/.container-->

<div class="container" id="content"></div><!--/#content-->

<div class="modal" id="loading"><p class="loading-message">Loading... Please Wait.</p></div><!--/#loading -->

<?php
require_once './partials/_footer.php';
?>