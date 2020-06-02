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
