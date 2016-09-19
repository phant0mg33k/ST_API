
/***********
 * ServiceTrade API Integration 
 * 
 *
 * Javascript for the Homepage. 
 * Documentation is currently very sparse as this specific area is under heavy construction.
 *
 *      Organization:
 *        dfreshnet
 *    Authors:
 *        Matthew Jones
 *        Robin Brandt
 *        Douglas Brandstetter
 *
 *    Copyright 2016
 *
 ***********/

/* Begin Control Flow */

// One call to jQuery for body object. One instance.
var body = $('body');
// Add the loading class to the body which will hide it and show the loading screen.
body.addClass('loading');

// Enable tooltips.
$('[data-toggle="tooltip"]').tooltip();

// Include required scripts.
$.ajaxSetup({ cache: true });
$.getScript('/js/jquery.searchable-1.1.0.min.js');
$.getScript('/js/view.js');
$.getScript('/js/logic.js', function( data, textStatus, jqXHR ) {
  // Prevent Enter Key from submitting the navbar form causing a page reload.
  $('.navbar-form').on('keydown', ignoreSubmit );
  $.ajaxSetup({ cache: false }); // Disable loading appointment from Cache.
  // Perform the first Ajax to get the list of assets.
  $.get("/php/accesspoints/appointment.php", initHomepage);
});