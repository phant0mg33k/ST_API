<?php

class PutRequest extends HttpRequest
{
	public function __construct( $URL, $PARAMS=null )
	{
		parent::__construct( $URL, $PARAMS );
		$this->REQUEST_URL = $GLOBALS['APIBASEURL'].$URL;
		$this->REQUEST_PARAMS = $PARAMS;

		$this->REQUEST_HEADERS = "Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\n".
								 "Content-type: application/json\r\n";

		$CONTEXT_OPTIONS = array(
			'http' => array(
				'method' => 'PUT',
				'header' => $this->REQUEST_HEADERS,
				'content' => $this->REQUEST_PARAMS
			)
		);

		$CONTEXT = stream_context_create($CONTEXT_OPTIONS);


		$this->RESPONSE = file_get_contents( $this->REQUEST_URL , false, $CONTEXT );
		
		if ( isset( $http_response_header ) && is_array( $http_response_header ) )
		{
			$this->RESPONSE_HEADER = $http_response_header;	
		} else {
			die('No Response or Invalid Response Received');
		}
	}
}
?>