<?php

class Asset
{
	// Primitive data types
	public $id;		  // (int) Asset ID
	public $uri;	  // (string) URI
	public $name;     // (string) Instance-specific name of this asset
	public $type; 	  // (string) type of asset
	public $status;   // (string) One of 'active' or 'inactive'
	public $legacyId; // (int) No Description.
	public $display;  // (string) Human-readable type description.
	public $created;  // (int) Unix Timestamp of this record's creation time.
	public $updated;  // (int) Unix Timestamp of when this record was last updated.

	// Embeded objects and Etc.
	public $location;    // (Location) Asset Location
	public $serviceLine; // (ServiceLine) Asset service line
	public $properties;  // (object) Set of key value pairs specific to this type of asset.

	public function __construct( $ASSET )
	{
		$this->id   = intval($ASSET['id']);
		$this->uri  = $ASSET['uri'];
		$this->name = $ASSET['name'];
		$this->type = $ASSET['type'];
		$this->status = $ASSET['status'];
		$this->legacyId = intval($ASSET['legacyId']);
		$this->display = $ASSET['display'];
		$this->created = intval($ASSET['created']);
		$this->updated = intval($ASSET['updated']);

		$this->location = $ASSET['location'];
		$this->serviceLine = $ASSET['serviceLine'];
		$this->properties = $ASSET['properties'];
	}

}

?>