<?php declare(strict_types = 1);

namespace Type;

use PHPGenerator\ClassInfo;
use PHPGenerator\PHP;
use Type\Type;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

function collectionOf( string $wrappedType, string $namespace = '' ) : string
{
	$class = ClassInfo::from( $wrappedType );

	$typeName = $class->name;
	$TypeName = \ucfirst( $typeName );
	$var      = strtolower( $typeName[ 0 ]) . substr( $typeName, 1 );

	$code = <<<CODE
{$class->namespaceDeclaration}

/**
 * @property-read {$TypeName}[] §iterator
 */
class CollectionOf$TypeName
extends \Type\AbstractCollection
implements \IteratorAggregate, \ArrayAccess
{
	private §values;

	public function __construct( $typeName ...§values )
	{
		§this->values = §values;
	}

	/** Maps a closure onto a collection
	 *
	 * Use this snippet:
	 *
	 * `->map(`
	 *
	 * `function ( $TypeName §$var ) { return §$var; });`
	 */
	public function map( \Closure §f )
	{
		§function = new \ReflectionFunction(§f);
		§params = §function->getParameters();
		if ( count( §params ) < 1 )
		{
			throw new \LengthException( 'Missing parameter in closure' );
		}
		list( §param ) = §params;
		§paramType = §param->getType();
		if ( is_null( §paramType ) )
		{
			throw new \InvalidArgumentException( 'Closure parameter type not specified' );
		}
		§paramTypeName = §paramType->__toString();

		if ( §paramTypeName !== $typeName :: class )
		{
			throw new \InvalidArgumentException( 'Closure parameter type mismatch' );
		}

		return array_map( §f, §this->values );
	}

	// -----   IteratorAggregate   -----

	/** @return {$TypeName}[] */
	public function getIterator()
	{
		return new \ArrayIterator( §this->values );
	}

	// -----   ArrayAccess   -----

	public function offsetGet(§offset) : $typeName
	{
		if ( isset( §this->values[ §offset ] ))
		{
			return §this->values[ §offset ];
		} else {
			throw new \OutOfBoundsException();
		}
	}

	public function offsetSet( §offset, §value )
	{
		throw new \Type\MutationException();
	}

	public function offsetExists( §offset )
	{
		return isset( §this->values[ §offset ] );
	}

	public function offsetUnset( §offset )
	{
		throw new \Type\MutationException();
	}

	// -----   Magic properties   -----

	public function __get( §name )
	{
		if ( §name === 'iterator' )
		{
			return §this->getIterator();
		}
		else
		{
			throw new \UnexpectedValueException( "Property §name does not exist" );
		}
	}

}

CODE;

	$fullClassName =
		$class->namespace === '' ? "CollectionOf$TypeName"
		:                          $class->namespace . "\\" . "CollectionOf$TypeName"
	;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register($fullClassName, $fileName);
	return $fileName;
}

class MutationException extends \Exception {}

/*
	// Do we really need mutation methods?

	public function offsetSet(§offset, §value)
	{
		if (is_null(§offset)) {
			§this->values[] = §value;
		} else {
			§this->values[§offset] = §value;
		}
	}

	public function offsetUnset(§offset)
	{
		unset(§this->values[§offset]);
	}
*/