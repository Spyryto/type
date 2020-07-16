<?php declare(strict_types = 1);
namespace DB;

abstract class IdOption
extends \Type\AbstractOption
{
	const BASE_OPTION_CLASS = 'IdOption';

	function __construct()
	{
		throw new \Error( 'Must be overridden' );
	}

	static public function Some( Id $value ) : SomeId
	{
		return new SomeId( $value );
	}

	static public function None() : NoId
	{
		return new NoId();
	}

	/**
	 * Matches the 2 cases: Some and None
	 *
	 * Start from this snippet:
	 *
	 * `->match(`
	 *
	 * `function ( SomeId $some )`
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
 * @property-read Id $value
 */
class SomeId
extends IdOption
implements \Type\Some
{
	const BASE_OPTION_CLASS = 'IdOption';
	private $value;

	public function __construct( Id $value ) {
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

class NoId
extends IdOption
implements \Type\None
{
	const BASE_OPTION_CLASS = 'IdOption';

	public function __construct()
	{
	}

	public function isNull()
	{
		return true;
	}
}
