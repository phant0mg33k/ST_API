<?php
/***********
 * ServiceTrade API Integration 
 * 
 *  HttpRequest base class.
 *  UNDER HEAVY DEVELOPMENT
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/

abstract class HttpRequest
{
	/* Protected Members */
	// Request
	protected $REQUEST_URL;
	protected $REQUEST_HEADERS;
	protected $REQUEST_PARAMS;
	// Response
	protected $RESPONSE_HEADER;
	protected $RESPONSE;

	public function __construct( $URL, $PARAMS=null )
	{
		$this->REQUEST_URL		= $GLOBALS['APIBASEURL'].$URL;
		$this->REQUEST_PARAMS = $PARAMS;
	}

	/* Accessors */
	// Request
	public function get_REQUEST_URL() { return $this->REQUEST_URL; }
	public function get_REQUEST_HEADERS() { return $this->REQUEST_HEADERS; }
	public function get_REQUEST_PARAMS() { return $this->REQUEST_PARAMS; }
	// Response
	public function get_RESPONSE() { return $this->RESPONSE; }
	public function get_RESPONSE_HEADER() { return $this->RESPONSE_HEADER; }

	/* Mutators */
	// Request
	public function set_REQUEST_URL( $URL ) { $this->REQUEST_URL = $URL; }
	public function set_REQUEST_HEADERS( $HEADERS ) { $this->REQUEST_HEADERS = $HEADERS; }
	public function set_REQUEST_PARAMS( $PARAMS ) { $this->REQUEST_PARAMS = $PARAMS; }
	// Response
	public function set_RESPONSE( $RESPONSE ) { $this->RESPONSE = $RESPONSE; }
	public function set_RESPONSE_HEADER( $HEADER ) { $this->RESPONSE_HEADER = $HEADER; }
}
?>