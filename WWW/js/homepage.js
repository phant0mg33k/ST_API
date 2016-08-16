
/***********
 * ServiceTrade API Integration 
 * 
 *
 * Javascript for the Homepage. 
 * Documentation is currently very sparse as this specific area is under heavy construction.
 *
 *      Organization:
 * 				dfreshnet
 * 		Authors:
 *				Matthew Jones
 *				Robin Brandt
 *				Douglas Brandstetter
 *
 *		Copyright 2016
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
	} else {
		alert_div.addClass("alert-info").prepend( $("<strong></strong>").text( "Success: ") );
	}

	if ( dismissable )
	{
		alert_div.prepend( $("<button></button>").addClass("close").attr('type', 'button').attr('data-dismiss', 'alert').attr('aria-label', 'Close').append( $("<span></span>").text("\xD7") ) );
	}

	return alert_div;
}

function clickHandler( button )
{
	return {
		button: button,
		ASSET_ID: button.attr('asset-id'),
		DATA_TARGET: button.attr('data-target'),
		COMPLETE_TEXT: button.attr('data-alt-text'),
		REQ_URL: "/php/accesspoints/asset.php"
	};
}

function sendRequest( params, REQ_OBJ )
{
	$.post(REQ_OBJ['REQ_URL'], params, function( data, textStatus, jqXHR ) {
		data = $.parseJSON(data);
		if ( data['alert'] )
		{
			$('#content').prepend( buildAlertCB('success', data['alert'], true ));
			REQ_OBJ['button'].addClass('btn-success').removeClass('btn-info').removeClass('btn-danger').text( REQ_OBJ['COMPLETE_TEXT'] );
			return true;
		} else {
			$('#content').prepend( buildAlertCB('error', data['error'], true ));
			return false;
		}
	});
}

function markAssetInactiveButton( event )
{
	var REQ_OBJ = clickHandler( $(this) );
	var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=inactive";
	sendRequest( params, REQ_OBJ );
}

function markAssetActiveButton( event )
{
	var REQ_OBJ = clickHandler( $(this) );
	var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=active";
	sendRequest( params, REQ_OBJ );
}

function inspectAssetButton( event )
{
	var REQ_OBJ = clickHandler( $(this) );
	var params = "assetId="+REQ_OBJ['ASSET_ID']+"&property="+REQ_OBJ['DATA_TARGET'];
	sendRequest( params, REQ_OBJ );
}

function updateNotesButton( event )
{
	var REQ_OBJ = clickHandler( $(this) );
	var params = "assetId="+REQ_OBJ['ASSET_ID']+"&property="+REQ_OBJ['DATA_TARGET']+"&notes="+$('#input_notes-'+REQ_OBJ['ASSET_ID']).val();
	sendRequest( params, REQ_OBJ );
}

function get_date_string( date )
{

	var dayNames   = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
	var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

	var date_string = "";

	//date_string += dayNames[ date.getDay() ] + ", ";
	date_string += monthNames[ date.getMonth() ] + " ";
	date_string += date.getDate() + " ";
	date_string += date.getFullYear();

	return date_string;
}

function buildPropertyLI( LABEL, TEXT )
{
  return $("<li></li>").addClass("")
    .append( $("<span></span>").addClass("asset-property-list-item-label").text( LABEL + ": " ) )
    .append( $("<span></span>").addClass("asset-property-list-item-text").text( TEXT ) );
}

/* This function accepts the "Asset" and constructs an "asset-list-item" out of it.
 *	It will loop through the properties of the asset and include them on the page.
 */
function buildAssetsCB( asset )
{
	var this_asset = $("<div></div>").addClass('panel asset-list-item').addClass( ("active" === asset['status']) ? "panel-success": "panel-danger" );

/* Construct Panel-Heading */
	var panel_heading = $("<div></div>").addClass("panel-heading");
		panel_heading.append(
			$("<h3></h3>").addClass("panel-title").text( "Asset Name: " + asset['name'] ).append( $("<span></span>").addClass("pull-right").text("ID: " + asset['id']) )
		);

/* Construct Panel-Body */
	var panel_body = $("<div></div>").addClass("panel-body");

	var list_group = $("<ul></ul>").addClass("asset-property-list");
		list_group.append( buildPropertyLI("Site Location", asset['properties']['location_in_site']) );
		list_group.append( buildPropertyLI("Ext Number", ( asset['properties']['ext_number'] != null ) ? asset['properties']['ext_number'] : "N/A" ) );
		list_group.append( buildPropertyLI("Status", asset['status']) );
		list_group.append( buildPropertyLI("Serial", asset['properties']['serial']) );
		list_group.append( buildPropertyLI("Model", asset['properties']['model']) );
		list_group.append( buildPropertyLI("Manufacturer", asset['properties']['manufacturer']) );
		list_group.append( buildPropertyLI("Size", asset['properties']['size']) );
		list_group.append( buildPropertyLI("Ext Type", asset['properties']['extinguisher_type']) );
		list_group.append( buildPropertyLI("Last Inspected", get_date_string( new Date(asset['properties']['last_insp_date']*1000) )) );

	panel_body.append( list_group );

	var notes_form = $("<div></div>").addClass("form-group");
		notes_form.append( $("<textarea></textarea>").attr("id", "input_notes-"+asset['id']).addClass("form-control").attr("placeholder", "Notes").text( (asset['properties']['notes']) ? asset['properties']['notes'] : "" ) );

	panel_body.append( notes_form );

	panel_body.append( 
		$("<div></div>").addClass("form-group").append(
			$("<button></button>").addClass("btn btn-info btn-block").attr('asset-id', asset['id']).attr('data-target', 'notes').attr('data-alt-text', 'Notes Saved').text('Update Notes').on('click', updateNotesButton)
		)
	);


/* Construct Panel-Footer */
	var panel_footer = $("<div></div>").addClass('panel-footer text-center');

  var button_panel =  $("<div></div>").addClass('btn-group btn-group-justified');
    button_panel.append( $("<a></a>").addClass("btn btn-lg btn-danger").attr('data-target', 'last_insp_date').attr("asset-id", asset['id']).attr('data-alt-text', 'Inspected').text("Mark Inspected").on('click', inspectAssetButton) );

	if ( asset['status'] === "active" )
	{
		button_panel.append( $("<a></a>").addClass("btn btn-lg btn-danger").attr('data-target', 'status').attr("asset-id", asset['id']).attr('data-alt-text', 'Inactive').text("Mark Inactive").on('click', markAssetInactiveButton) );
	} else {
		button_panel.append( $("<a></a>").addClass("btn btn-lg btn-danger").attr('data-target', 'status').attr("asset-id", asset['id']).attr('data-alt-text', 'Active').text("Mark Active").on('click', markAssetActiveButton) );		
	}
	
  panel_footer.append( button_panel );

	// Append the panel sections to the panel => "this_asset"
	this_asset.append( panel_heading );
	this_asset.append( panel_body    );
	this_asset.append( panel_footer  );


	// This appends the properties and other searchable asset attributes to the asset-list-item.
	var date_properties = [ "last_insp_date", "last_6_year_test_date", "last_12_year_test_date", "manufacture_date", "6_year_test_date", "12_year_test_date" ];
	this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")			.text( asset['name'] ) );
	this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")				.text( asset['id'] ) );
	this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")		.text( asset['status'] ) );
	for ( var propName in asset['properties'] )
	{
		if ( date_properties.includes( propName ) )
		{
			// We are displaying a date.
			var temp_date = new Date( asset['properties'][propName] * 1000);
			this_asset.append( $("<p></p>").addClass('asset-list-item-property-hidden').text( propName+": " + get_date_string(temp_date) ) );
			continue;
		}
		// append the PropertyName: PropteryValue to the asset-list-item
		this_asset.append( $("<p></p>").addClass('asset-list-item-property-hidden').text( propName+": " + asset['properties'][propName] ) );
	}


	return $("<div></div>").addClass("col-xs-12 col-md-6").append( this_asset );
}


/* Begin Control Flow */
var LIST_OF_ASSETS = [];  // Global Variable which makes available the list of assets to the console for debugging purposes.

$(document).ready(function(){

	var body = $('body'); // One call to jQuery for body object. One instance.

	// Prevent Enter Key from submitting the navbar form causing a page reload.
	$('.navbar-form').on('keydown', function( event ) {
		if ( event.keyCode == 13)
		{
			event.preventDefault();
			return false;
		}
	});

	// Add the loading class to the body which will hide it and show the loading screen.
	body.addClass('loading');

	// Perform the first Ajax to get the list of assets.
	$.ajax({
		type: "GET",
		url: "/php/accesspoints/appointment.php",
		complete: function() {
			body.removeClass('loading');
		},
		success: function( data, textStatus, jqXHR ) {

			var content_div = $('#content');

			data = $.parseJSON(data);

			// Check that the Appointments endpoint did not return an error JSON object.
			if ( data['error'] )
			{
				content_div.append( buildAlertCB( 'error', data['error'], false ) );
				$('#searchBox_Form').hide();
				body.addClass('has-error');
			} else {

				var asset_list = $("<div></div>").attr('id', 'asset_list').addClass("row");

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