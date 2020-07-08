<?php
require 'const.inc.php';

$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['loginSubmit'])) {
    require 'dbh.php';

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];


    if (empty($uid) || empty($pwd)) {
        header(EMPTYFIELDS); //empty fields
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR); //sqlerror
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($pwd, $row['pwdUsers']);

                if ($pwdCheck == false) {
                    header(PASSINCORRECT); //wrongpass
                    exit();
                } elseif ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];

                    header(LOGINSUCCESS);
                    exit();
                } else {
                    header(PASSINCORRECT);
                    exit();
                }
            } else {
                header(USERINCORRECT); //nouser
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
