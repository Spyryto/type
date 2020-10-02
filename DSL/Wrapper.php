<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new data of type Wrapper
 *
 * `Wrapper :: EmailAddress ( \string :: class );`
 */
class Wrapper {

	/** Define new data of type Wrapper */
	public static function __callStatic( string $typeName, $arguments )
	{
		list( $wrappedType ) = $arguments;
		$namespace = Type::getNamespace();
		return Type::wrapper( $namespace . "\\" . $typeName, $wrappedType );
	}

}