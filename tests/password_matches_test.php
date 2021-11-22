<?php
// Run with: php tests/password_matches_test.php
require __DIR__ . '/../config/DbFunction.php';

$obj = new DbFunction();
$method = new ReflectionMethod('DbFunction', 'passwordMatches');
if (PHP_VERSION_ID < 80100) {
	$method->setAccessible(true);
}
$check = function ($input, $stored) use ($obj, $method) {
	return $method->invoke($obj, $input, $stored);
};

$failures = 0;
$expect = function ($label, $actual, $expected) use (&$failures) {
	if ($actual !== $expected) {
		echo "FAIL: $label\n";
		$failures++;
	} else {
		echo "ok:   $label\n";
	}
};

$expect('plain text password matches', $check('admin', 'admin'), true);
$expect('wrong plain text password is rejected', $check('guess', 'admin'), false);
$hash = password_hash('secret', PASSWORD_BCRYPT);
$expect('bcrypt hash matches the right password', $check('secret', $hash), true);
$expect('bcrypt hash rejects a wrong password', $check('other', $hash), false);
$expect('empty input never matches', $check('', 'admin'), false);

exit($failures === 0 ? 0 : 1);
