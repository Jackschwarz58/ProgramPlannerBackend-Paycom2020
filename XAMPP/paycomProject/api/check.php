<?php
require 'const.inc.php';

if (isset($_COOKIE['login_usr_id'])) { //Checks if user has a set cookie
    header(COOKIECONFIRM);
    echo json_encode($_COOKIE); //Sends back user info
    exit();
} else {
    header(COOKIENOTFOUND);
    exit();
}
