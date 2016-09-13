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

/* Change Asset Status
 *   Changing the status of an asset requires an amendment to the Notes field.
 */
function markAssetInactiveButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=inactive";
  sendRequest( params );
}
function markAssetActiveButton( event )
{
  var REQ_OBJ = clickHandler( $(this) );
  var params = "assetId="+REQ_OBJ['ASSET_ID']+"&status=active";
  sendRequest( params );
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
      $('#content').prepend( buildAlertCB('success', data['alert'], true ));
      return true;
    } else {
      $('#content').prepend( buildAlertCB('error', data['error'], true ));
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
    $('#content').append( buildAlertCB( 'error', data['error'], false ) );
    $('#searchBox_Form').hide();
    body.addClass('has-error').removeClass('loading');
  } else {

    var asset_list = $("<div></div>").attr('id', 'asset_list').addClass("row");

    $.each( data[0]['serviceRequests'][0]['ASSETS'], function( num, item ){
      asset_list.append( buildAssetsCB( item ) );
    });

    $('#content').append(asset_list);

    body.removeClass('loading');

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
}