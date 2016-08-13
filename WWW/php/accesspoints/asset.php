<?php
/* ServiceTrade API
 *
 * Asset ACCESSPOINT for Asset Inspector.
 *
 *  Purpose: 
 *
 *
 */

require_once '../ST_API.php'; // Require ST_API library

SECURITY_ENSURE_AUTHENTICATED();
/* TODO: Clean this **** Up. */


if ( $_SERVER['REQUEST_METHOD'] === "GET" )
{
  if ( !isset($_GET['assetId']) )
  {
    echo alert_message( 'error', 'No assetId was supplied.' );
  } else {
    $Assets = new Assets();           // New Assets Executor
    $Assets->get_by_id( $_GET['assetId'] );       // Get the Asset by it's ID.
    echo alert_message( 'asset', $Assets->get_response() );    // Return the Asset JSON_encoded.
  }
} elseif ( $_SERVER['REQUEST_METHOD'] === "POST" ) {
// We are trying to make modifications.
  if ( !isset($_POST['assetId']) || is_null($_POST['assetId']) )
  { // Attempted POST with no assetId or null assetId
    echo alert_message('error', 'Attempted to POST with no assetId specified.');
  } else {
    // Attempted POST, assetId is set.
    if ( isset($_POST['property']) && !is_null($_POST['property']) )
    {
      if ( $_POST['property'] === 'last_insp_date' ) {
        $Assets = new Assets();
        if ( $Assets->mark_asset_inspected($_POST['assetId']) )
        {
          echo alert_message('alert', "Asset was successfully marked as inspected.\nUpdated: {$_POST['property']}");
        } else {
          echo alert_message('error', 'Asset was not successfully marked as inspected.');
        }
      } elseif ( $_POST['property'] === 'notes' && isset( $_POST['notes'] ) ) {
        $Assets = new Assets();
        if ( $Assets->update_asset_notes( $_POST['assetId'], $_POST['notes'] ) )
        {
          echo alert_message('alert', "Asset's notes were updated successfully.");
        } else {
          echo alert_message('error', "Asset's notes were not updated.");
        }
      } else {
        echo alert_message('error', 'Requested update to property that can not currently be updated.');
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
          echo alert_message('alert', "Asset was successfully marked as {$_POST['status']}.");
        } else {
          echo alert_message('error', "Asset was not successfully marked as {$_POST['status']}.");
        }
      } else {
        // some error man... status was not "inactive | active"
        echo alert_message('error', "Asset status was not updated. Status supplied was not 'active' or 'inactive'.");
      }
    } else {
      echo alert_message('error', 'There was no property or status specified.');
    }
  }
}
?>