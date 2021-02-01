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
check('passing every subject passes', hasPassed([40, 55, 90]) === true);
check('one failed subject fails', hasPassed([90, 39.9, 80]) === false);
check('no subjects is not a pass', hasPassed([]) === false);
check('the pass mark can be changed', hasPassed([45, 50], 50) === false && hasPassed([50, 60], 50) === true);
$summary = summarize([[70, 100], [50, 100], [90, 100]]);
check('summary adds up the marks', $summary['obtained'] === 210 && $summary['full'] === 300);
check('summary computes the percentage and grade', $summary['percentage'] === 70.0 && $summary['grade'] === 'B');
