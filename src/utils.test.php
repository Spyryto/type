<?php declare(strict_types = 1);

namespace Type;

require_once __DIR__ . "/../Utils/Utils.php";

describe("nl");

it("works with simple arrays", function () {
	expect( nl( [1, 2, 3] ), equals( "1" . PHP_EOL . "2" . PHP_EOL . "3" ));
});

it("returns empty string when array is empty", function () {
	expect(nl([]), equals(''));
});

describe("comma_nl");

it("works with simple arrays", function () {
	expect( comma_nl( [1, 2, 3] ), equals( "1," . PHP_EOL . "2," . PHP_EOL . "3" ));
});

describe("array_equal");

it("works with identical arrays", function () {
	$array1 = [1, 2, 3];
	$array2 = [1, 2, 3];
	expect( array_equal( $array1, $array2 ), is( true ));
});

it("works with non identical arrays", function () {
	$array1 = [1, 2, 3];
	$array2 = [3, 2, 1];
	expect( array_equal( $array1, $array2 ), is( true ));
});

