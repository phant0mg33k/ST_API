
/***********
 * ServiceTrade API Integration 
 * 
 *
 * Javascript for the Homepage. 
 * Documentation is currently very sparse as this specific area is under heavy construction.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

/* Helper function to retrieve an appointment from the list of appointments by its ID.
 */
function findAppointmentById( ID )
{
	var appointment_found = null; // Return Null if appointment not found or list of appointments is empty.
	if ( appointments.length > 0 )
	{ // Check appointments is not empty.
		appointments.forEach( function ( appointment ) { // Unfortunately we have to throw an exception to break the loop. This might be important later.
			if ( appointment['id'] == ID ) 
			{ // Check against appointment ID.
				appointment_found = appointment; // Return appointment object
			}
		});
	}
	return appointment_found;
}

/* Click handler for "Appointment Open Toggle"
 */
function openToggleHandler ( event )
{
	// Paste Asset Data in asset_list in just the biggest nastiest function call so far.
	var asset_list = $('#asset_list');
	asset_list.empty();
	asset_list.append( buildAssetsCB( findAppointmentById( $(this).attr('data-appointment-id') ) ) );

	// Scroll window to the top and slide viewbox left
	$(window).scrollTop(0);
	$('.viewbox').addClass('slide-left');
}

function closeToggleHandler( event )
{
	// Remove asset list, close button, and remove the slide left class.
	$('.viewbox').removeClass('slide-left');
	$('#asset_list').empty();
}

/* Sends AJAX request to get Appointments JSON. Loops through each appointment and
 * Call the "buildAppointmentCB" to construct the content block.
 * And adds the click handlers to the "Open Appointment Toggle"
 */
function startup()
{
	$.ajax({
		url: "/php/accesspoints/appointment.php",
		success: function(data) {

			var content_div = $('#content');

			data = $.parseJSON(data);

			// Check that the Appointments endpoint did not return an error JSON object.
			if ( data['error'] )
			{
				content_div.append( $("<h3></h3>").addClass("text-center").text( data['error'] ) );
			} else {

				$.each( data, function( number, val ) {
					content_div.append(
						buildAppointmentCB( number, val )
					);
					appointments.push(val);
				});
			}
		}
	});
}

/* Begin Control Flow */
var body = $("body");
var appointments = [];

$(document).on({
    ajaxStart: function() { body.addClass("loading"); },
	ajaxStop: function() { body.removeClass("loading"); },
	ready: function() {
		startup();
	}
});