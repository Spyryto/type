<?php declare( strict_types = 1 );

namespace Type;

define('TAB', "\t");

function nl(array $lines): string {
    return implode(PHP_EOL, $lines);
}

function comma_nl(array $lines): string {
    return implode(',' . PHP_EOL, $lines);
}

function array_equal(array $array1, array $array2): bool {
    sort($array1);
    sort($array2);
    return $array1 == $array2;
}

function absoluteNamespace( $ns )
{
	$prefix = Type::isNative( $ns ) ? '' : '\\';
	return $prefix . $ns;
}

class Text
{
	static public function trim( string $string )
	{
		$lines = explode( "\n", $string );
		// Remove first line if empty.
		if ( count( $lines ) > 1 && trim( $lines[ 0 ]) === '' )
		{
			array_shift( $lines );
		}
		$lineCount = count( $lines );
		$lastLine = $lines[ $lineCount - 1 ];
		// Get initial spaces from last line.
		preg_match('/^(\s+)/', $lastLine, $matches );
		list( $initialSpaces ) = $matches;
		$trimSize = strlen( $initialSpaces );
		// Remove last line if empty.
		if ( count( $lines ) > 1 && trim( $lastLine ) === '' )
		{
			array_pop( $lines );
		}
		$trimmed = array_map( function ( $line ) use ( $trimSize ) {
			$trimmedPart = substr( $line, 0, $trimSize );
			return
				trim( $trimmedPart ) === '' ? substr( $line, $trimSize )
				:                             $line
			;
		}, $lines );
		return implode( "\n", $trimmed );
	}
}

