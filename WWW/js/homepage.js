
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

function display_alert( alertType, alertMsg, dismissable=true)
{

	/* TODO: Display dismissable alert on the top of the page.
	 * 			alertType should be "Warning, Danger, Success, Info"
	 *			alertMsg is a string to be placed inside the dismissable alert.
	 */

	var messageType = "error";
	if ( alertType == "alert" )
	{
		messageType = "alert";
	}

	if ( dismissable == true )
	{

	} else {
		$("<div></div>").addClass("alert alert-danger").attr('role', 'alert').text( alertMsg ).prepend( $("<strong></strong>").text( messageType+": ") )
	}

}

function inspectAssetButton( event )
{
	this_button = $(this);
	var ASSET_ID = $(this).attr('asset-id');

	// additional params based on the data target of the button that was selected.
	var DATA_TARGET = $(this).attr('data-target');

	var params = "assetId="+ASSET_ID+"&property="+DATA_TARGET;
	var REQ_URL = "/php/accesspoints/asset.php";

	$.post(REQ_URL, params, function( data, textStatus, jqXHR )
	{
		data = $.parseJSON(data);
		if ( data['alert'] )
		{
			alert( data['alert'] );
			this_button.addClass('btn-success').removeClass('btn-danger').text('Inspected');
		} else {
			alert( data['error'] );
		}
	});
}

/* This function takes the Appointment Object and will construct a content block out of the assets it contains.
 *  Currently, it can contain a 1 Asset to 1 ServiceRequest ratio or a 1 ServiceRequest to Many "ASSETS".
 *		In the case of a Single Asset, they will be itemized inside of a single Service Request.
 *		When a location is given as the Asset. The LocationID for the appointment will be used to retrieve a list of all assets.
 *		This list of Assets is returned inside the ServiceRequest object as "ASSETS" as opposed to the singular form, "asset".
 */
function buildAssetsCB( asset )
{
	var this_asset = $("<div></div>").addClass('well asset-list-item');
	// JavaScript works in Miliseconds. Unix time is in Seconds.
	// add additional inspection dates here....


	var filtered_properties = [ "" ];
	var date_properties = [ "last_insp_date", "last_6_year_test_date", "last_12_year_test_date", "manufacture_date", "6_year_test_date", "12_year_test_date" ];

	// Pull
	this_asset.append( $("<p></p>").text( "Asset Name: " + asset['name'] ) );
	this_asset.append( $("<p></p>").text( "Asset ID: " + asset['id'] ) );

	for ( var propName in asset['properties'] )
	{
		if ( filtered_properties.includes( propName ) )
		{ // skipping values we do not want to display
			continue;
		} else if ( date_properties.includes( propName ) ) {
			// We are displaying a date.
			var temp_date = new Date( asset['properties'][propName] * 1000);
			this_asset.append( $("<p></p>").addClass('asset-list-item-property date-time').text( propName+": " + temp_date.toUTCString() ) );
			continue;
		}
		// append the PropertyName: PropteryValue to the asset-list-item
		this_asset.append( $("<p></p>").addClass('asset-list-item-property').text( propName+": " + asset['properties'][propName] ) );
	}

	// Buttons to mark assets inspected.
	var button_div = $( "<div></div>" ).addClass('btn-group btn-group-justified');

	button_div.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'last_insp_date').attr("asset-id", asset['id']).text("Mark Inspected").on('click', inspectAssetButton)) );
	button_div.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'last_6_year_test_date').attr("asset-id", asset['id']).text("Perform 6 year test").on('click', inspectAssetButton)) );
	button_div.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'last_12_year_test_date').attr("asset-id", asset['id']).text("Perform 12 year test").on('click', inspectAssetButton)) );

	this_asset.append( button_div );

	console.log(asset);

	return this_asset;
}

/* Sends AJAX request to get Appointments JSON. Loops through each appointment and
 * Call the "buildAppointmentCB" to construct the content block.
 * And adds the click handlers to the "Open Appointment Toggle"
 */
function startup()
{
	$.ajax({
		type: "GET",
		url: "/php/accesspoints/appointment.php",
		beforeSend: function() {
			$('body').addClass('loading');
		},
		complete: function() {
			$('body').removeClass('loading');
		},
		success: function( data, textStatus, jqXHR ) {

			var content_div = $('#content');

			data = $.parseJSON(data);

			// Check that the Appointments endpoint did not return an error JSON object.
			if ( data['error'] )
			{
				content_div.append( $("<div></div>").addClass("alert alert-danger").attr('role', 'alert').text( data['error'] ).prepend( $("<strong></strong>").text("Error: ") ) );
			} else {

				/*	TODO: Parse JSON from backend and display Appointment Information
				*			Display list of filterable assets.
				*
				*/

				var asset_list = $("<div></div>").attr('id', 'asset_list');

				data[0]['serviceRequests'][0]['ASSETS'].forEach(function(item, num){
					asset_list.append( buildAssetsCB( item ) );
					LIST_OF_ASSETS.push(item);
				});

				content_div.append(asset_list);
			}

			$('#asset_list').searchable({
				searchField: '#searchBox',
				selector: '.asset-list-item',
				childSelector: 'p',
				show: function ( elem ) {
					elem.slideDown(100);
				},
				hide: function ( elem ) {
					elem.slideUp(100);
				}
			});
		}
	});
}

/* Begin Control Flow */
var LIST_OF_ASSETS = [];
$(document).on({
	ready: function() {
		startup();
	}
});