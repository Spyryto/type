<?php declare(strict_types = 1);
namespace DB;

/**
 * @property-read string $value
 */
class Text
extends \Type\AbstractWrapper
{
	const WRAPPED_TYPE = 'string';
	private $wrappedValue;

	public function __construct( string $value )
	{
		$this->wrappedValue = $value;
	}

	public function __toString()
	{
		return (string) $this->wrappedValue;
	}

	public function __get( $property )
	{
		if ( $property === 'value' )
		{
			return $this->wrappedValue;
		}
	}
}
