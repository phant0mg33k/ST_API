<?php

class Appointment
{
	protected $property_list = array( 
		'id' => null,
		'uri' => null,
		'name' => null,
		'status' => null,
		'windowStart' => null,
		'windowEnd' => null,
		'location' => null,
		'vendor' => null,
		'job' => null,
		'serviceRequests' => null,
		'techs' => null,
		'offices' => null,
		'released' => null,
		'created' => null,
		'updated' => null
	);

	public function __construct( $Appointment )
	{
		foreach( $Appointment as $key => $value )
		{
			$this->property_list[$key] = $value;
		}
	}

	public function __toString()
	{
		$return_value = '';
		foreach ( $this->property_list as $key => $val )
		{
			$value = "null";
			if ( !is_null( $val ) )
			{
				if ( is_array( $val ) )
				{
					$value = var_export( $val, true );
				} else {
					$value = $val;
				}
			}
			$return_value .= "$key: $value\n";
		}
		return $return_value;
	}

	public function get( $PROPERTY )
	{
		if ( in_array( $PROPERTY, $this->property_list ) )
		{
			return $this->property_list[$PROPERTY];
		} else {
			log("Property Does Not Exist.");
			return 'Property Does Not Exist';
		}
	}

}

?>