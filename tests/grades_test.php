<?php
require_once __DIR__ . '/../src/Grades.php';

check('percentage of half the marks', percentage(50, 100) === 50.0);
check('percentage rounds to two decimals', percentage(1, 3) === 33.33);
check('percentage of zero full marks is zero', percentage(10, 0) === 0.0);
check('percentage of full marks is one hundred', percentage(80, 80) === 100.0);
