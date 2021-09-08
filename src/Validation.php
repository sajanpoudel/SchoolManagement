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

/** True for a name made of letters, spaces, dots, apostrophes and hyphens (2 to 60 characters). */
function isValidName($name)
{
    $name = trim((string) $name);
    return strlen($name) >= 2 && strlen($name) <= 60 && preg_match("/^[A-Za-z][A-Za-z .'-]*$/", $name) === 1;
}

/** Collects the problems of a registration form. Returns a list of messages, empty when all is fine. */
function registrationErrors(array $form)
{
    $errors = [];
    if (!isValidName($form['fname'] ?? '')) {
        $errors[] = 'Enter a valid first name.';
    }
    if (!isValidEmail($form['email'] ?? '')) {
        $errors[] = 'Enter a valid email address.';
    }
    if (!isValidMobile($form['mobno'] ?? '')) {
        $errors[] = 'Enter a valid mobile number.';
    }
    return $errors;
}
