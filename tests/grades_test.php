<?php
require_once __DIR__ . '/../src/Grades.php';

check('percentage of half the marks', percentage(50, 100) === 50.0);
check('percentage rounds to two decimals', percentage(1, 3) === 33.33);
