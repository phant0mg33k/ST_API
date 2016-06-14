<?php
/***************
 *	ServiceTrade Request Class
 *
 *	Used to encapsulate the requests being sent to ServiceTrade.
 */

class STRequest
{

	// Request Level Parameters
	private $REQUEST_METHOD;
	private $REQUEST_HEADERS;
	private $REQUEST_PARAMS;

	// Context Options Array
	private $CONTEXT_OPTIONS;

	// Context
	private $REQUEST_CONTEXT;

	

	/***********
	* Public Constructor for Request
	*
	*/
	public function __construct()
	{
		$this->REQUEST_METHOD  = null;
		$this->REQUEST_HEADERS = null;
		$this->REQUEST_PARAMS  = null;
		$this->CONTEXT_OPTIONS = null;
		$this->REQUEST_CONTEXT = null;
	}

	public function create_context()
	{
		if ( !is_null($this->REQUEST_METHOD) || !is_null($this->REQUEST_HEADERS) || !is_null($this->REQUEST_PARAMS) )
		{
			if ( $this->REQUEST_METHOD == 'POST' )
			{
				$this->CONTEXT_OPTIONS = array(
					'http' => array(
						'method' => $this->REQUEST_METHOD,
						'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
									"Content-Length: " . strlen($this->REQUEST_PARAMS) . "\r\n",
						'content' => $this->REQUEST_PARAMS
						)
					);
			} elseif ( $this->REQUEST_METHOD == 'GET' ) {
				$this->CONTEXT_OPTIONS = array(
				'http' => array(
					'method' => $this->REQUEST_METHOD,
					'header' => $this->REQUEST_HEADERS
					)
				);
			}

			$this->REQUEST_CONTEXT = stream_context_create($this->CONTEXT_OPTIONS);
		}
	}

	public function get_RESPONSE( $REQUEST_URI )
	{
		// Local Variables
		$JSON_RESPONSE = null;

		if ( !is_null($this->REQUEST_PARAMS) )
		{
			if ( $this->REQUEST_METHOD == 'GET' )
			{
				$FILE_POINTER = fopen( $REQUEST_URI.'?'.$this->REQUEST_PARAMS, 'r', false, $this->REQUEST_CONTEXT);
			}
		} else {
			$FILE_POINTER = fopen( $REQUEST_URI, 'r', false, $this->REQUEST_CONTEXT);
		}

		if ( !$FILE_POINTER )
		{
			echo 'Failed to open file: '. $REQUEST_URI . '\n';
			log('Failed to open file: '. $REQUEST_URI . '\n');
			return 'Failed to open file';
		} else {

			// Successfully opened the URI. Pull Response and close File Pointer.
			$JSON_RESPONSE = stream_get_contents($FILE_POINTER);	
			fclose($FILE_POINTER);
		}

		if ( is_null($JSON_RESPONSE) )
		{ // Testing if we received a JSON_RESPONSE.
			echo 'Failed to Receive Response: '. $REQUEST_URI . '\n';
			log('Failed to Receive Response: '. $REQUEST_URI . '\n');
			return 'Failed to Receive Response: '. $REQUEST_URI . '\n';
		}
		
		return json_decode($JSON_RESPONSE);
	}

// Mutators functions
	public function set_REQUEST_METHOD( $METHOD )
	{ $this->REQUEST_METHOD = $METHOD; }

	public function set_REQUEST_HEADERS( $HEADERS )
	{ $this->REQUEST_HEADERS = $HEADERS; }

	public function set_REQUEST_PARAMS( $PARAMS )
	{ $this->REQUEST_PARAMS = $PARAMS; }


// Accessors
	public function get_REQUEST_METHOD()
	{ return $this->REQUEST_METHOD; }

	public function get_REQUEST_HEADERS()
	{ return $this->REQUEST_HEADERS; }

	public function get_REQUEST_PARAMS()
	{ return $this->REQUEST_PARAMS; }
}


?>