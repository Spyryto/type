<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

/**
 *
 * @param string $ok Full class name for success case
 * @param string $error Full class name for failure case
 * @return string
 */
function result( string $typeName, string $ok, string $error, string $namespace ) : string
{
	$namespaceDeclaration =
		$namespace !== '' ? "namespace {$namespace};"
		:                   ""
	;

	$A            = absoluteNamespace( $ok );
	$B            = absoluteNamespace( $error );
	$Result‹A，B› = $typeName;
	$Success‹A›   = "{$typeName}OK";
	$Failure‹B›   = "{$typeName}Error";

	$doc = "$A|$B";

	$code = <<<CODE
$namespaceDeclaration

/** $doc */
abstract class $Result‹A，B›
extends \Type\AbstractResult
{
	const BASE_OPTION_CLASS = '$Result‹A，B›';

	function __construct()
	{
		throw new \Error( 'Must be overridden' );
	}

	static public function Success( $A §value ) : $Success‹A›
	{
		return new $Success‹A›( §value );
	}

	static public function Failure( $B §value ) : $Failure‹B›
	{
		return new $Failure‹B›( §value );
	}

	/**
	 * Matches the 2 cases: Some and None
	 *
	 * Start from this snippet:
	 *
	 * `->match(`
	 *
	 * `function ( $Success‹A› §success )`
	 *
	 * `{ return §success->value;`
	 *
	 * `},`
	 *
	 * `function ( $Failure‹B› §failure )`
	 *
	 * `{ return §failure->value`
	 *
	 * `});`
	 */
	public function match( §some, §none )
	{
		return parent::match( §some, §none );
	}
}

/**
 * @property-read $A §value
 */
class $Success‹A›
extends $Result‹A，B›
implements \Type\Success
{
	const BASE_OPTION_CLASS = '$Result‹A，B›';
	private §value;

	public function __construct( $A §value ) {
		§this->value = §value;
	}

	public function __get( §property )
	{
		if ( §property === 'value' )
		{
			return §this->value;
		}
		else
		{
			throw new \UnexpectedValueException( "Property §property does not exist" );
		}
	}

	public function __toString()
	{
		return (string) §this->value;
	}

	public function isNull()
	{
		return false;
	}
}

/**
 * @property-read $B §value
 */
class $Failure‹B›
extends $Result‹A，B›
implements \Type\Failure
{
	const BASE_OPTION_CLASS = '$Result‹A，B›';
	private §value;

	public function __construct( $B §value ) {
		§this->value = §value;
	}

	public function __get( §property )
	{
		if ( §property === 'value' )
		{
			return §this->value;
		}
		else
		{
			throw new \UnexpectedValueException( "Property §property does not exist" );
		}
	}

	public function __toString()
	{
		return (string) §this->value;
	}

	public function isNull()
	{
		return true;
	}
}

CODE;

	$fullClassName =
		$namespace === '' ? $Result‹A，B›
		:                   $namespace . "\\" . $Result‹A，B›
	;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register($fullClassName, $fileName);
	return $fileName;
}