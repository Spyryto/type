<?php declare(strict_types = 1);
namespace DB;

/**
 * @property-read int $value
 */
class Id
extends \Type\AbstractWrapper
{
	const WRAPPED_TYPE = 'int';
	private $wrappedValue;

	public function __construct( int $value )
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
