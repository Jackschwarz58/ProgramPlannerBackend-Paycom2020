<?php
require 'const.inc.php';

if (isset($_COOKIE['login_usr_id'])) { //Makes sure cookie is present, if you're logging out it should be

    //Removes the 3 cookie values and sets them to expire an hour ago
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

    header(COOKIESDELETED); //Success code
    exit();
} else {
    header(COOKIEERROR); //No Cookie Found
    exit();
}
