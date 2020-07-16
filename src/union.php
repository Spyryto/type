<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../Utils/Utils.php";

function union( string $fullTypeName, string ...$types ) : string
{
	$class = ClassInfo::from( $fullTypeName );

	$typeName = $class->name;

	foreach ( $types as $type ) {
		$className = ClassInfo::from( $type )->name;
		$var = strtolower( $className[0] ) . substr( $className, 1 );
		$_phpDoc        []=
			"\\" . $type
		;
		$_exportedTypes []= "'$type'";
		$_matchSnippet  []= TAB . " * `function ( $type §$var ) { §$var; }";
	}

	$phpDoc        = "/** @param " . join( "|", $_phpDoc ) . " §value */";
	$doc           = join( " | ", $types );
	$exportedTypes = "[" . \join(", ", $_exportedTypes) . "]";
	$matchSnippet  = TAB . " * `->match(`" . "\n" . TAB . " *" . "\n"
		. join( ",`\n" . TAB . " *\n", $_matchSnippet ) . "`" . "\n"
		. TAB . " *" . "\n" . TAB . " * `);`";

	$code = <<<CODE

{$class->namespaceDeclaration}

/** $doc */
class $typeName
extends \Type\AbstractUnion
{
	const SET = $exportedTypes;

	protected §value;

	$phpDoc
	public function __construct( §value )
	{
		foreach ( $exportedTypes as §type )
		{
			if ( is_a( §value, §type )) {
				§this->value = §value;
				return;
			}
		}
		§badClass = get_class( §value );
		throw new \TypeError( "§badClass is not a valid $typeName" );
	}

	/**
	 * Case match
	 *
	 * Use this snippet:
	 *
$matchSnippet
	 */
	public function match( ...§cases )
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
			if ( is_a( §this->value, §definedTypes[ §case ] )) {
				return §closure( §this->value );
			}
		}
	}

	static private function setMatches( array §array )
	{
		return self::arraysAreEqual(
			$exportedTypes,
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

	return $fileName;

	// Classes listed in parameters should already exist,
	// so we don't generate them.


	/*
	foreach ($types as $type ) {
		if ( \class_exists( $class->namespace . "\\" . $type )) continue;
		$code = <<<CODE

$namespaceDeclaration

class $type extends $typeName {}
CODE;
		$fullTypeName =
			$class->namespace !== '' ? $class->namespace . "\\" . $type
			:                          $type
		;
		$fileName = PHP::generate( $code, $fullTypeName );
		Type::register($fullTypeName, $fileName);
	}
	*/
}