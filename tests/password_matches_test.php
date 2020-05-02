<?php
// Checks for DbFunction::passwordMatches. Run through tests/run.php.
require_once __DIR__ . '/../config/DbFunction.php';

$obj = new DbFunction();
$method = new ReflectionMethod('DbFunction', 'passwordMatches');
if (PHP_VERSION_ID < 80100) {
    $method->setAccessible(true);
}
$match = function ($input, $stored) use ($obj, $method) {
    return $method->invoke($obj, $input, $stored);
};

check('plain text password matches', $match('admin', 'admin') === true);
check('wrong plain text password is rejected', $match('guess', 'admin') === false);
$hash = password_hash('secret', PASSWORD_BCRYPT);
check('bcrypt hash matches the right password', $match('secret', $hash) === true);
check('bcrypt hash rejects a wrong password', $match('other', $hash) === false);
check('empty input never matches', $match('', 'admin') === false);
