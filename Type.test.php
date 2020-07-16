<?php declare( strict_types = 1 );

require_once __DIR__ . "/Type.implementation.php";

use Type\Type;

describe( "Type classes autoloading" );

it( "loads newly defined collectionOf", function () {
	Type::collectionOf('bool');
	$text = new CollectionOfBool();
});

it( "loads newly defined enum", function () {
	Type::enum('YesNo', 'Yes', 'No');
	$boolean = YesNo::Yes();
});

it( "loads a newly defined option", function () {
	Type::option('YesNo', YesNo :: class);
	$boolOption = YesNoOption::Some( YesNo::Yes() );
});

it( "loads a newly defined wrapper", function () {
	Type::wrapper('BoolWrapper', YesNo :: class);
	$text = new BoolWrapper( YesNo::Yes() );
});

it( "loads a newly defined record", function () {
	Type::record('CookieSettings', [
		'technical' => YesNo :: class,
		'profiling' => YesNo :: class,
	]);
	$cookie = new CookieSettings(
		YesNo::Yes(),
		YesNO::No()
	);
});