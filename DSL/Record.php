<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

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
