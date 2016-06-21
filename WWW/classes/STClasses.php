<?php
/*****************************
 * Master Class File for Service Trade
 *
 *      Organization:
 * 				dfreshnet
 * 		Authors:
 *				Matthew Jones
 *				Robin Brandt
 *				Douglas Brandstetter
 *
 *		Copyright 2016
 */

/**
* Base class for Service Trade Data Objects
* (int) ID 			: ID for the Object
* (string) Name 	: Name for the Object
*/
class STBaseClass
{
	public $id;
	public $name;
	
	public function __construct( $id, $name )
	{
		$this->id = $id;
		$this->name = $name;
	}
	
	public function __toString()
	{
		return $this->id." ".$this->name.'\n';
	}
}

/**
* Service Trade URI Base Class
* (int) ID 			: ID for the Object
* (string) Name 	: Name for the Object
* (string) URI 		: Resource Identifier for the Object
*/
class STURIBaseClass extends STBaseClass
{
	public $uri;
	public function __construct( $id, $name, $uri )
	{
		parent::__construct( $id, $name );
		$this->uri = $uri;
	}
	public function __toString()
	{
		return $this->id." ".$this->name." ".$this->uri.'\n';
	}
}

/**
 * Account Class
 * (int) ID 		: ID of the Account
 * (string) Name 	: Name of the Account
 */
class Account extends STBaseClass
{ }

/**
* Appointment Class
* (int) ID 		: ID of the Appointment
* (string) Name : Name of the Appointment
* (string) URI 	: Resource Identifier of the Appointment
*/
class Appointment extends STURIBaseClass
{
	public function __toString()
	{
		$RETURN_VALUE = "\n";
		$RETURN_VALUE .= 'Name: ' . $this->name . "\n";
		$RETURN_VALUE .= 'ID: ' . $this->id . "\n";
		return $RETURN_VALUE;
	}
}

/**
* Asset class
* (int) ID 		: ID of the Asset
* (string) Name : Name of the Asset
* (string) URI 	: Resource Identifier of the Asset
*/
class Asset extends STURIBaseClass
{ }

/**
* Brand
* (int) ID 		: ID of the Brand
* (string) name : Name of the Brand
* (string) URI 	: Resource Identifier of the Brand
*/
class Brand extends STURIBaseClass
{ }

/**
* Company 
* (int) ID 		: ID of the Company
* (string) Name : Name of the Company
* (string) URI 	: Resource Identifier of the Company
*/
class Company extends STURIBaseClass
{ }

/**
* Invoice
* (int) ID 		: ID of the Invoice
* (string) Name : Name of the Invoice
* (string) URI 	: Resource Identifier of the Invoice
*/
class Invoice extends STURIBaseClass
{ }

/**
* Tag
* (int) ID 		: ID of the Tag
* (string) Name : Name of the Tag
* (string) URI 	: Resource Identifier of the Tag
*/
class Tag extends STURIBaseClass
{ }

/**
* Activity Class
* (int) ID 				: ID of the Activity
* (string) Name 		: Name of the Activity
* (string) Description 	: Description of the activity
*/
class Activity extends STBaseClass
{
	public $description;
	public function __construct( $id, $name, $description )
	{
		parent::__construct( $id, $name );
		$this->description = $description;
	}
}


/**
* LibItem
* (int) ID 			: ID of the item
* (string) URI 		: Resource Identifier of the item
* (string) Name 	: Name of the item
* (string) Type 	: Type of the item
* (string) Code 	: Lib item code
*/
class LibItem extends STURIBaseClass
{
	public $type;
	public $code;

	public function __construct( $id, $name, $uri )
	{
		parent::__construct( $id, $name, $uri );
	}
}

/**
* Location Class
* (int) ID 					: ID of the location
* (string) URI 				: Resource identifier of the location
* (string) name 			: Name of the location
* (string) legacyId 		: Legacy identifier for the location
* (double) Lat 				: Location Geocode Latitude
* (double) Lon 				: Location Geocode Longitude
* (Address) Address 		: Address of the Location
* (string) phoneNumber 		: Phone number of the location formatted as (XXX) XXX-XXXX
* (string) Email 			: Email address of the location
* (Contact) primaryContact 	: Information for the Primary Contact at the location
*/
class Location extends STURIBaseClass
{
	public $legacyId;
	public $lat;
	public $lon;
	public $Address;
	public $phoneNumber;
	public $email;
	public $primaryContact;
	public function __construct( $id, $name, $uri )
	{
		parent::__contruct( $id, $name, $uri );
	}
}

/**
* Quote
* (int) ID 			: ID of the Quote
* (string) URI 		: Resource Identifier of the Quote
* (string) Name 	: Name of the Quote
* (string) Status 	: Status of the Quote
*/
class Quote extends STURIBaseClass
{
	public $status;

	public function __construct( $id, $name, $uri, $status )
	{
		parent::__contruct( $id, $name, $uri );
		$this->status = $status;
	}

	public function __toString()
	{
		return (parent::__toString().' '.$this->status);
	}
}

/**
* QuoteRequest
* (int) ID 				: ID of the quote request
* (string) URI 			: Resource Identifier of the quote request
* (string) Name 		: Name of the Quote Request
* (string) Status 		: Status, One of:
							canceled, unsent, approved, quote_received, all_canceled, all_rejected, waiting.
*/
class QuoteRequest extends STURIBaseClass
{
	public $status;	

	public function __construct( $id, $name, $uri, $status )
	{
		parent::__construct( $id, $name, $uri );
		$this->status = $status;
	}

	public function __toString()
	{
		return (parent::__toString() .' '. $this->status);
	}
}

/**************************************************************
 **************	Begin Non-Inherited Classes	*******************
 **************************************************************/

/**
* Address Class
* (string) Street
* (string) City
* (string) State
* (string) Postal Code
*/
class Address
{
	public $street;
	public $city;
	public $state;
	public $postalCode;
	public function __construct() {}
}

/**
* AssetDefinition
* (int) ID 		: ID of the asset Definition
* (string) URI  : Resource Identifier of the Asset Definition
* (string) Type : Type of the Asset Definition
*/
class AssetDefinition
{
	public $id;
	public $type;
	public $uri;

	public function __construct() {}
}

/**
* Contact
* (int) ID 				: ID of the Contact
* (string) URI 			: Resource Identifier of the Contact
* (string) firstName 	: Contact first name
* (string) lastName 	: Contact last name
* (string) type			: Contact Type, Free form string describing what type of contact
* (string) phone 		: Contact Phone
* (string) cell 		: Contact Cell
* (string) email 		: Contact Email
*/
class Contact
{
	public $id;
	public $uri;
	public $firstName;
	public $lastName;
	public $type;
	public $phone;
	public $cell;
	public $email;

	public function __construct() {}
}

/**
* QuoteItem
* (int) ID 				: ID of the QuoteItem
* (string) URI			: Resource Identifier of the QuoteItem
* (string) Description	: Name of the QuoteItem
*/
class QuoteItem
{
	public $id;
	public $uri;
	public $description;

	public function __construct( $id, $name, $description )
	{
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
	}

	public function __toString()
	{
		return $this->id .' '. $this->name .' '. $this->description. '\n';
	}	
}

/**
* QuoteTemplateItem
* (int) ID 				: ID of the QuoteTemplateItem
* (string) URI			: Resource identifier for the QTI
* (string) Description	: Name of the QTI
*/
class QuoteTemplateItem
{
	public $id;
	public $uri;
	public $description;

	public function __construct( $id, $uri, $description )
	{
		$this->id = $id;
		$this->uri = $uri;
		$this->description = $description;
	}

	public function __toString()
	{
		return $this->id .' '. $this->uri .' '. $this->description. '\n';
	}	
}

/**
* ServiceItem
* (int) ID 				: Item ID
* (string) URI 			: Resource identifier for the given item
* (string) Description 	: Item Description
* (double) Quantity 	: Item Quantity
* (double) Price 		: Item unit Price
* (int) orderIndex 		: Order in which item appears in list of invoice items
* (LibItem) libItem  	: Libitem that this item is an instance of
*/
class ServiceItem
{
	public $id;
	public $uri;
	public $description;
	public $quantity;
	public $price;
	public $orderIndex;
	public $libItem;

	public function __construct() {}

	public function __toString()
	{
		return $this->id .' '. $this->uri .' '. $this->description .'\n';
	}
}



class ServiceLine
{
	public $id;
	public $name;
	public $trade;
	public $abbr;
	public $icon;

	public function __construct() { }
}

class ServiceRecurrence
{
	public $id;
	public $uri;
	public $description;
	public $frequency;
	public $interval;
	public $repeatWeekday;

	public function __construct() { }
}

class ServiceRequest
{
	public $id;
	public $uri;
	public $description;

	public function __construct( $id, $uri, $description )
	{
		$this->id = $id;
		$this->uri = $uri;
		$this->description = $description;
	}

	public function __toString()
	{
		return $this->id .' '. $this->uri .' '. $this->description. '\n';
	}
}

class ServiceTemplate
{
	public $id;
	public $uri;
	public $name;
	public $description;
	public $frequency;
	public $interval;
	public $repeatWeekday;

	public function __construct() { }
}

/**
* User
*/
class User extends STURIBaseClass
{
	public $status;
	public $avatar;

	public function __construct( $user )
	{
		parent::__construct($user->id, $user->name, $user->uri);
		$this->status = $user->status;
		$this->avatar = array(
			'small' 	=> $user->avatar->small,
			'mediaum' 	=> $user->avatar->medium,
			'large' 	=> $user->avatar->large
		);
	}

	public function __toString()
	{
		$RETURN_VALUE = "";
		$RETURN_VALUE .= 'User: '. $this->name .' '. $this->id .' '. $this->uri .' '. $this->status .'';
		return $RETURN_VALUE;
	}
}

/*
* Webhook
*/
class Webhook
{
	public $id;
	public $uri;
	public $hookUrl;
	public $enabled;
	public $confirmed;

	public function __construct() {}
}
?>