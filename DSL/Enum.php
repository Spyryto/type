<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new Enum type
 *
 * `Enum :: Color ([
 *     'Red', 'Green', 'Blue',
 * ]);`
 */
class Enum {

	/** Define new Enum type */
	public static function __callStatic($typeName, $arguments)
	{
		$namespace = Type::getNamespace();
		return Type::enum( $namespace . "\\" . $typeName, ...$arguments );
	}

}