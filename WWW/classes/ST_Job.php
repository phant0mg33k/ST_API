<?php
/**
* Job
* (int) ID 			: ID of the Job
* (string) Name 	: Name of the Job
* (string) URI 		: Resource Identifier of the Job
* (int) Number 		: External job identifier
* (string) Type 	: One of:
			unknown, repair, construction, upgrade, service_call, urgent_service_call, priority_service_call, emergency_service_call, cleaning, inspection, survey, preventative_maintenance, delivery, sales, installation
*/
class Job
{
	public $properties = array(
		'uri' => null,
		'id' => null,
		'type' => null,
		'status' => null,
		'number' => null,
		'customerPo' => null,
		'visibility' => null,
		'description' => null,
		'scheduledDate' => null,
		'estimatedPrice' => null,
		'latestClockIn' => null,
		'ivrOpen' => null,
		'ivrActivity' => null,
		'serviceLine' => null,
		'currentAppointment' => null,
		'deficienciesFound' => null,
		'otherTradeDeficienciesFound' => null,
		'redsTagFound' => null,
		'vendor' => null,
		'customer' => null,
		'location' => null,
		'owner' => null,
		'notes' => null,
		'serviceRequests' => null,
		'offices' => null,
		'tags' => null,
		'externalIds' => null,
		'created' => null,
		'updated' => null
	);
	
	
	public function __construct( $JOB )
	{
		foreach ( $this->properties as $key => $value )
		{
			if ( isset($JOB->$key) )
			{
				if ( $key == "currentAppointment" )
				{
					$this->properties[$key] = new Appointment( $JOB->$key->id, $JOB->$key->name, $JOB->$key->uri );
				} else {
					$this->properties[$key] = $JOB->$key;
				}
			}
		}
	}

	public function __toString()
	{
		$return_value = "";

		$return_value .= "ID: ". $this->properties['id'];

		return $return_value;
	}

	public function print_all()
	{
		print_r($this->properties);
	}

}
?>