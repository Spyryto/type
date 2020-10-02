<?php declare( strict_types = 1 );

namespace Type\DSL;

use Type\Type;

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
