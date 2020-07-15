<?php
require 'const.inc.php';
require 'dbh.php';

$getsessionsql = "SELECT * FROM sessions";
$stmt = mysqli_stmt_init($conn);
$sessions = [];

if (!mysqli_stmt_prepare($stmt, $getsessionsql)) {
    header(SQLERROR);
    exit();
} else {
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $sessions[] = $row;
        }

        $updatesql = "UPDATE sessions SET sessions.sessionAttendees =
            (SELECT COUNT(*) FROM users_sessions WHERE users_sessions.session_id = ?) WHERE sessions.sessionId = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $updatesql)) {
            header(SQLERROR);
            exit();
        } else {
        }

        foreach ($sessions as $s) {
            mysqli_stmt_bind_param($stmt, 'ii', $s['sessionId'], $s['sessionId']);
            if (!mysqli_stmt_execute($stmt)) {
                header(SQLERROR);
                exit();
            }
        }

        echo json_encode($sessions);
        header(OPSUCCESS);
        exit();
    } else {
        header(SQLERROR);
        exit();
    }
}
