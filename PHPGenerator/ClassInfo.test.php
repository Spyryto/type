<?php declare( strict_types = 1 );

namespace PHPGenerator;

require_once __DIR__ . "/ClassInfo.php";

describe( "ClassInfo" );

it( "computes correct name of native class", function () {
	$classInfo = new ClassInfo( "string" );
	expect( $classInfo->name, is( "string" ));
});

it( "computes correct name of custom class", function () {
	$classInfo = new ClassInfo( "className" );
	expect( $classInfo->name, is( "className" ));
});

it( "computes correct name of custom class with namespace", function () {
	$classInfo = new ClassInfo( "outer\\inner\\className" );
	expect( $classInfo->name, is( "className" ));
});

it( "computes correct name of default namespace", function () {
	$classInfo = new ClassInfo( "className" );
	expect( $classInfo->namespace, is( "" ));
});

it( "computes correct name of custom namespace", function () {
	$classInfo = new ClassInfo( "outer\\inner\\className" );
	expect( $classInfo->namespace, is( "outer\\inner" ));
});

it( "computes correct path of custom class", function () {
	$classInfo = new ClassInfo( "className" );
	expect( $classInfo->path, is( [] ));
});

it( "computes correct path of custom class with namespace", function () {
	$classInfo = new ClassInfo( "outer\\inner\\className" );
	expect( $classInfo->path, is([ "outer", "inner" ]));
});

it( "computes correct namespace declaration of native class", function () {
	$classInfo = new ClassInfo( "string" );
	expect( $classInfo->namespaceDeclaration, is( "" ));
});

it( "computes correct namespace declaration of custom class", function () {
	$classInfo = new ClassInfo( "className" );
	expect( $classInfo->namespaceDeclaration, is( "" ));
});

it( "computes correct namespace declaration of custom class with namespace", function () {
	$classInfo = new ClassInfo( "outer\\inner\\className" );
	expect( $classInfo->namespaceDeclaration, is( "namespace outer\\inner;" ));
});

it( "computes correct fullName of native class", function () {
	$classInfo = new ClassInfo( "string" );
	expect( $classInfo->fullName, is( "string" ));
});

it( "computes correct fullName of custom class", function () {
	$classInfo = new ClassInfo( "className" );
	expect( $classInfo->fullName, is( "className" ));
});

it( "computes correct fullName of custom class with namespace", function () {
	$classInfo = new ClassInfo( "outer\\inner\\className" );
	expect( $classInfo->fullName, is( "outer\\inner\\className" ));
});