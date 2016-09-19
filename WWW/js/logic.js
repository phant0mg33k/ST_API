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

/* Ignore Submit
 *   Ignores the enter key and prevents form submission on the search form.
 */
function ignoreSubmit( e )
{
  if ( e.keyCode == 13)
  {
    e.preventDefault();
    return false;
  }
}

/* BEGIN APP LOGIC FUNCTIONS */

/* Update Site_Location
 *   Allows technician to submit updated Site Location.
 */
function updateSiteLocation( event )
{
  var REQ_OBJ = clickHandler( $(this) );

  var new_site_location = window.prompt('What is the site location?');
  if ( new_site_location !== null && '' !== new_site_location.trim() )
  {
    new_site_location = new_site_location.trim();
    
    var params = 'assetId='+REQ_OBJ['ASSET_ID']+"&property="+REQ_OBJ['DATA_TARGET']+"&location_in_site="+new_site_location;
    sendRequest( params );
  } else {
    $('.top-right').notify({
      fadeOut: { enabled: true, delay: 3000 },
      type: 'danger',
      message: { text: 'Failed to change asset\'s location_in_site.' }
    }).show();
  }
}

/* Capture Notes
 *    Used to ensure that notes are captured to perform a certain action
 */
function captureNotes( REQ_OBJ )
{
  var notes = window.prompt('Please append notes for changing the status.');
  if ( notes === null )
  {
    // Cancel button was clicked.
    return false;
  }

  notes = notes.trim();

  if ( notes !== '' )
  {
    // old_notes is the original notes contained in the value of the searchable notes "p"
    var old_notes = $(REQ_OBJ['button']).parents('.asset-list-item').children('p[data-propname=notes]').attr('data-value');
    if ( old_notes !== '' )
      old_notes += "\n";

    var params = "assetId="+REQ_OBJ['ASSET_ID']+"&property=notes&notes="+ old_notes + notes;
    sendRequest( params );
    return true;
  } else {
    $('.top-right').notify({
      fadeOut: { enabled: true, delay: 3000 },
      type: 'danger',
      message: { text: 'You must enter notes to update an asset\'s status.' }
    }).show();
    return false;
  }
}

/* Change Asset Status
 *   Changing the status of an asset requires an amendment to the Notes field.
 */
function markAssetInactiveButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  if ( captureNotes( REQ_OBJ ) )
  {
    var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=inactive";
    sendRequest( params );
  } else {
    $('.top-right').notify({
      fadeOut: { enabled: true, delay: 3000 },
      type: 'danger',
      message: { text: 'Failed to change asset status.' }
    }).show();
  }
}
function markAssetActiveButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  if ( captureNotes( REQ_OBJ ) )
  {
    var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=active";
    sendRequest( params );
  } else {
    $('.top-right').notify({
      fadeOut: { enabled: true, delay: 3000 },
      type: 'danger',
      message: { text: 'Failed to change asset status.' }
    }).show();
  }
}

/* Inspect Asset Buttons
 *   Allows technician to update the "Last Inspection", "6 Year Test", and "12 Year Test" date properties
 */
function inspectAssetButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  var params = "assetId="+REQ_OBJ['ASSET_ID']+"&property="+REQ_OBJ['DATA_TARGET'];
  sendRequest( params );
}

/* Update Notes Button
 *   Allows technician to submit updated notes field.
 */
function updateNotesButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  var params = "assetId="+REQ_OBJ['ASSET_ID']+"&property="+REQ_OBJ['DATA_TARGET']+"&notes="+$('#input_notes-'+REQ_OBJ['ASSET_ID']).val();
  sendRequest( params );
}

/* Click Handler
 *   This function returns an object containing the data required to perform a sendRequest()
 */
function clickHandler( button )
{
  return {
    button: button,
    ASSET_ID: button.attr('asset-id'),
    DATA_TARGET: button.attr('data-target')
  };
}

/* Send Request
 */
function sendRequest( params )
{
  $.post( "/php/accesspoints/asset.php", params, function( data, textStatus, jqXHR ) {
    data = $.parseJSON(data);
    if ( data['alert'] )
    {
       $('.top-right').notify({
          fadeOut: { enabled: true, delay: 3000 },
          message: { text: data['alert'] }
        }).show();
      return true;
    } else {
      $('.top-right').notify({
          fadeOut: { enabled: true, delay: 3000 },
          type: 'danger',
          message: { text: data['error'] }
        }).show();
      return false;
    }
  });
}


/* Init Homepage
 *   This function is called after the Document Ready event is fired and the initial $.get() request is made.
 *   This is the success handler.
 *
 *  This function will detect an error and display the error message.
 *  This function will construct a list of assets and append them to the homepage.
 *    It will then initialize the searchable plugin and define the show, hide, and onSearchEmpty functions. 
 */
function initHomepage( data, textStatus, jqXHR )
{
  data = $.parseJSON( data );
  if ( data['error'] )
  {
    $('.top-right').notify({
      type: 'danger',
      fadeOut: { enabled: true, delay: 3000 },
      message: { text: data['error'] }
    }).show();
    $('#searchBox_Form').hide();
    body.addClass('has-error').removeClass('loading');
  } else {

    window.APPT_LOCATION_ID = data[0]['location']['id'];

    drawAssetList( null );
  }
}

function initSearchPlugin()
{
  $('#asset_list').searchable({
    selector: '.asset-list-item',
    childSelector: 'p',
    searchField: '#searchBox',
    show: function ( elem ) {
      elem.parent().slideDown(100);
    },
    hide: function ( elem ) {
      elem.parent().slideUp(100);
    },
    onSearchEmpty: function( elem ) {
      elem.children().slideDown( 100 );
    }
  });
}

function refreshAssets()
{

  $('.top-right').notify({
    type: 'info',
    fadeOut: { enabled: true, delay: 3000 },
    message: { text: 'Refreshing Asset List' }
  }).show();
  drawAssetList( true );
}

function drawAssetList( refresh )
{
  if ( $('#asset_list').length > 0 )
  {
    // Animating the asset_list with a slideUp.
    var asset_list = $('#asset_list').slideUp( 400 );
  } else {
    // Create a new Asset_list
    var asset_list = $("<div></div>").attr('id', 'asset_list').addClass("row");
  }

  $.get("/php/accesspoints/asset.php",
    {
      'locationId': window.APPT_LOCATION_ID
    },
    function ( data, textStatus, jqXHR ) {
      data = $.parseJSON(data);

      // Clear out the asset_list before adding.
      asset_list.empty();
      // For each Asset append an AssetCB to the new asset_list.
      $.each( data['assets'], function( num, item ){
        asset_list.append( buildAssetsCB( item ) );
      });

      $('#content').append(asset_list);
      initSearchPlugin();
      asset_list.slideUp(0); // Making sure we are SlidUp for slide down later.

      if ( body.hasClass('loading') )
      {
        body.removeClass('loading');
      }
      if ( refresh == true )
      {
        $('.top-right').notify({
          fadeOut: { enabled: true, delay: 3000 },
          message: { text: 'Successfully Refreshed Asset List' }
        }).show();
      }
      asset_list.slideDown( 400 );
    });
}

function flipTag( elem )
{
  return elem.toggleClass('flipped');
}