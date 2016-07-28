
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

function buildAlertCB( alertType, alertMsg, dismissable )
{
	var alert_div = $("<div></div>").addClass("alert").attr('role', 'alert').text( alertMsg );
	if ( alertType == "error" )
	{
		alert_div.addClass("alert-danger").prepend( $("<strong></strong>").text( "Error: ") );
	} else if ( alertType == "success" ) {
		alert_div.addClass("alert-success").prepend( $("<strong></strong>").text( "Success: ") );
	}

	if ( dismissable )
	{
		alert_div.append( $("<button></button>").addClass("close").attr('type', 'button').attr('data-dismiss', 'alert').attr('aria-label', 'Close').append( $("<span></span>").text("X") ) );
	}

	return alert_div;
}

function markAssetInactiveButton( event )
{
	var this_button = $(this);
	var ASSET_ID = this_button.attr('asset-id');

	var params = "assetId="+ASSET_ID+"&status=inactive";	
	var REQ_URL = "/php/accesspoints/asset.php";

	$.post(REQ_URL, params, function( data, textStatus, jqXHR ) {
		data = $.parseJSON(data);
		if ( data['alert'] )
		{
			$('#content').prepend( buildAlertCB('success', data['alert'], true ));
			this_button.addClass('btn-success').removeClass('btn-danger').text('Inactive');
		} else {
			alert( data['error'] );
		}
	});
}

function markAssetActiveButton( event )
{
	var this_button = $(this);
	var ASSET_ID = this_button.attr('asset-id');

	var params = "assetId="+ASSET_ID+"&status=active";
	var REQ_URL = "/php/accesspoints/asset.php";

	$.post(REQ_URL, params, function( data, textStatus, jqXHR ) {
		data = $.parseJSON(data);
		if ( data['alert'] )
		{
			$('#content').prepend( buildAlertCB('success', data['alert'], true ));
			this_button.addClass('btn-success').removeClass('btn-danger').text('Active');
		} else {
			alert( data['error'] );
		}
	});
}

function inspectAssetButton( event )
{
	var this_button = $(this);
	var ASSET_ID = this_button.attr('asset-id');

	// additional params based on the data target of the button that was selected.
	var DATA_TARGET = $(this).attr('data-target');

	var params = "assetId="+ASSET_ID+"&property="+DATA_TARGET;
	var REQ_URL = "/php/accesspoints/asset.php";

	$.post(REQ_URL, params, function( data, textStatus, jqXHR )
	{
		data = $.parseJSON(data);
		if ( data['alert'] )
		{
			$('#content').prepend( buildAlertCB('success', data['alert'], true ));
			this_button.addClass('btn-success').removeClass('btn-danger').text('Inspected');
		} else {
			alert( data['error'] );
		}
	});
}

/* This function accepts the "Asset" and constructs an "asset-list-item" out of it.
 *	It will loop through the properties of the asset and include them on the page.
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
	this_asset.append( $("<p></p>").text( "Asset Status: " + asset['status'] ) );

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
		this_asset.append( $("<p></p>").addClass('asset-list-item-property '+propName+"-class").text( propName+": " + asset['properties'][propName] ) );
	}

	this_asset.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'last_insp_date').attr("asset-id", asset['id']).text("Mark Inspected").on('click', inspectAssetButton)) );
	this_asset.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'status').attr("asset-id", asset['id']).text("Mark Inactive").on('click', markAssetInactiveButton)) );
	this_asset.append( $("<div></div>").addClass('btn-group').append( $("<button></button>").addClass("btn btn-lg btn-danger inspect-asset-btn").attr('data-target', 'status').attr("asset-id", asset['id']).text("Mark Active").on('click', markAssetActiveButton)) );

	console.log(asset);

	return this_asset;
}


/* Begin Control Flow */
var LIST_OF_ASSETS = [];

$(document).ready(function(){

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
				content_div.append( buildAlertCB( 'error', data['error'], false ) );
				$('body').addClass('has-error');
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

});