<?php declare( strict_types = 1 );

namespace PHPGenerator;

require_once __DIR__ . "/ClassInfo.php";
require_once __DIR__ . "/src/php.php";

class PHP
{
	static public function generate(string $codeTemplate, string $fullClassName ) {
		return php( $codeTemplate, $fullClassName );
	}
}
