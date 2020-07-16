<?php declare( strict_types = 1 );

use Type\Type;

require_once __DIR__ . "/collection.php";

describe( "collection" );

Type :: collectionOf ( 'int' );

it( "creates a collection of the specified class", function () {
	$collectionOfInt = new CollectionOfInt();
	expect( $collectionOfInt, isA( 'CollectionOfInt' ));
});

it( "can iterate through values", function () {
	$ints = new CollectionOfInt( 1, 2, 3 );
	$total = 0;
	foreach ( $ints as $int ) {
		$total += $int;
	}
	expect( $total, is( 6 ) );
});

describe( "collectionOf<T>" );

it( "offset can be read", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	expect( $squares[3], is( 9 ));
});

it( "offset can be read and is of expected type", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	expect( $squares[3], is( 9 ));
	$type = gettype( $squares[3] );
	expect( $type, is( 'integer' ));
});

it( "out-of-bounds offset throws", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	$outOfBoundReader = function () use ( $squares ) {
		return $squares[ 11 ];
	};
	expect( $outOfBoundReader, throws() );
});

it( "offset cannot be set", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	$offsetWriter = function () use ( &$squares ) {
		$squares[ 5 ] = 25;
	};
	expect( $offsetWriter, throws() );
});

it( "offset can be checked", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	expect( isset( $squares[3] ), is( true ) );
	$squareOfFour = $squares[4];
	expect( $squareOfFour, is( 16 ) );
});

it( "offset cannot be set", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	$offsetWriter = function () use ( &$squares ) {
		$squares[ 5 ] = 25;
	};
	expect( $offsetWriter, throws() );
});

it( "offset cannot be unset", function () {
	$squares = new CollectionOfInt( 0, 1, 4, 9, 16 );
	$offsetRemover = function () use ( &$squares ) {
		unset( $squares[ 5 ] );
	};
	expect( $offsetRemover, throws() );
});

describe( "collectionOf<T>->map" );

it( "must declare closure parameter type", function () {
	$squares = (new CollectionOfInt( 0, 1, 2, 3 ))
		->map( function ( int $n ) {
			return $n * $n;
		});
	expect( $squares[2], is( 4 ) );
});

it( "throws when closure parameter type does not match", function () {
	$throwing = function () {
		(new CollectionOfInt( 0, 1, 2, 3 ))->map( function ( string $n ) {
			return $n . $n;
		});
	};
	expect( $throwing, throwsA( 'InvalidArgumentException' ) );
});

it( "throws when closure parameter is missing", function () {
	$throwing = function () {
		(new CollectionOfInt( 0, 1, 2, 3 ))->map( function () {
			return 1;
		});
	};
	expect( $throwing, throwsA( 'LengthException' ) );
});


it( "throws when closure parameter type is not specified", function () {
	$throwing = function () {
		(new CollectionOfInt( 0, 1, 2, 3 ))->map( function ( $n ) {
			return $n * $n;
		});
	};
	expect( $throwing, throwsA( 'InvalidArgumentException' ) );
});