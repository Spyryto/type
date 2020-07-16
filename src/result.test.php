<?php declare(strict_types = 1);

use Type\Type;
use IntResult as Result;

require_once __DIR__ . "/result.php";

describe("result"); ############################################################

Type :: wrapper ( 'IntValue', 'int' );
Type :: result ( 'IntResult', IntValue :: class, Error :: class, '' );

it( "can create Result types", function () {
	$intSuccess = Result::Success( new IntValue( 4 ));
	expect( $intSuccess, isA( Result :: class ));
});

it( "can match on success", function () {
	$intSuccess = Result::Success( new IntValue( 5 ));
	$intSuccess->match(
		// function ( Success‹IntValue› $ok )
		function ( IntResultOK $ok )
		{
			expect( $ok->value->value, is( 5 ));
			expect( $ok->value, isA( IntValue :: class ));
		},
		// function ( Failure‹Error› $error) { return $error->value; }
		function ( IntResultError $error) { return $error->value; }
	);
});

it( "can match on failure", function () {
	$intFailure = Result::Failure( new Error( 'generic error' ));
	$intFailure->match(
		// function ( Success‹IntValue› $ok )
		function ( IntResultOK $ok )
		{
		},
		// function ( Failure‹Error› $error)
		function ( IntResultError $error)
		{
			expect( $error->value, isA( Error :: class ));
		}
	);
});