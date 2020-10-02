<?php declare(strict_types = 1);

namespace Type;

use Type\Type;
use PHPGenerator\PHP;
use PHPGenerator\ClassInfo;

require_once __DIR__ . "/../PHPGenerator/PHPGenerator.php";
require_once __DIR__ . "/../Utils/Utils.php";

function record( string $fullTypeName, array $fields ) : string
{
	$class = ClassInfo::from( $fullTypeName );

	$typeName = $class->name;

	foreach ( $fields as $property => $type )
	{
		if ( ! \in_array( $type, [ 'string', 'bool', 'int', 'float' ])) {
			$type = "\\" . $type;
		}
		$_privates    []= TAB . "protected $$property;";
		$_parameters  []= TAB. TAB . "$type $$property";
		$_assignments []= TAB. TAB . "§this->$property = §$property;";
		$_properties  []= "'$property'";
		$_propertyDoc []= " * @property-read $type §$property";
		$_fields      []= TAB . TAB . "[ '$property', $type :: class ]";
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
extends \Type\AbstractRecord
{
	const FIELDS = [
$fields
	];

$privates

	public function __construct($parameters)
	{
$assignments
	}

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

}

CODE;

	$fullClassName = $class->fullName;

	$fileName = PHP::generate( $code, $fullClassName );
	Type::register( $fullClassName, $fileName );
	return $fileName;
}