<?php declare(strict_types = 1);
namespace DB;

abstract class TextOption
extends \Type\AbstractOption
{
	const BASE_OPTION_CLASS = 'TextOption';

	function __construct()
	{
		throw new \Error( 'Must be overridden' );
	}

	static public function Some( Text $value ) : SomeText
	{
		return new SomeText( $value );
	}

	static public function None() : NoText
	{
		return new NoText();
	}

	/**
	 * Matches the 2 cases: Some and None
	 *
	 * Start from this snippet:
	 *
	 * `->match(`
	 *
	 * `function ( SomeText $some )`
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
 * @property-read Text $value
 */
class SomeText
extends TextOption
implements \Type\Some
{
	const BASE_OPTION_CLASS = 'TextOption';
	private $value;

	public function __construct( Text $value ) {
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

class NoText
extends TextOption
implements \Type\None
{
	const BASE_OPTION_CLASS = 'TextOption';

	public function __construct()
	{
	}

	public function isNull()
	{
		return true;
	}
}
