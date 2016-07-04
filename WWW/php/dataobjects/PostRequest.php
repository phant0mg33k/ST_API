<?php

class PostRequest extends HttpRequest
{
	public function __construct( $URL, $PARAMS=null )
	{
		parent::__construct( $URL, $PARAMS );
		$this->REQUEST_URL = $URL;
		$this->REQUEST_PARAMS = json_encode($PARAMS);
		$this->REQUEST_HEADERS = "Content-Type: application/json\r\n".
								 "Content-Length: ". strlen($this->REQUEST_PARAMS) . "\r\n";
		$CONTEXT_OPTIONS = array(
			'http' => array(
				'method'  => 'POST',
				'header' => $this->REQUEST_HEADERS,
				'content' => $this->REQUEST_PARAMS
			)
		);
		$CONTEXT = stream_context_create($CONTEXT_OPTIONS);

		$this->RESPONSE = file_get_contents( $GLOBALS['APIBASEURL'].$this->REQUEST_URL, false, $CONTEXT );

		if ( isset( $http_response_header ) && is_array( $http_response_header ) )
		{
			$this->RESPONSE_HEADER = $http_response_header;	
		} else {
			die('No Response or Invalid Response Received');
		}
	}
}
?>