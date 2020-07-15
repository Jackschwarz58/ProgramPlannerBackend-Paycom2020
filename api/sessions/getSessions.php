<?php

$_POST = json_decode(file_get_contents("php://input"), true);

switch ($_POST['functionname']) {
    case 'getUserSessions':
        $uid = $_POST['userId'];

        $sql = "SELECT sessions.* FROM sessions INNER JOIN users_sessions ON sessions.sessionId = users_sessions.session_id 
      INNER JOIN users ON users.idUsers = users_sessions.user_id WHERE users.idUsers = ?";

        $stmt = mysqli_stmt_init($conn);
        $sessions = [];

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR); //FAIL POINT HERE
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $uid);
            if (mysqli_stmt_execute($stmt)) {

                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {
                    $sessions[] = $row;
                }

                echo json_encode($sessions);
                header(OPSUCCESS);
                exit();
            } else {
                header(SQLERROR);
                exit();
            }
        }
    case 'getAllSessions':
        $sql = "SELECT * FROM sessions";

        $stmt = mysqli_stmt_init($conn);
        $sessions = [];
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR); //FAIL POINT HERE
            exit();
        } else {
            if (mysqli_stmt_execute($stmt)) {

                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $sessions[] = $row;
                }

                echo json_encode($sessions);
                header(OPSUCCESS);
                exit();
            } else {
                header(SQLERROR);
                exit();
            }
        }
}
