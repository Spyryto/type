<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;
use Type\Text;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

function enum( string $fullTypeName, string ...$types ) : string
{
	$class = ClassInfo::from( $fullTypeName );

	$typeName = $class->name;

	foreach ($types as $type) {
		$var = strtolower( $type[0] ) . substr( $type, 1 );

		$_exportedTypes   []= "'$type'";
		$_exportedClasses []=
			$class->namespace == '' ? "'$type'"
			:                         "'{$class->namespace}\\$type'";
		$_matchSnippet    []= TAB . " * `function ( $type §$var ) { §$var; }";
		$_staticFactories []= Text::trim("
			static public function $type() : $type
			{
				return new $type();
			}
		");
	}

	$staticFactories = \join("\n\n", $_staticFactories);
	$exportedTypes = "[" . \join(", ", $_exportedTypes) . "]";
	$exportedClasses = "[" . \join(", ", $_exportedClasses) . "]";
	$matchSnippet = TAB . " * `->match(`" . "\n" . TAB . " *" . "\n"
		. join( ",`\n" . TAB . " *\n", $_matchSnippet ) . "`" . "\n"
		. TAB . " *" . "\n" . TAB . " * `);`";
	$doc = \join( " | ", $types );

	$code = <<<CODE
{$class->namespaceDeclaration}

/** $typeName is $doc */
abstract class $typeName
extends \Type\AbstractEnum
{
	const SET = $exportedTypes;
	const SET_CLASSES = $exportedClasses;

	protected §value;

$staticFactories

	static public function fromString( string §string )
	{
		if ( in_array( §string, self::SET ))
		{
			return self::§string();
		}
		else
		{
			throw new \Exception( "Invalid value §string for enum $typeName." );
		}
	}

	static public function fromInt( int §int )
	{
		if ( §int < count( self::SET ))
		{
			§string = self::SET[ §int ];
			return self::fromString( §string );
		}
	}

	/**
	 * Case match
	 *
	 * Use this snippet:
	 *
$matchSnippet
	 */
	public function match( \Closure ...§cases )
	{
		§definedTypes = [];
		foreach ( §cases as §case => §closure )
		{
			§function = new \ReflectionFunction( §closure );
			§parameters = §function->getParameters();
			list( §parameter ) = §parameters;
			if ( §parameter->getType() == null )
			{
				throw new \TypeError( 'All parameter types must be specified' );
			}
			§type = §parameter->getType()->__toString();
			§definedTypes[] = §type;
		}
		if ( ! self::setMatches( §definedTypes ))
		{
			throw new \Exception( 'You did not match all cases properly' );
		}
		foreach ( §cases as §case => §closure )
		{
			if ( is_a( §this, §definedTypes[ §case ] )) {
				return §closure( §this );
			}
		}
	}

	static private function setMatches( array §array )
	{
		return self::arraysAreEqual(
			$exportedClasses,
			§array
		);
	}

	static private function arraysAreEqual( array §array1, array §array2 )
	{
		sort( §array1 );
		sort( §array2 );
		return §array1 == §array2;
	}
}

CODE;

	$fileName = PHP::generate( $code, $fullTypeName );
	Type::register($fullTypeName, $fileName);

	foreach ($types as $type ) {
		if ( \class_exists( $type )) continue;

		$code = Text::trim("
			{$class->namespaceDeclaration}

			class $type extends $typeName
			{
				protected §value = '$type';

				public function __toString()
				{
					return §this->value;
				}

				public function toInt() : int
				{
					§index = array_search( §this->value, self::SET );
					return §index;
				}
			}
			"
		);

		$fullTypeName =
			$class->namespace !== '' ? $class->namespace . "\\" . $type
			:                          $type
		;

		$fileName = PHP::generate( $code, $fullTypeName );
		Type::register($fullTypeName, $fileName);
	}

	return $fileName;
}