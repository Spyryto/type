<?php declare(strict_types = 1);

use Type\Type;

require_once __DIR__ . "/record.php";

describe("record");

Type :: record( 'TestRecord', [
	'name' => 'string',
	'value' => 'int',
]);

it("creates the specified class", function () {
	expect( class_exists( 'TestRecord' ), is( true ));
});

it("creates a working object", function () {
	$one = new TestRecord( 'one', 1 );
	$two = new TestRecord( 'two', 2 );
	expect( $one->name, is( 'one' ));
	expect( $two->value, is( 2 ));
});

it( "creates properties for all fields", function () {
	$one = new TestRecord( 'one', 1 );
	expect( $one->name, is( 'one' ));
	expect( $one->value, is( 1 ));
});

/*
it("creates namespaced functions for data instantiation", function () {
	$one = testRecord(
		TestRecord\name('one'),
		TestRecord\value(1)
	);
	expect( $one->name(), is( 'one' ));
});

it("implements Builder pattern for instantiation", function () {
	$test = (new TestRecordFactory())
	->name( 'one' )
	->value( 1 )
	->create();
});

it("implements Builder pattern with new for instantiation", function () {
	$test = TestRecordFactory::new()
		->name( 'one' )
		->value( 1 )
		->create();
	expect( $test instanceof TestRecord, is( true ));
});
*/