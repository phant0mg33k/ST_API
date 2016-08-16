<?php
/* ServiceTrade API
 *
 * Asset ACCESSPOINT for Asset Inspector.
 *
 *  Provides the ability to interact with a single asset on ServiceTrade's system.
 *    Currently the asset executor does not have all editing function built out.
 *    Therefore the accesspoint only supports a very specific subset of asset functions.
 *
 *
 *    You can submit a GET request to this endpoint to retrieve a single asset by it's "assetId"
 *      TODO: Implement a route to return all assets from a specified "locationId"
 *
 *    You can submit a POST request to this endpoint to update a single asset. You must specify the "assetId"
 *      The only two properties that can currently be updated are the last_insp_date and notes properties.
 *      There is a route which allows the status to be set to either "active" or "inactive"
 *
 */

require_once '../ST_API.php'; // Require ST_API library

SECURITY_ENSURE_AUTHENTICATED();

if ( $_SERVER['REQUEST_METHOD'] === "GET" )
{
  if ( !isset($_GET['assetId']) )
  {
    send_alert_message( 'error', 'No assetId was supplied.' );
  } else {
    $Assets = new Assets();                   // New Assets Executor
    $Assets->get_by_id( $_GET['assetId'] );   // Get the Asset by it's ID.
    $RESPONSE_ASSET = $Assets->get_response();
    // Check if the asset was found.
    if ( !is_null($RESPONSE_ASSET) )
    {
      send_json_response( array('asset' => $RESPONSE_ASSET) );    // Return the Asset JSON_encoded.
    } else {
      send_alert_message( 'error', 'Asset was not found.' );
    }
  }
} elseif ( $_SERVER['REQUEST_METHOD'] === "POST" ) {
// We are trying to make modifications.
  if ( !isset($_POST['assetId']) || is_null($_POST['assetId']) )
  { // Attempted POST with no assetId or null assetId
    send_alert_message('error', 'Attempted to POST with no assetId specified.');
  } else {
    // Attempted POST, assetId is set.
    if ( isset($_POST['property']) && !is_null($_POST['property']) )
    {
      if ( $_POST['property'] === 'last_insp_date' ) {
        $Assets = new Assets();
        if ( $Assets->mark_asset_inspected($_POST['assetId']) )
        {
          send_alert_message('alert', "Asset was successfully marked as inspected.\nUpdated: {$_POST['property']}");
        } else {
          send_alert_message('error', 'Asset was not successfully marked as inspected.');
        }
      } elseif ( $_POST['property'] === 'notes' && isset( $_POST['notes'] ) ) {
        $Assets = new Assets();
        if ( $Assets->update_asset_notes( $_POST['assetId'], $_POST['notes'] ) )
        {
          send_alert_message('alert', "Asset's notes were updated successfully.");
        } else {
          send_alert_message('error', "Asset's notes were not updated.");
        }
      } else {
        send_alert_message('error', 'Requested update to property that can not currently be updated.');
      }
    } elseif ( isset($_POST['status']) && !is_null($_POST['status']) ) {
      if ( $_POST['status'] == "inactive" || $_POST['status'] == "active" )
      {
        $Assets = new Assets();
        // mark status inactive
        switch ( $_POST['status'] )
        {
          case "inactive": $didSucceed = $Assets->mark_asset_inactive($_POST['assetId']); break;
          case "active" : $didSucceed = $Assets->mark_asset_active($_POST['assetId']); break;
          default: break;
        }
        if ( $didSucceed )
        {
          send_alert_message('alert', "Asset was successfully marked as {$_POST['status']}.");
        } else {
          send_alert_message('error', "Asset was not successfully marked as {$_POST['status']}.");
        }
      } else {
        // status was not "inactive | active"
        send_alert_message('error', "Asset status was not updated. Status supplied was not 'active' or 'inactive'.");
      }
    } else {
      send_alert_message('error', 'There was no property or status specified.');
    }
  }
}
?>