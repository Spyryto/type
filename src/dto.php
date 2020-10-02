<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

function dto( string $fullTypeName, array $fields ) : string
{
	$class = ClassInfo::from( $fullTypeName );

	$typeName = $class->name;

	foreach ( $fields as $property => $type )
	{
		if ( ! \in_array( $type, [ 'string', 'bool', 'int', 'float' ])) {
			$classClause = "\\$type :: class";
			$type = "\\$type";
		}
		else
		{
			$classClause = "'$type'";
		}

		$_privates    []= TAB . "protected $$property;";
		$_parameters  []= TAB. TAB . "$type $$property";
		$_assignments []= TAB. TAB . "§this->$property = §$property;";
		$_properties  []= "'$property'";
		// $_propertyDoc []= " * @property-read $type §$property";
		$_propertyDoc []= " * @property $type §$property";
		// $_fields      []= TAB . TAB . "[ '$property', $type :: class ]";
		$_fields      []= TAB . TAB . "'$property' => $classClause";
	}

	$privates = nl($_privates);
	$parameters = PHP_EOL . comma_nl($_parameters);
	$assignments = nl($_assignments);
	$properties = \implode(', ', $_properties);
	$propertyDoc = nl($_propertyDoc);
	$fields = comma_nl($_fields);

	$code = <<<CODE
{$class->namespaceDeclaration}

/**
$propertyDoc
 */
class $typeName
extends \Type\AbstractDto
implements \Type\Dto
{
	const FIELDS = [
$fields
	];

$privates

	/*
	public function __construct($parameters)
	{
$assignments
	}
	*/

	public function __get(§property)
	{
		if ( in_array( §property, [ $properties ] ))
		{
			return §this->§property;
		}
		else
		{
			throw new \UnexpectedValueException( "Property §property does not exist" );
		}
	}

	public function __set( §property, §value )
	{
		if ( ! array_key_exists( §property, self::FIELDS ))
		{
			throw new \Exception( "Cannot set property §property on $typeName." );
		}
		§type = self::FIELDS[ §property ];
		// if ( gettype( §value ) === §type
		// 	|| is_a( §value, §type ))
		// {
			§this->§property = §value;
		// }
		// else
		// {
		// 	throw new \Exception( "Could not manage the type of ‘{§value}’" );
		// }

	}
}

CODE;

	$fullClassName = $class->fullName;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register( $fullClassName, $fileName );
	return $fileName;
}