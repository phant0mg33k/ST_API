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
$PAGE['CSS'] = array('homepage');
$PAGE['JS'] = array('jquery.searchable-1.0.0.min', 'homepage');

require_once './partials/_header.php'; // Require the _header partial.

require_once './partials/_navbar.php'; // Require the _navbar partial.

require_once './partials/_homepage.php'; // Require the _homepage partial.

require_once './partials/_footer.php'; // Require the _footer partial.
?>