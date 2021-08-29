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

/** For the AJAX endpoints: answers 401 instead of redirecting, because the caller is a script. */
function requireLoginAjax()
{
    if (!isLoggedIn($_SESSION)) {
        http_response_code(401);
        exit;
    }
}
