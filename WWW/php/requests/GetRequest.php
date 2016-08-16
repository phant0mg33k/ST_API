<?php

class GetRequest extends HttpRequest
{
	public function __construct( $URL, $PARAMS=null )
	{
		parent::__construct( $URL, $PARAMS );
		$this->REQUEST_HEADERS = "Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\nAccept-language:en\r\n";

		$CONTEXT_OPTIONS = array(
			'http' => array(
				'method' => 'GET',
				'header' => $this->REQUEST_HEADERS
			)
		);
		
		if ( isset($this->REQUEST_PARAMS) )
			$this->REQUEST_URL .= '?'.http_build_query($this->REQUEST_PARAMS);


		$CONTEXT = stream_context_create($CONTEXT_OPTIONS);
		$this->RESPONSE = json_decode( @file_get_contents( $this->REQUEST_URL, false, $CONTEXT ), true );
		
		if ( isset( $http_response_header ) && is_array( $http_response_header ) )
		{
			$this->RESPONSE_HEADER = $http_response_header;	
		} else {
			die('No Response or Invalid Response Received');
		}
	}
}
?>