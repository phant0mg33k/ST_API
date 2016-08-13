<?php

class PostRequest extends HttpRequest
{
	public function __construct( $URL, $PARAMS=null, $AUTHENTICATED=true )
	{
		parent::__construct( $URL );
		$this->REQUEST_PARAMS = json_encode( $PARAMS );
		$this->REQUEST_HEADERS = ( ( $AUTHENTICATED ) ? "Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\n" : '' ).
														 "Content-Type: application/json\r\n".
								 						 "Content-Length: ". strlen($this->REQUEST_PARAMS) . "\r\n";

		$CONTEXT_OPTIONS = array(
			'http' => array(
				'method'  => 'POST',
				'header' => $this->REQUEST_HEADERS,
				'content' => $this->REQUEST_PARAMS
			)
		);

		$CONTEXT = stream_context_create($CONTEXT_OPTIONS);
		$this->RESPONSE = json_decode( file_get_contents( $this->REQUEST_URL, false, $CONTEXT ), true );

		if ( isset( $http_response_header ) && is_array( $http_response_header ) )
		{
			$this->RESPONSE_HEADER = $http_response_header;	
		} else {
			die('No Response or Invalid Response Received');
		}
	}
}
?>