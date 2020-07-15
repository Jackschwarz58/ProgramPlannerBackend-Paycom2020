<?php
$_POST = json_decode(file_get_contents("php://input"), true);

switch ($_POST['functionname']) {
    case 'addSession':
        $info = $_POST['session'];
        $uid = $_POST['userId'];

        $addsql = "INSERT INTO `sessions` (`sessionName`, `sessionAttendees`, `sessionTime`, `sessionDesc`) VALUES (?, ?, ?, ?) ";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $addsql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "siis", $info['sessionName'], $info['sessionAttendees'], $info['sessionTime'], $info['sessionDesc']);
            if (mysqli_stmt_execute($stmt)) {

                $new_session_id = mysqli_insert_id($conn);

                $create_relation_sql = "INSERT INTO `users_sessions` (`user_id`, `session_id`) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $create_relation_sql)) {
                    header(SQLERROR);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ii", $uid, $new_session_id);
                    if (mysqli_stmt_execute($stmt)) {
                        header(OPSUCCESS);
                        exit();
                    } else {
                        header(SQLERROR);
                        exit();
                    }
                }
            } else {
                echo json_encode($info);
                header(SQLERROR);
                exit();
            }
        }

    case 'addRelationship':
        $uid = $_POST['userId'];
        $sid = $_POST['sessionId'];


        $checksql = "SELECT * FROM users_sessions WHERE user_id = ? AND session_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $checksql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result) > 0) {
                    header(RELATIONEXISTS);
                    exit();
                } else {
                    $sql = "INSERT INTO users_sessions (user_id, session_id) VALUES (?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header(SQLERROR);
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

                        if (mysqli_stmt_execute($stmt)) {

                            header(OPSUCCESS);
                            exit();
                        } else {
                            header(SQLERROR);
                            exit();
                        }
                    }
                }
            } else {
                header(SQLERROR);
                exit();
            }
        }
}
