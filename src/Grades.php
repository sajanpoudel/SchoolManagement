<?php
// Marks and grades for the marksheet. Pure functions, so they are easy to test.

/** Percentage of full marks, rounded to two decimals. Full marks of 0 give 0. */
function percentage($obtained, $full)
{
    if ($full <= 0) {
        return 0.0;
    }
    return round(($obtained / $full) * 100, 2);
}

/** Letter grade for a percentage: A from 80, B from 65, C from 50, D from 40, otherwise F. */
function gradeFor($percentage)
{
    if ($percentage >= 80) {
        return 'A';
    }
    if ($percentage >= 65) {
        return 'B';
    }
    if ($percentage >= 50) {
        return 'C';
    }
    if ($percentage >= 40) {
        return 'D';
    }
    return 'F';
}

/** True when every subject reached the pass mark (40 percent unless another one is given). */
function hasPassed(array $percentages, $passMark = 40)
{
    if (count($percentages) === 0) {
        return false;
    }
    foreach ($percentages as $value) {
        if ($value < $passMark) {
            return false;
        }
    }
    return true;
}

/**
 * Summary of a result: total, percentage, grade and the pass decision.
 * $marks is a list of [obtained, full] pairs, one for each subject.
 */
function summarize(array $marks)
{
    $obtained = 0;
    $full = 0;
    $percentages = [];
    foreach ($marks as $pair) {
        $obtained += $pair[0];
        $full += $pair[1];
        $percentages[] = percentage($pair[0], $pair[1]);
    }
    $overall = percentage($obtained, $full);
    return [
        'obtained' => $obtained,
        'full' => $full,
        'percentage' => $overall,
        'grade' => gradeFor($overall),
        'passed' => hasPassed($percentages),
    ];
}
