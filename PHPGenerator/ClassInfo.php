<?php declare( strict_types = 1 );

namespace PHPGenerator;

/**
 *
 * @property-read string $fullName
 * @property-read string $namespace
 * @property-read string $namespaceDeclaration
 * @property-read string $name
 * @property-read string[] $path
 */
class ClassInfo
{
    static function from( string $fullClassName ) : ClassInfo
    {
        return new ClassInfo( $fullClassName );
    }

    static function of( object $object ) : ClassInfo
    {
        return new ClassInfo( get_class( $object ));
    }

    function __construct( string $fullClassName )
    {
        $classPath = explode( "\\", $fullClassName );
        $className = array_pop( $classPath );
        $classPath = array_filter( $classPath );
        $this->path = $classPath;
        $this->name = $className;
    }

    protected function getFullName() : string
    {
        $namespace = $this->namespace;
        return
            $namespace === '' ? $this->name
            :                   $namespace . "\\" . $this->name
		;
    }

    protected function getFullSanitized() : string
    {
        $fullName = $this->getFullName();
        return str_replace( "\\", "__", $fullName );
    }

    protected function getNamespace() {
        return implode( "\\", $this->path );
    }

    protected function getNamespaceDeclaration() : string
    {
        $namespace = $this->namespace;
        return
            $namespace !== '' ? "namespace $namespace;"
            :                   ""
        ;
    }

    function __get( $property )
    {
        $method = "get" . ucfirst( $property );
        if ( method_exists( $this, $method ))
        {
            return $this->$method();
        }
        else if ( in_array( $property, [ 'name', 'path' ]))
        {
            return $this->$property;
        }
        else
        {
            throw new \Exception( "Property '$property' not found." );
        }

    }

    /** @var string[] */
    protected $path;
    /** @var string */
    protected $name;
}