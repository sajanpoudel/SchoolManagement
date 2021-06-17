<?php
require_once __DIR__ . '/../src/Validation.php';

check('a normal email is valid', isValidEmail('student@example.com'));
