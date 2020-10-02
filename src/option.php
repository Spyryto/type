<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

function option( String $fullClassName, String $baseType ) : string
{
	$class = ClassInfo::from( $fullClassName );

	$Option‹T› = "{$class->name}Option";
	$Some‹T›   = "Some{$class->name}";
	$No‹T›     = "No{$class->name}";
	$T         = $class->name;

	$code = <<<CODE
{$class->namespaceDeclaration}

abstract class $Option‹T›
extends \Type\AbstractOption
{
	const BASE_OPTION_CLASS = '$Option‹T›';

	function __construct()
	{
		throw new \Error( 'Must be overridden' );
	}

	static public function Some( $T §value ) : $Some‹T›
	{
		return new $Some‹T›( §value );
	}

	static public function None() : $No‹T›
	{
		return new $No‹T›();
	}

	/**
	 * Matches the 2 cases: Some and None
	 *
	 * Start from this snippet:
	 *
	 * `->match(`
	 *
	 * `function ( $Some‹T› §some )`
	 *
	 * `{ return §some->value;`
	 *
	 * `},`
	 *
	 * `function ()`
	 *
	 * `{ // other code`
	 *
	 * `});`
	 */
	public function match( §some, §none )
	{
		return parent::match( §some, §none );
	}
}

/**
 * @property-read $T §value
 */
class $Some‹T›
extends $Option‹T›
implements \Type\Some
{
	const BASE_OPTION_CLASS = '$Option‹T›';
	private §value;

	public function __construct( $T §value ) {
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

class $No‹T›
extends $Option‹T›
implements \Type\None
{
	const BASE_OPTION_CLASS = '$Option‹T›';

	public function __construct()
	{
	}

	public function isNull()
	{
		return true;
	}
}

CODE;

	$fullClassName =
		$class->namespace === '' ? $Option‹T›
		:                          $class->namespace . "\\" . $Option‹T›
	;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register($fullClassName, $fileName);
	return $fileName;
}
