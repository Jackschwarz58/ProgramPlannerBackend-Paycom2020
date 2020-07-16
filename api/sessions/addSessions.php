<?php
$_POST = json_decode(file_get_contents("php://input"), true); //Gets data passed from JS

switch ($_POST['functionname']) {
        //Adds a session to the session list with the sent data and creates a relationship between that session
        //and the user
    case 'addSession':
        $info = $_POST['session'];
        $uid = $_POST['userId'];

        //The first of 2 queries that inserts the session into the session table
        $addsql = "INSERT INTO `sessions` (`sessionName`, `sessionAttendees`, `sessionTime`, `sessionDesc`) VALUES (?, ?, ?, ?) ";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $addsql)) {
            header(SQLERROR);
            exit();
        } else {
            //Get all the user defined data ready
            mysqli_stmt_bind_param($stmt, "siis", $info['sessionName'], $info['sessionAttendees'], $info['sessionTime'], $info['sessionDesc']);
            if (mysqli_stmt_execute($stmt)) {

                //Gets the id of the just added session in order to create the relationship between the user and session
                $new_session_id = mysqli_insert_id($conn);

                //This adds the session/user to the join table
                $create_relation_sql = "INSERT INTO `users_sessions` (`user_id`, `session_id`) VALUES (?, ?)";

                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $create_relation_sql)) {
                    header(SQLERROR);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ii", $uid, $new_session_id); //Sends over the user and newly created session ID
                    if (mysqli_stmt_execute($stmt)) {
                        header(OPSUCCESS); //Good to go!
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

    case 'addRelationship': //Instead of creating a session and adding a relationship, it just adds a relationship between user and session
        $uid = $_POST['userId'];
        $sid = $_POST['sessionId'];

        $checksql = "SELECT * FROM users_sessions WHERE user_id = ? AND session_id = ?"; //Checks to make sure relationship doesnt already exist
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $checksql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result) > 0) { //If the relationship exists, no need to add a new one
                    header(RELATIONEXISTS);
                    exit();
                } else {

                    $sql = "INSERT INTO users_sessions (user_id, session_id) VALUES (?, ?)"; //Prepares new relationship
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header(SQLERROR);
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ii", $uid, $sid); //All it needs is user and session ID

                        if (mysqli_stmt_execute($stmt)) {
                            header(OPSUCCESS); //Everything worked!
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
