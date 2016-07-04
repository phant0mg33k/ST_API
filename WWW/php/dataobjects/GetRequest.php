<?php

class GetRequest extends HttpRequest
{
	public function __construct( $URL, $PARAMS=null )
	{
		parent::__construct( $URL, $PARAMS );
		$this->REQUEST_URL = $URL;
		$this->REQUEST_PARAMS = $PARAMS;
		$this->REQUEST_HEADERS = "Accept-language:en\r\n".
								 "Cookie: PHPSESSID={$_SESSION['API_CURRENT_AUTH_TOKEN']}\r\n";

		$CONTEXT_OPTIONS = array(
			'http' => array(
				'method' => 'GET',
				'header' => $this->REQUEST_HEADERS
			)
		);

		$CONTEXT = stream_context_create($CONTEXT_OPTIONS);
		$GET_URL = '';
		if ( isset($this->REQUEST_PARAMS) )
		{
			$GET_URL = $GLOBALS['APIBASEURL'].$this->REQUEST_URL.'?'.http_build_query($this->REQUEST_PARAMS);
		} else {
			$GET_URL = $GLOBALS['APIBASEURL'].$this->REQUEST_URL;
		}
		
		$this->RESPONSE = file_get_contents( $GET_URL, false, $CONTEXT );
		
		if ( isset( $http_response_header ) && is_array( $http_response_header ) )
		{
			$this->RESPONSE_HEADER = $http_response_header;	
		} else {
			die('No Response or Invalid Response Received');
		}
	}
}
?>