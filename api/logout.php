<?php
require 'const.inc.php';

if (isset($_COOKIE['login_usr_id'])) {

    setcookie('login_usr_name', "", [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => false,
        'samesite' => 'Lax',
    ]);
    setcookie('login_usr_email', "", [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => false,
        'samesite' => 'Lax',
    ]);
    setcookie('login_usr_id', "", [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => false,
        'samesite' => 'Lax',
    ]);

    header(COOKIESDELETED);
    exit();
} else {
    header(COOKIEERROR);
    exit();
}
