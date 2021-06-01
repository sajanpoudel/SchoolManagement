<?php
// Checks for the student registration form.

/** True for a plausible email address. */
function isValidEmail($email)
{
    return filter_var(trim((string) $email), FILTER_VALIDATE_EMAIL) !== false;
}
