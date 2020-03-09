<?php
require_once __DIR__ . '/../src/Auth.php';

check('an empty session is not logged in', !isLoggedIn([]));
check('an empty login name is not logged in', !isLoggedIn(['login' => '']));
check('a session with a login name is logged in', isLoggedIn(['login' => 'admin']));
