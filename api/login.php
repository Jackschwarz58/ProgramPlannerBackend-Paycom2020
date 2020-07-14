<?php
require 'const.inc.php';
$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['loginSubmit'])) {
    require 'dbh.php';

    $state = $_POST['state'];
    $uid = $state['uid'];
    $pwd = $state['pwd'];

    $cookie_expiration_time = 0;
    if($_POST['rememberUsr']) {
      echo json_encode('RememberUsr Set');
      $cookie_expiration_time = time()+60*60*24*30;
    }

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

                    $user['uid'] = $row['idUsers'];
                    $user['userName'] = $row['uidUsers'];
                    $user['email'] = $row['emailUsers'];

                    setcookie('login_usr_name', $user['userName'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' =>'Lax',
                    ]);
                    setcookie('login_usr_email', $user['email'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' =>'Lax',
                    ]);
                    setcookie('login_usr_id', $user['uid'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' =>'Lax',
                    ]);
                    echo json_encode($user);

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
