<?php declare(strict_types = 1);

use Type\Type;

require_once __DIR__ . "/wrapper.php";

describe( 'wrapper' );

Type :: wrapper ( 'RelativeNumber', 'int' );

it("creates the specified class", function () {
	expect( class_exists( 'RelativeNumber' ), is( true ));
});

it("creates an object from the specified wrapped type", function () {
	$n = new RelativeNumber( 5 );
	expect( $n, isA( 'RelativeNumber' ) );
});

it( "has a ‘value’ property", function () {
	$n = new RelativeNumber( 7 );
	expect( $n->value, is( 7 ));
});



Type :: wrapper ( 'WholeNumber', RelativeNumber :: class );

it("can wrap another wrapper", function () {
	$n = new WholeNumber( new RelativeNumber( 5 ));
	expect( $n, isA( 'WholeNumber'));
	expect( $n->value, isA( 'RelativeNumber'));
});

class PositiveInt extends RelativeNumber {
    public function __construct( int $n ) {
        if ($n < 0) throw new Exception( "$n must be a positive integer" );
        parent::__construct($n);
    }
}

describe( 'PositiveInt' );

it("creates an object from an int", function () {
	$n = new PositiveInt( 5 );
	expect( $n, isA( 'PositiveInt' ) );
	expect( $n->value, is( 5 ));
});

it("throws when passsed a negative number", function () {
	$negativeTest = function () {
		return new PositiveInt( -2 );
	};
	expect( $negativeTest, throws() );
});

function PositiveInt( int $n ) {
	return new PositiveInt( $n );
}

it("has a convenient function named after the class", function () {
	$n = PositiveInt( 5 );
	expect( $n, isA( 'PositiveInt' ) );
	expect( $n->value, is( 5 ));
});

it("has a convenient function that throws on invalid input", function () {
	$negativeTest = function () {
		return PositiveInt( -2 );
	};
	expect( $negativeTest, throws() );
});


