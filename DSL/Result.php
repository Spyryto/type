<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new Result type
 *
 * `Result :: of ( Person :: class, Error :: class );`
 */
class Result {

	/** Define new data of type Result */
	public static function __callStatic($typeName, $arguments)
	{
		list( $successClassName, $failureClassName ) = $arguments;
		$namespace = Type::getNamespace();
		return Type::result( $typeName, $successClassName, $failureClassName, $namespace );
	}

}