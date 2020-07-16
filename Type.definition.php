<?php declare( strict_types = 1 );

namespace Type;

require_once __DIR__ . "/PHPGenerator/PHPGenerator.php";

use Closure;
use PHPGenerator\ClassInfo;

interface Option {
	public function match( Closure $some, Closure $none );
}

interface None {
	public function match( Closure $some, Closure $none );
}

interface Some {
	public function __get( $property );
}

interface Result {
	public function match( Closure $ok, Closure $error );
}

interface Success {
	public function match( Closure $ok, Closure $error );
}

interface Failure {
	public function match( Closure $ok, Closure $error );
}

interface Dto {
}

use ReflectionFunction;
use TypeError;

abstract class AbstractCollection
{
}

abstract class AbstractDto
{
	const FIELDS = [];
}

abstract class AbstractEnum
{
}

abstract class AbstractOption
implements Option
{
	const BASE_OPTION_CLASS = null;

	/**
	 * @param \Closure $some
	 * @param \Closure $none
	 */
	public function match( $some, $none )
	{
		$_some = self::firstParameter( $some );
		$_none = self::firstParameter( $none );
		if ( is_null( $_some ) )
			throw new TypeError( "Parameter must be specified" );
		$_someType = (string) $_some->getType();
		if ( ! is_subclass_of( $_someType, Some :: class )  )
			throw new TypeError( "Parameter must be a subclass of Some, $_someType is not" );
		// $baseOptionClass = $this::BASE_OPTION_CLASS;
		if ( ! is_subclass_of( $_someType, Option :: class ) )
			throw new TypeError( "Parameter must be a subclass of Option, $_someType is not" );
		if ( ! is_null( $_none ) )
			throw new TypeError( 'No parameters here' );

		if ( is_subclass_of( $this, Some :: class ) ) {
			return $some( $this );
		} else {
			return $none();
		}
	}

	static protected function firstParameter( \Closure $closure ) {
		$_closure = new ReflectionFunction( $closure );
		$_parameters = $_closure->getParameters();
		return count( $_parameters ) > 0 ? $_parameters[0] : null;
	}
}

abstract class AbstractRecord
{
	const FIELDS = [];
}

abstract class AbstractResult
implements Result
{
	const BASE_OPTION_CLASS = null;

	/**
	 * @param \Closure $ok
	 * @param \Closure $error
	 */
	public function match( $ok, $error )
	{
		$a = self::firstParameter( $ok );
		$b = self::firstParameter( $error );
		if ( is_null( $a ) )
			throw new TypeError( "Success parameter must be specified" );
		if ( is_null( $b ) )
			throw new TypeError( "Failure parameter must be specified" );
		$A = (string) $a->getType();
		$B = (string) $b->getType();
		if ( ! is_subclass_of( $A, Success :: class )  )
			throw new TypeError( "Parameter must be a subclass of Success, $A is not" );
		if ( ! is_subclass_of( $B, Failure :: class )  )
			throw new TypeError( "Parameter must be a subclass of Failure, $B is not" );
		// $baseOptionClass = $this::BASE_OPTION_CLASS;
		if ( ! is_subclass_of( $A, Result :: class ) )
			throw new TypeError( "Parameter must be a subclass of Result, $A is not" );
		if ( ! is_subclass_of( $B, Result :: class ) )
			throw new TypeError( "Parameter must be a subclass of Result, $B is not" );

		if ( is_subclass_of( $this, Success :: class ) ) {
			return $ok( $this );
		} else {
			return $error( $this );
		}
	}

	static protected function firstParameter( \Closure $closure ) {
		$_closure = new ReflectionFunction( $closure );
		$_parameters = $_closure->getParameters();
		return count( $_parameters ) > 0 ? $_parameters[0] : null;
	}
}

abstract class AbstractUnion
{
}

abstract class AbstractWrapper
{
	const WRAPPED_TYPE = '';
}