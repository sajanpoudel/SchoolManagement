<?php
require_once __DIR__ . '/../src/Validation.php';

check('a normal email is valid', isValidEmail('student@example.com'));
check('an email with spaces around it is accepted', isValidEmail('  student@example.com '));
check('broken emails are rejected', !isValidEmail('') && !isValidEmail('student') && !isValidEmail('a@') && !isValidEmail('@b.com'));
