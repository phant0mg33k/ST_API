<?php

abstract class HttpRequest
{
	private $REQUEST_URL;
	private $REQUEST_HEADERS;
	private $REQUEST_PARAMS;

	public $RESPONSE_HEADER;
	public $RESPONSE;

	public function __construct( $URL, $PARAMS=null )
	{
		$this->REQUEST_URL     = $URL;
		$this->REQUEST_PARAMS  = $PARAMS;
	}

	// Getters
	public function get_REQUEST_URL() { return $this->REQUEST_URL; }
	public function get_REQUEST_HEADERS() { return $this->REQUEST_HEADERS; }
	public function get_REQUEST_PARAMS() { return $this->REQUEST_PARAMS; }
	public function get_RESPONSE() { return $this->RESPONSE; }
	public function get_RESPONSE_HEADER() { return $this->RESPONSE_HEADER; }

	private function set_REQUEST_URL( $URL ) { $this->REQUEST_URL = $URL; }
	private function set_REQUEST_HEADERS( $HEADERS ) { $this->REQUEST_HEADERS = $HEADERS; }
	private function set_REQUEST_PARAMS( $PARAMS ) { $this->REQUEST_PARAMS = $PARAMS; }
	private function set_RESPONSE( $RESPONSE ) { $this->RESPONSE = $RESPONSE; }
	private function set_RESPONSE_HEADER( $HEADER ) { $this->RESPONSE_HEADER = $HEADER; }
}
?>