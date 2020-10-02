<?php declare( strict_types = 1 );

namespace Type;

require_once __DIR__ . "/Type.definition.php";
require_once __DIR__ . "/src/src.php";

/**
 * Module to create new data types from basic ones.
 */
class Type
{
	// Constants for native types.
	const string = 'string';
	const int = 'int';
	const float = 'float';
	const bool = 'bool';

	static function dto( string $fullTypeName, array $fields )
	{
		return dto( $fullTypeName, $fields );
	}

	static function enum( string $fullTypeName, string ...$types )
	{
		return enum( $fullTypeName, ...$types );
	}

	static function union( string $fullTypeName, string ...$types )
	{
		return union( $fullTypeName, ...$types );
	}

	static function record( string $fullTypeName, array $fields )
	{
		return record( $fullTypeName, $fields );
	}

	static function wrapper( string $fullTypeName, string $wrappedType )
	{
		return wrapper( $fullTypeName, $wrappedType );
	}

	static function result( string $typeName, string $successClassName, string $failureClassName, string $namespace )
	{
		return result( $typeName, $successClassName, $failureClassName, $namespace );
	}

	static function option( string $fullClassName, string $baseType )
	{
		return option( $fullClassName, $baseType );
	}

	/** Creates a new array datatype */
	static function collectionOf( string $wrappedType, string $namespace = '' )
	{
		return collectionOf( $wrappedType, $namespace );
	}

	// Register for autoloading classes

	static public $autoloadMap = [];

	static private $debugTrace = false;

	static function register( string $type, string $fullFilePath )
	{
		if ( self::$debugTrace ) echo "Registering $type: $fullFilePath \n";
		self::$autoloadMap[ $type ] = $fullFilePath;
		if ( self::$debugTrace )
		{
			echo "REGISTERED: ";
			var_dump(self::$autoloadMap);
		}
	}

	static function filePath( string $type )
	{
		return
			array_key_exists( $type, self::$autoloadMap ) ? self::$autoloadMap[ $type ]
			:                                               null
		;
	}

	// Current namespace for data-type definitions

	static protected $namespace = [''];

	static function setNamespace( string $namespace )
	{
		$count = count( self::$namespace );
		self::$namespace[ $count ] = $namespace;
	}

	static function getNamespace() : string {
		$count = count( self::$namespace );
		return self::$namespace[ $count - 1 ];
	}

	static function popNamespace()
	{
		$count = count( self::$namespace );
		if ( $count > 1 )
		{
			unset( self::$namespace[ $count - 1 ] );
		}
	}

	// Type check

	static function isNative( string $class ) : bool {
		return in_array( $class, [
			Type :: bool,
			Type :: float,
			Type :: int,
			Type :: string,
		]);
	}

	static function isNativeObject( $x ) : bool
	{
		if ( gettype( $x ) !== 'object' ) return true;
		$className = get_class( $x );
		return self::isNative( $className );
	}

}

spl_autoload_register( function ( $fullClassName )
{
	$file = Type::filePath( $fullClassName );
	if ( $file )
	{
		// echo "2 -- $fullClassName: ––––– $file \n";
		require_once $file;
	}
	else
	{
		// echo "2 KO $fullClassName \n";
	}
});

