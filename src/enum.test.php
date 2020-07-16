<?php declare(strict_types = 1);

// namespace EnumTest;

use Type\{Type};

require_once __DIR__ . "/enum.php";


Type :: enum ( 'TicTacToeResult',
	'X', 'O', 'Draw'
);


describe("enum");


it( "creates the specified class", function () {
	expect( class_exists( TicTacToeResult :: class, true ), is( true ));
});

it( "creates class that cannot be instantiated", function () {
	$instanceTest = function () {
		return new TicTacToeResult();
	};
	expect( $instanceTest, throws() );
});

it( "creates class with static constructors", function () {
	$winnerIsX = TicTacToeResult::X();
	$winnerIsO = TicTacToeResult::O();
	$noWinners = TicTacToeResult::Draw();
	expect( $winnerIsX, isA( TicTacToeResult :: class ));
	expect( $winnerIsO, isA( TicTacToeResult :: class ));
	expect( $noWinners, isA( TicTacToeResult :: class ));
});

describe("enum match method");

it("matches all cases", function () {
	$winner = TicTacToeResult::X();
	$winnerName = '';
	$winner->match(
		function (X $x) use ( &$winnerName ) { $winnerName = 'X'; },
		function (O $x) use ( &$winnerName ) { $winnerName = 'O'; },
		function (Draw $x) use ( &$winnerName ) { $winnerName = 'none'; }
	);
	expect( $winnerName, is( 'X' ));
});

it("expect all types to be specified", function () {
	$throwing = function () {
		$winner = TicTacToeResult::X();
		$winnerName = '';
		$winner->match(
			function (/* no type */ $x) use ( &$winnerName ) { $winnerName = 'X'; },
			function (O $x) use ( &$winnerName ) { $winnerName = 'O'; },
			function (Draw $x) use ( &$winnerName ) { $winnerName = 'none'; }
		);
	};
	expect( $throwing, throws() );
});



/*

it("creates accessors for all fields", function () {
	expect( method_exists( 'TestRecord', 'name' ), is( true ));
	expect( method_exists( 'TestRecord', 'value' ), is( true ));
});

it("creates a working object", function () {
	$one = new TicTacToeResult();
	expect( $one->name(), is( 'one' ));
});

it("creates factory function for the class", function () {
	expect( function_exists( 'testRecord' ), is( true ));
	$three = testRecord( 'three', 3 );
	expect( $three instanceof TestRecord, is( true ));
});

*/