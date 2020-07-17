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
        header(EMPTYFIELDS); //Something was not defined in the user form
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header(INVALIDUIDEMAIL); //Email isnt invalid and the user name contains invalid chars
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header(INVALIDEMAIL); //Email isnt valid
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header(INVALIDUID); //Invalid characters in the username
        exit();
    } elseif ($pwd !== $confirmPwd) {
        header(INVALIDPWDCHECK); //Passwords dont match
        exit();
    } else {
        $sql = "SELECT uidUsers FROM users WHERE uidusers=?"; //Queries SQL to see if username is found
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt); //To check number below

            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header(USERTAKEN); //If user row was returned, username is taken
                exit();
            } else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?,?,?)"; //Puts the necessary values into the database
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header(SQLERROR);
                    exit();
                } else {
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); //Hash password for security purposes

                    mysqli_stmt_bind_param($stmt, "sss", $uid, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);

                    header(OPSUCCESS); //Good to go!
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header(NOTALLOWED); //To ensure the only way this method can be reached is the register submit page
    exit();
}
