<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

/**
 * Creates a new data of type Record
 *
 * `Collection :: of ( int :: class );`
 */
class Collection
{
	static public function of( $baseType )
	{
		return Type::collectionOf( $baseType, Type::getNamespace() );
	}
}

/** DSL to conveniently set namespace for subsequent data-type definitions
 *
 * Works with Record
 */
class Define
{
	static public function in( string $namespace )
	{
		Type::setNamespace( $namespace );
	}

	static public function end()
	{
		Type::popNamespace();
	}
}

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

/**
 * Creates a new Dto type
 *
 * `Dto :: Person ([
 *     'firstName' => string :: class,
 *     'lastNname' => string :: class,
 * ]);`
 */
class Dto {

	/** Define new data of type Record */
	public static function __callStatic($typeName, $arguments)
	{
		list( $fields ) = $arguments;
		$namespace = Type::getNamespace();
		return Type::dto( $namespace . "\\" . $typeName, $fields );
	}

}

/**
 * Creates a new Record type
 *
 * `Record :: Person ([
 *     'firstName' => string :: class,
 *     'lastNname' => string :: class,
 * ]);`
 */
class Record {

	/** Define new data of type Record */
	public static function __callStatic($typeName, $arguments)
	{
		list( $fields ) = $arguments;
		$namespace = Type::getNamespace();
		return Type::record( $namespace . "\\" . $typeName, $fields );
	}

}

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