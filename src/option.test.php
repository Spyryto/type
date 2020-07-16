<?php declare(strict_types = 1);

use Type\None;
use Type\Option;
use Type\Some;
use Type\Type;

require_once __DIR__ . "/option.php";

describe("option"); ############################################################

Type :: option ( 'Bool', 'bool' );

// it("can create Option types", function () {
// 	$boolTrue = TestBoolOption::bool( true );
// 	$boolTrue->match(
// 		function ( SomeTestBool $true ) {
// 			expect( $true->value(), is( true ));
// 		},
// 		function () {
// 			throw new Exception( 'This should not be reached' );
// 		},
// 	);

// 	$boolNone = TestBoolOption::None();
// 	$boolNone->match(
// 		/** @suppress PhanUnusedClosureParameter  */
// 		function ( SomeTestBool $true ) {
// 			throw new Exception( 'This should not be reached' );
// 		},
// 		function () {
// 			expect( true, is( true ) );
// 		},
// 	);
// });


// describe("option Some");

// it( "is of expected types", function () {
// 	$boolOption = TestBoolOption::bool( true );
// 	expect( $boolOption, isA( 'Option' ) );
// 	expect( $boolOption, isA( 'Some' ) );
// });

// it( "throws when closure parameter type is not correct", function () {
// 	$throwing = function () {
// 		$boolTrue = TestBoolOption::bool( true );
// 		$boolTrue->match(
// 			function ( SomeBool $true ) {
// 				expect( $true->value(), is( true ));
// 			},
// 			function () {
// 				throw new Exception( 'This should not be reached' );
// 			},
// 		);
// 	};
// 	expect( $throwing, throwsA( TypeError::class) );
// });

// describe("option None");

// it( "is of expected types", function () {
// 	$boolOption = TestBoolOption::None();
// 	expect( $boolOption, isA( 'Option' ) );
// 	expect( $boolOption, isA( 'None' ) );
// });

it( "can create Option types", function () {
	$boolTrue = BoolOption::Some( true );
	$boolTrue->match(
		function ( SomeBool $true ) {
			expect( $true->value, is( true ));
		},
		function () {
			throw new Exception( 'This should not be reached' );
		}
	);

	$boolNone = BoolOption::None();
	$boolNone->match(
		/** @suppress PhanUnusedClosureParameter  */
		function ( SomeBool $true ) {
			throw new Exception( 'This should not be reached' );
		},
		function () {
			expect( true, is( true ) );
		}
	);
});

it( "has a ‘value’ property", function () {
	$boolTrue = BoolOption::Some( true );
	$boolTrue->match(
		function ( SomeBool $true ) {
			expect( $true->value, is( true ));
		},
		function () {
			throw new Exception( 'This should not be reached' );
		}
	);
});

describe("option Some"); #######################################################

it( "is of expected types", function () {
	$boolOption = BoolOption::Some( true );
	expect( $boolOption, isA( BoolOption :: class ) );
	expect( $boolOption, isA( Option :: class ) );
	expect( $boolOption, isA( Some :: class ) );
});

it( "throws when closure parameter type is not correct", function () {
	$throwing = function () {
		$boolTrue = BoolOption::Some( true );
		$boolTrue->match(
			function ( SomeBool $true ) {
				expect( $true->value, is( true ));
			},
			function () {
				throw new Exception( 'This should not be reached' );
			}
		);
	};
	expect( $throwing, throwsA( TypeError::class) );
});

describe("option None");

it( "is of expected types", function () {
	$boolOption = BoolOption::None();
	expect( $boolOption, isA( BoolOption :: class ) );
	expect( $boolOption, isA( Option :: class ) );
	expect( $boolOption, isA( None :: class ) );
});


describe( "option subclass" ); #################################################

class MaybeBool extends BoolOption {}

it( "is of expected type", function () {
	$maybeBool = MaybeBool::Some( true );
	expect( $maybeBool, isA( BoolOption :: class ) );
	expect( $maybeBool, isA( Option :: class ) );
	expect( $maybeBool, isA( Some :: class ) );
	$none = MaybeBool::None();
	expect( $none, isA( BoolOption :: class ) );
	expect( $none, isA( Option :: class ) );
	expect( $none, isA( None :: class ) );
});

it( "matches Some correctly", function () {
	$maybeBool = MaybeBool::Some( true );
	$reachedCode = [];
	$maybeBool->match(
		function ( SomeBool $true ) use ( &$reachedCode ) {
			$reachedCode[] = 'true branch';
			expect( $true->value, is( true ));
		},
		function () use ( &$reachedCode ) {
			$reachedCode[] = 'false branch';
			throw new Exception( 'This should not be reached' );
		}
	);
	expect( $reachedCode, is([ 'true branch' ]) );
});

it( "matches None correctly", function () {
	$none = MaybeBool::None();
	$reachedCode = [];
	$none->match(
		function ( SomeBool $true ) use ( &$reachedCode ) {
			$reachedCode[] = 'true branch';
			throw new Exception( 'This should not be reached' );
		},
		function () use ( &$reachedCode ) {
			$reachedCode[] = 'false branch';
			expect( true, is( true ));
		}
	);
	expect( $reachedCode, is([ 'false branch' ]) );
});
