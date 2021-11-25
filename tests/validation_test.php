<?php
require_once __DIR__ . '/../src/Validation.php';

check('a normal email is valid', isValidEmail('student@example.com'));
check('an email with spaces around it is accepted', isValidEmail('  student@example.com '));
check('broken emails are rejected', !isValidEmail('') && !isValidEmail('student') && !isValidEmail('a@') && !isValidEmail('@b.com'));
check('local and international numbers are valid', isValidMobile('9866656576') && isValidMobile('+977 986-665-6576'));
check('short numbers and letters are invalid', !isValidMobile('12345') && !isValidMobile('98a6656576') && !isValidMobile(''));
check('ordinary names are valid', isValidName('Sajan Poudel') && isValidName("O'Neil") && isValidName('Anne-Marie'));
check('digits and one letter names are invalid', !isValidName('Sajan 2') && !isValidName('S') && !isValidName(''));
check('a good form has no errors', registrationErrors(['fname' => 'Sajan', 'email' => 's@example.com', 'mobno' => '9866656576']) === []);
check('an empty form has three errors', count(registrationErrors([])) === 3);
check('only the bad field is reported', registrationErrors(['fname' => 'Sajan', 'email' => 'nope', 'mobno' => '9866656576']) === ['Enter a valid email address.']);
