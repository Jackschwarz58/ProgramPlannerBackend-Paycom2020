<?php
$_POST = json_decode(file_get_contents("php://input"), true); //Get data passed

switch ($_POST['functionname']) {
    case 'editSession': //Just updates the session data in the db with the passed data from JS
        $info = $_POST['session'];

        if (sizeof($info) > 5) { //Makes sure all of the information required is here
            header(EDITFIELDNOTFOUND); //Error code if missing info
            exit();
        } else {

            foreach ($info as $value) { //Makes sure all the infor has values. Otherwise, you cant save
                if (isset($value)) {
                    continue;
                } else {
                    header(EDITFIELDNOTFOUND);
                    exit();
                }
            }

            $sql = "UPDATE `sessions` SET `sessionId` = ?, `sessionName` = ?,
            `sessionAttendees` = ?, `sessionTime` = ?, `sessionDesc` = ? WHERE `sessions`.`sessionId` = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header(SQLERROR);
                exit();
            } else {
                mysqli_stmt_bind_param( //Sets all of the user sent data for SQL upload
                    $stmt,
                    "isiisi",
                    $info['sessionId'],
                    $info['sessionName'],
                    $info['sessionAttendees'],
                    $info['sessionTime'],
                    $info['sessionDesc'],
                    $info['sessionId']
                );

                if (mysqli_stmt_execute($stmt)) {
                    header(OPSUCCESS); //Good to go!
                    exit();
                } else {
                    echo json_encode($info);
                    header(SQLERROR); //Something went wrong in running the statement
                    exit();
                }
            }
        }
    case 'deleteSession': //Deletes the relationship between the user and the session
        $uid = $_POST['userId'];
        $sid = $_POST['sessionId'];

        if (empty($sid) || empty($uid)) { //We need both the user id and session id
            header(EMPTYFIELDS);
            exit();
        } else {

            $sql = "DELETE FROM `users_sessions` WHERE `user_id` = ? AND `session_id` = ?"; //Simply deletes the relation from the join table
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo json_encode($_POST);
                header(SQLERROR);
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

                if (mysqli_stmt_execute($stmt)) {
                    header(OPSUCCESS); //Everything went well
                    exit();
                } else {
                    echo json_encode($info);
                    header(SQLERROR);
                    exit();
                }
            }
        }
}
