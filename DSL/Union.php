<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new Union type
 *
 * `Union :: EmailStatus ([
 *     ValidatedEmail :: class,
 *     ValidationError :: class,
 * ]);`
 */
class Union {

	/** Define new Union type */
	public static function __callStatic($typeName, $arguments)
	{
		$namespace = Type::getNamespace();
		return Type::union( $namespace . "\\" . $typeName, ...$arguments );
	}

}