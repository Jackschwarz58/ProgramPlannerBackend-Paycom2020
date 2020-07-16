<?php
require 'const.inc.php';
$_POST = json_decode(file_get_contents("php://input"), true); //Gets data sent over from JS

if (isset($_POST['loginSubmit'])) { //Makes sure the request is from the correct origin
    require 'dbh.php';

    $state = $_POST['state'];
    $uid = $state['uid'];
    $pwd = $state['pwd'];

    $cookie_expiration_time = 0; //By default the cookie is set to end at browser session end

    if ($_POST['rememberUsr']) {
        $cookie_expiration_time = time() + 60 * 60 * 24 * 30; //If the user selected remeber me, then it sets expiration a month away
    }

    if (empty($uid) || empty($pwd)) {
        header(EMPTYFIELDS); //empty input fields
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidusers=? OR emailUsers=?;"; //Pulls user based on either email or username
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR); //sql connection error
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) { //If something was found in the query

                $pwdCheck = password_verify($pwd, $row['pwdUsers']); //Checks pass against hashed pass in the database

                if ($pwdCheck == false) {
                    header(PASSINCORRECT); //wrong password
                    exit();
                } elseif ($pwdCheck == true) {

                    $user['uid'] = $row['idUsers']; //Makes a user object to send back to JS for confirmation
                    $user['userName'] = $row['uidUsers'];
                    $user['email'] = $row['emailUsers'];

                    //Sets cookie for the user to be consistently logged in throughout either the session or longer
                    //depending on the 'remember me' check defined on the log in page
                    setcookie('login_usr_name', $user['userName'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' => 'Lax',
                    ]);
                    setcookie('login_usr_email', $user['email'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' => 'Lax',
                    ]);
                    setcookie('login_usr_id', $user['uid'], [
                        'expires' => $cookie_expiration_time,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => false,
                        'samesite' => 'Lax',
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
    header(NOTALLOWED); //No access if the request is from the incorrect origin
    exit();
}
