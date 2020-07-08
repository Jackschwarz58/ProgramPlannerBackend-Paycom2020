<?php
$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['loginSubmit'])) {
    require 'dbh.php';

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];
    echo json_encode($uid);
    echo json_encode($pwd);


    if (empty($uid) || empty($pwd)) {
        header('X-PHP-Response-Code: 405', true, 405); //empty fields
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('X-PHP-Response-Code: 410', true, 410); //sqlerror
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($pwd, $row['pwdUsers']);

                if ($pwdCheck == false) {
                    header('X-PHP-Response-Code: 406', true, 406); //wrongpass
                    exit();
                } elseif ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];

                    header('X-PHP-Response-Code: 200', true, 200); //Success!
                    exit();
                } else {
                    header('X-PHP-Response-Code: 407', true, 407); //wrongpass
                    exit();
                }
            } else {
                header('NoUserFound', true, 404); //nouser
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
