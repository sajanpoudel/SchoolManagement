<?php
// Runs every *_test.php file in this folder. Exit code 1 when a check fails.
$failures = 0;
$checks = 0;

function check($label, $condition)
{
    global $failures, $checks;
    $checks++;
    if (!$condition) {
        $failures++;
        echo "FAIL: $label\n";
    }
}

foreach (glob(__DIR__ . '/*_test.php') as $file) {
    require $file;
}

echo "$checks checks, $failures failures\n";
exit($failures === 0 ? 0 : 1);
