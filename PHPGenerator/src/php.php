<?php declare(strict_types = 1);

namespace PHPGenerator;

// function php($codeTemplate, Closure $fileNameTemplate) {
//     $code = "<?php declare(strict_types = 1);\n"
//           . str_replace('§', '$', $codeTemplate);
//     static $n = 0;
//     $generatedFile = $fileNameTemplate($n);
//     if ( file_exists( $generatedFile ))
//     file_put_contents($generatedFile, $code);
//     $n++;
// 	return $generatedFile;
// }
function php(string $codeTemplate, string $fullClassName ) {
    // $classPath = explode( "\\", $fullClassName );
    // $className = array_pop( $classPath );
    // $classPath = array_filter( $classPath );
    $class = ClassInfo::from( $fullClassName );
    $namespacePath = count( $class->path ) === 0 ? '' : '/' . implode( "/", $class->path );
    $fileName = "{$class->name}.php";
    $entryPoint = get_included_files()[0];
    $shortEntryPoint = str_replace( project_root( $entryPoint ), '', $entryPoint );
    $path = __DIR__ . "/generated" . $shortEntryPoint . $namespacePath;
    $code = "<?php declare(strict_types = 1);\n"
          . str_replace('§', '$', $codeTemplate);
    static $n = 0;
    $generatedFile = str_replace( '\\', '/', $path ) . "/$fileName";
    // var_dump([
    //     'shortEntryPoint' => $shortEntryPoint,
    //     'fileName' => $fileName,
    //     'namespacepath' => $namespacePath,
    //     '$entryPoint' => $entryPoint,
    //     'path' => $path,
    //     'generatedFile' => $generatedFile,
    // ]); echo PHP_EOL;

    file_force_contents($generatedFile, $code);
    $n++;
	return $generatedFile;
}

function project_root( string $path ) {
    $oldDir = '';
    $currentDir = is_dir( $path ) ? $path : pathinfo( $path, PATHINFO_DIRNAME );
    while ( ! file_exists( $currentDir . "/composer.json" ) && $oldDir !== $currentDir ) {
        $oldDir = $currentDir;
        $currentDir = realpath( "$currentDir/../" );
    }
    return $currentDir;
}

function file_force_contents( $fullPath, $contents, $flags = 0 ){
    $parts = explode( '/', $fullPath );
    array_pop( $parts );
    $dir = implode( '/', $parts );

    if( !is_dir( $dir ) )
        mkdir( $dir, 0777, true );

    file_put_contents( $fullPath, $contents, $flags );
}
