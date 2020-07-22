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
