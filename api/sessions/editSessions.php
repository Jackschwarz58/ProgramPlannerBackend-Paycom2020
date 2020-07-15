<?php
$_POST = json_decode(file_get_contents("php://input"), true);

switch ($_POST['functionname']) {
    case 'editSession':
        $info = $_POST['session'];

        if (sizeof($info) > 5) {
            header(EDITFIELDNOTFOUND);
            exit();
        } else {

            foreach ($info as $value) {
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
                mysqli_stmt_bind_param(
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
                    header(OPSUCCESS);
                    exit();
                } else {
                    echo json_encode($info);
                    header(SQLERROR);
                    exit();
                }
            }
        }
    case 'deleteSession':
        $uid = $_POST['userId'];
        $sid = $_POST['sessionId'];

        if (empty($sid) || empty($uid)) {
            header(EMPTYFIELDS);
            exit();
        } else {

            $sql = "DELETE FROM `users_sessions` WHERE `user_id` = ? AND `session_id` = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo json_encode($_POST);
                header(SQLERROR);
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ii", $uid, $sid);

                if (mysqli_stmt_execute($stmt)) {
                    header(OPSUCCESS);
                    exit();
                } else {
                    echo json_encode($info);
                    header(SQLERROR);
                    exit();
                }
            }
        }
}
