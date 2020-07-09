<?php
require 'const.inc.php';
$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['signupSubmit'])) {
    require "dbh.php";
    
    $state = $_POST['state'];
    $uid = $state['uid'];
    $email = $state['email'];
    $pwd = $state['pwd'];
    $confirmPwd = $state['confirmPwd'];

    if (empty($uid) || empty($email) || empty($pwd) || empty($confirmPwd)) {
        header(EMPTYFIELDS);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header(INVALIDUIDEMAIL);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header(INVALIDEMAIL);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header(INVALIDUID);
        exit();
    } elseif ($pwd !== $confirmPwd) {
        header(INVALIDPWDCHECK);
        exit();
    } else {
        $sql = "SELECT uidUsers FROM users WHERE uidusers=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header(USERTAKEN);
                exit();
            } else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header(SQLERROR);
                    exit();
                } else {
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $uid, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header(OPSUCCESS);
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header(NOTALLOWED);
    exit();
}
