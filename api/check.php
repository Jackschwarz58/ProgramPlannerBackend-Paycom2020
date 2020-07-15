<?php

require 'const.inc.php';

if (isset($_COOKIE['login_usr_id'])) {
    header(COOKIECONFIRM);
    echo json_encode($_COOKIE);
    exit();
} else {
    header(COOKIENOTFOUND);
    exit();
}
