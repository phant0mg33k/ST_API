<?php

class AuthUser
{
	public $props = array(
		'id' => null,
		'uri' => null,
		'name' => null,
		'status' => null,
		'firstName' => null,
		'lastName' => null,
		'username' => null,
		'email' => null,
		'phone' => null,
		'isTech' => null
	);
	public function __construct( $AUTH_USER )
	{
		foreach( $this->props as $key => $value )
		{
			$this->props[$key] = $AUTH_USER->$key;
		}
	}

	public function __toString()
	{
		$return_value = '';

		foreach( $this->props as $key => $value )
		{
			$return_value .= $key.': '.$value."\n";
		}

		return $return_value;
	}
}

?>