<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new Option type
 *
 * `Option :: Text ( \string :: class );`
 */
class Option {

	/** Define new data of type Wrapper */
	public static function __callStatic( string $typeName, $arguments )
	{
		list( $baseType ) = $arguments;
		$namespace = Type::getNamespace();
		return Type::option( $namespace . "\\" . $typeName, $baseType );
	}

}