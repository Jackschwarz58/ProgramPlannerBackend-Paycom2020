<?php
require 'const.inc.php';
$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['loginSubmit'])) {
    require 'dbh.php';

    $state = $_POST['state'];
    $uid = $state['uid'];
    $pwd = $state['pwd'];

    $rememberUsr = $_POST['rememberUsr'];

    if (empty($uid) || empty($pwd)) {
        header(EMPTYFIELDS); //empty input fields
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidusers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR); //sql connection error
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($pwd, $row['pwdUsers']);

                if ($pwdCheck == false) {
                    header(PASSINCORRECT); //wrong password
                    exit();
                } elseif ($pwdCheck == true) {
                    $usrInfo = [];
                    $usrInfo['uid'] = $row['idUsers'];
                    $usrInfo['userName'] = $row['uidUsers'];
                    $usrInfo['email'] = $row['emailUsers'];
                    $usrInfo['test'] = $remember;

                    echo json_encode($usrInfo);
                    header(OPSUCCESS); //successful login
                    exit();
                } else {
                    header(PASSINCORRECT); //wrong password (default fallback)
                    exit();
                }
            } else {
                header(USERINCORRECT); //username not found
                exit();
            }
        }
    }
} else {
    header(NOTALLOWED);
    exit();
}
