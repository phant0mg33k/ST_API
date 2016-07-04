
/***********
 * ServiceTrade API Integration 
 * 
 *
 * Javascript for the Homepage. _Prototype_Area_
 * Documentation is currently very sparse as this specific area is under heavy construction.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

 function inspectAssetButton( event )
 {
 	this_button = $(this);
 	var ASSET_ID = $(this).prop("id");
 	this_button.addClass('btn-success');
 	this_button.removeClass('btn-danger');
 	this_button.text('Inspected...');
 	alert( "Asset ID: " + ASSET_ID );
 }

/* This function takes the Appointment Object and will construct a content block out of the assets it contains.
 *  Currently, it can contain a 1 Asset to 1 ServiceRequest ratio or a 1 ServiceRequest to Many "ASSETS".
 *		In the case of a Single Asset, they will be itemized inside of a single Service Request.
 *		When a location is given as the Asset. The LocationID for the appointment will be used to retrieve a list of all assets.
 *		This list of Assets is returned inside the ServiceRequest object as "ASSETS" as opposed to the singular form, "asset".
 */
function buildAssetsCB( APPT )
{
	var return_value = $("<div></div>");
	if ( APPT['serviceRequests'].length > 0 )
	{ 
		APPT['serviceRequests'].forEach( function ( item ) {
			if ( Array.isArray( item['ASSETS'] ) )
			{
				item['ASSETS'].forEach( function( asset ) {
					if ( asset['type'] == "location" ) {
						var this_asset = $("<div></div>").addClass('well asset-list');

							this_asset.append( $("<p></p>").text('Asset Type: ' + asset['type']) );
						return_value.append(this_asset);
					} else {
						var this_asset = $("<div></div>").addClass('well asset-list');

								// JavaScript works in Miliseconds. Unix time is in Seconds.
							var last_insp_date = new Date(asset['properties']['last_insp_date'] * 1000);

							this_asset.append( $("<p></p>").text( "Asset Name: " + asset['name'] ) );
							this_asset.append( $("<p></p>").text( "Asset ID: " + asset['id'] ) );
							this_asset.append( $("<p></p>").text( "Date last inspected: " + last_insp_date.toDateString() ) );
							this_asset.append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr("id", asset['id']).text("Mark Inspected").on('click', inspectAssetButton) );

						return_value.append(this_asset);
					}
				});
			} else {
				var this_asset = $("<div></div>").addClass('well asset-list');

					this_asset.append( $("<p></p>").text( item['asset']['name'] ) );
					this_asset.append( $("<p></p>").text( item['asset']['id'] ) );
					this_asset.append( $("<p></p>").text( item['asset']['uri'] ) );

				return_value.append(this_asset);
			}
		});
	} else {
		return_value.append( $("<div></div>").addClass('well').append( $("<p></p>").text("No Service Requests on this Appointment...") ) );
	}

	return_value.append( $("<button></button>").addClass("btn btn-primary btn-block asset-list-close-button").text("Close").on('click', closeToggleHandler) );

	return return_value;
}

/* This function takes the position in the list ( 0 based index )
 * And the JSarray of the appointment.
 *
 * It will construct a content block of HTML using the appointment and return the constructed CB.
 */
function buildAppointmentCB( number, APPT )
{
	var return_value = $("<div></div>");

		var windowStart = new Date(APPT['windowStart']*1000);
		var windowEnd   = new Date(APPT['windowEnd']*1000);

	return_value.addClass( "well appointment appointment-well-" + number );
	return_value.append( $("<h3></h3>").addClass('appointment-id').text(APPT['id']) );
	return_value.append( $("<p></p>").addClass('appointment-window-start').text( "Window Start Date: " + windowStart.toDateString() ) );
	return_value.append( $("<p></p>").addClass('appointment-window-end').text( "Window End Date: " +  windowEnd.toDateString() ) );
	return_value.append( $("<p></p>").addClass('appointment-name').text("Appointment Name: " + APPT['name']) );
	return_value.append( $("<p></p>").addClass('appointment-status').text("Status: " + APPT['status']) );
	return_value.append( $("<a></a>").addClass('open-toggle').attr('href', '#appointment'+APPT['id']).attr('role', 'button').attr('data-appointment-id', APPT['id']).append( $("<span></span>").addClass('glyphicon glyphicon-chevron-right') ).on('click', openToggleHandler) );

	return return_value;
}