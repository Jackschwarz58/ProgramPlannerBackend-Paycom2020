<?php
$_POST = json_decode(file_get_contents("php://input"), true); //Get passed data

switch ($_POST['functionname']) {
    case 'getUserSessions': //Only gets the sessions that have a relationship with the user
        $uid = $_POST['userId'];

        $sql = "SELECT sessions.* FROM sessions INNER JOIN users_sessions ON sessions.sessionId = users_sessions.session_id 
      INNER JOIN users ON users.idUsers = users_sessions.user_id WHERE users.idUsers = ?"; //Queries for all relationships between session/user

        $stmt = mysqli_stmt_init($conn);
        $sessions = []; //Array to hold the returned sessions

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header(SQLERROR);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $uid); //Only need the user id to find the user realationships

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt); //Gets query result

                while ($row = mysqli_fetch_assoc($result)) {
                    $sessions[] = $row; //Adds all result rows into the session array
                }

                echo json_encode($sessions); //Sends back list to JS
                header(OPSUCCESS);
                exit();
            } else {
                header(SQLERROR);
                exit();
            }
        }
    case 'getAllSessions': //Gets a list of all created sessions regardless of relationship
        $sql = "SELECT * FROM sessions"; //Simply grabs all sessions

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

                echo json_encode($sessions); //Sends back list of all the sessions to JS for NavBar use
                header(OPSUCCESS);
                exit();
            } else {
                header(SQLERROR);
                exit();
            }
        }
}
