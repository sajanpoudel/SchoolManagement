<?php
// Access check for the admin pages.

/** True when the session belongs to a signed in admin. */
function isLoggedIn(array $session)
{
    return isset($session['login']) && $session['login'] !== '';
}

/** Sends visitors who are not signed in to the landing page and stops the script. */
function requireLogin()
{
    if (!isLoggedIn($_SESSION)) {
        header('location:../index.php');
        exit;
    }
}
