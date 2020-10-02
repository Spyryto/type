<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

define( 'BASE_WRAPPER', \Type\AbstractWrapper :: class );

function wrapper( string $fullTypeName, string $wrappedType ) : string
{
	$class = ClassInfo::from( $fullTypeName );

	$typeName = $class->name;
	$baseWrapper = absoluteNamespace( BASE_WRAPPER );

	$code = <<<CODE
{$class->namespaceDeclaration}

/**
 * @property-read $wrappedType §value
 */
class $typeName
extends $baseWrapper
{
	const WRAPPED_TYPE = '$wrappedType';
	private §wrappedValue;

	public function __construct( $wrappedType §value )
	{
		§this->wrappedValue = §value;
	}

	public function __toString()
	{
		return (string) §this->wrappedValue;
	}

	public function __get( §property )
	{
		if ( §property === 'value' )
		{
			return §this->wrappedValue;
		}
	}
}

CODE;

	$fullClassName =$class->fullName;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register($fullClassName, $fileName);
	return $fileName;
}