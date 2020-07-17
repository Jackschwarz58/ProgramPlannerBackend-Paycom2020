<?php

//This is specifically designed to iterate through all the sessions in the array and update the attendee number for each
//This is not the most efficient way to accomplish this, but I was unable to get a procedure working in my database. This
//gets the job done though
require 'const.inc.php';
require 'dbh.php';

$getsessionsql = "SELECT * FROM sessions"; //Pulling all sessions for updating
$stmt = mysqli_stmt_init($conn);
$sessions = [];

if (!mysqli_stmt_prepare($stmt, $getsessionsql)) {
    header(SQLERROR); //COnnection Error
    exit();
} else {
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) { //Puts all the session rows received in an array to be looped through
            $sessions[] = $row;
        }

        //Updates the sessions attendee count with the number of time its appears in the join table
        $updatesql = "UPDATE sessions SET sessions.sessionAttendees =
            (SELECT COUNT(*) FROM users_sessions WHERE users_sessions.session_id = ?) WHERE sessions.sessionId = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $updatesql)) { //Connection Error
            header(SQLERROR);
            exit();
        } else {
        }

        //Go through each and run the updatesql query
        foreach ($sessions as $s) {
            mysqli_stmt_bind_param($stmt, 'ii', $s['sessionId'], $s['sessionId']);
            if (!mysqli_stmt_execute($stmt)) {
                header(SQLERROR);
                exit();
            }
        }
        //Send out a success message
        header(OPSUCCESS);
        exit();
    } else {
        header(SQLERROR);
        exit();
    }
}
