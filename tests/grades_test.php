<?php
require_once __DIR__ . '/../src/Grades.php';

check('percentage of half the marks', percentage(50, 100) === 50.0);
check('percentage rounds to two decimals', percentage(1, 3) === 33.33);
check('percentage of zero full marks is zero', percentage(10, 0) === 0.0);
check('percentage of full marks is one hundred', percentage(80, 80) === 100.0);
check('80 and above is an A', gradeFor(80) === 'A' && gradeFor(100) === 'A');
check('65 to 79 is a B', gradeFor(65) === 'B' && gradeFor(79.99) === 'B');
check('50 to 64 is a C', gradeFor(50) === 'C' && gradeFor(64.9) === 'C');
check('40 to 49 is a D', gradeFor(40) === 'D' && gradeFor(49.99) === 'D');
check('below 40 is an F', gradeFor(39.99) === 'F' && gradeFor(0) === 'F');
