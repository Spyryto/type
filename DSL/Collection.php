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