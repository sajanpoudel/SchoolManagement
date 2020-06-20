<?php
require_once __DIR__ . '/../src/Grades.php';

check('percentage of half the marks', percentage(50, 100) === 50.0);
