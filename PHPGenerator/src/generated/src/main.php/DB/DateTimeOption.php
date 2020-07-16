<?php declare(strict_types = 1);
namespace DB;

abstract class DateTimeOption
extends \Type\AbstractOption
{
	const BASE_OPTION_CLASS = 'DateTimeOption';

	function __construct()
	{
		throw new \Error( 'Must be overridden' );
	}

	static public function Some( DateTime $value ) : SomeDateTime
	{
		return new SomeDateTime( $value );
	}

	static public function None() : NoDateTime
	{
		return new NoDateTime();
	}

	/**
	 * Matches the 2 cases: Some and None
	 *
	 * Start from this snippet:
	 *
	 * `->match(`
	 *
	 * `function ( SomeDateTime $some )`
	 *
	 * `{ return $some->value;`
	 *
	 * `},`
	 *
	 * `function ()`
	 *
	 * `{ // other code`
	 *
	 * `});`
	 */
	public function match( $some, $none )
	{
		return parent::match( $some, $none );
	}
}

/**
 * @property-read DateTime $value
 */
class SomeDateTime
extends DateTimeOption
implements \Type\Some
{
	const BASE_OPTION_CLASS = 'DateTimeOption';
	private $value;

	public function __construct( DateTime $value ) {
		$this->value = $value;
	}

	public function __get( $property )
	{
		if ( $property === 'value' )
		{
			return $this->value;
		}
		else
		{
			throw new \UnexpectedValueException( "Property $property does not exist" );
		}
	}

	public function __toString()
	{
		return (string) $this->value;
	}

	public function isNull()
	{
		return false;
	}
}

class NoDateTime
extends DateTimeOption
implements \Type\None
{
	const BASE_OPTION_CLASS = 'DateTimeOption';

	public function __construct()
	{
	}

	public function isNull()
	{
		return true;
	}
}
