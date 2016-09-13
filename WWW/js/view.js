/* Builds a bootstrap alert div.
 * 
 *  You can specify the alert type as either Error (danger), success (sucess), or it will default to info
 *  You can also specify if the alert should contain a close button, (Dismissable)
 */
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

/* Builds a <li> for an asset-property-list-item
 */
function buildPropertyLI( LABEL, TEXT )
{
  return $("<li></li>").addClass("")
    .append( $("<span></span>").addClass("asset-property-list-item-label").text( LABEL + ": " ) )
    .append( $("<span></span>").addClass("asset-property-list-item-text").text( TEXT ) );
}

/* This function accepts the "Asset" and constructs an "asset-list-item" out of it.
 *  It will loop through the properties of the asset and include them on the page for searching.
 */
function buildAssetsCB( asset )
{
  var this_asset = $("<div></div>").addClass('panel asset-list-item');

/* DETERMINE THE COLOR THE PANEL BASED ON REASONS */
    var right_now = new Date();

    if ( (asset['properties']['12_year_test_date']*1000) < right_now.getTime() )
    {
      this_asset.addClass( "panel-danger" );
    } else if ( (asset['properties']['6_year_test_date']*1000) < right_now.getTime() ) {
      this_asset.addClass( "panel-out6yr" );
    } else {
      this_asset.addClass( "panel-success" );
    }

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
    list_group.append( buildPropertyLI("6 year test date", get_date_string( new Date(asset['properties']['6_year_test_date']*1000) )) );
    list_group.append( buildPropertyLI("12 year test date", get_date_string( new Date(asset['properties']['12_year_test_date']*1000) )) );

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

    var last_insp_button = $("<button></button>").addClass("btn btn-success").attr('data-target', 'last_insp_date').attr("asset-id", asset['id']).text("Mark Inspected").on('click', inspectAssetButton);

    var inspection_dropdown_button = $('<button></button>').addClass('btn btn-success dropdown-toggle').attr('data-toggle', 'dropdown').attr('aria-haspopup', 'true').attr('aria-expanded', 'false');
        inspection_dropdown_button.append( $('<span></span>').addClass('caret') );

    var inspection_dropdown = $('<ul></ul>').addClass('dropdown-menu');
        inspection_dropdown.append( $('<li></li>').append( $('<a>').attr('href', '#').text('Mark 6 Year Inspection' ).attr('asset-id', asset['id']).attr('data-target', '6_year_test_date' ).on('click', inspectAssetButton) ) );
        inspection_dropdown.append( $('<li></li>').append( $('<a>').attr('href', '#').text('Mark 12 Year Inspection').attr('asset-id', asset['id']).attr('data-target', '12_year_test_date').on('click', inspectAssetButton) ) );

    var inspection_buttons = $('<div></div>').addClass('btn-group');

    inspection_buttons.append( last_insp_button );
    inspection_buttons.append( inspection_dropdown_button );
    inspection_buttons.append( inspection_dropdown );

  panel_footer.append( inspection_buttons );

  if ( asset['status'] === "active" )
  {
    panel_footer.append( $('<div></div>').addClass('btn-group').append( $("<button></button>").addClass("btn btn-default").attr('data-target', 'status').attr("asset-id", asset['id']).text("Mark Inactive").on('click', markAssetInactiveButton) ) );
  } else {
    panel_footer.append( $('<div></div>').addClass('btn-group').append( $("<button></button>").addClass("btn btn-default").attr('data-target', 'status').attr("asset-id", asset['id']).text("Mark Active"  ).on('click', markAssetActiveButton  ) ) );
  }
  

  // Append the panel sections to the panel => "this_asset"
  this_asset.append( panel_heading );
  this_asset.append( panel_body    );
  this_asset.append( panel_footer  );


  // This appends the properties and other searchable asset attributes to the asset-list-item.
  var date_properties = [ "last_insp_date", "last_6_year_test_date", "last_12_year_test_date", "manufacture_date", "6_year_test_date", "12_year_test_date" ];
  this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")   .text( asset['name']   ) );
  this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")   .text( asset['id']     ) );
  this_asset.append( $("<p></p>").addClass("asset-list-item-property-hidden")   .text( asset['status'] ) );
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