<?php
// Checks for the student registration form.

/** True for a plausible email address. */
function isValidEmail($email)
{
    return filter_var(trim((string) $email), FILTER_VALIDATE_EMAIL) !== false;
}

/** True for a mobile number of 7 to 15 digits, optionally starting with a plus sign. */
function isValidMobile($number)
{
    return preg_match('/^\+?[0-9]{7,15}$/', preg_replace('/[\s-]/', '', (string) $number)) === 1;
}
