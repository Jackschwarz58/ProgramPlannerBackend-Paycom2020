<?php
header("Access-Control-Allow-Origin", "http://localhost:3000");


$_POST = json_decode(file_get_contents("php://input"),true);

//echo json_encode($_POST);

if (isset($_POST['loginSubmit'])) {
  echo json_encode('success');
     require 'dbh.php';

     $uid = $_POST['uid'];
     $pwd = $_POST['pwd'];
     echo json_encode($uid);
     echo json_encode($pwd);

//
//     if (empty($mailuid) || empty($password)) {
//         header("Location: ../index.php?error=emptyfields");
//         exit();
//     } else {
//         $sql = "SELECT * FROM users WHERE uidusers=? OR emailUsers=?;";
//         $stmt = mysqli_stmt_init($conn);
//
//         if (!mysqli_stmt_prepare($stmt, $sql)) {
//             header("Location: ../index.php?error=sqlerror");
//             exit();
//         } else {
//             mysqli_stmt_bind_param($stmt, "ss", $$mailuid, $mailuid);
//             mysqli_stmt_execute($stmt);
//             $result = mysqli_stmt_get_result($stmt);
//
//             if ($row = mysqli_fetch_assoc($result)) {
//                 $pwdCheck = password_verify($password, $row['pwdUsers']);
//
//                 if ($pwdCheck == false) {
//                     header("Location: ../index.php?error=wrongpass");
//                     exit();
//                 } elseif ($pwdCheck == true) {
//                     session_start();
//                     $_SESSION['userId'] = $row['idUsers'];
//                     $_SESSION['userUid'] = $row['uidUsers'];
//
//                     header("Location: ../index.php?login=success");
//                     exit();
//                 } else {
//                     header("Location: ../index.php?error=wrongpass");
//                     exit();
//                 }
//             } else {
//                 header("Location: ../index.php?error=nouser");
//                 exit();
//             }
//         }
//     }
// } else {
//     header("Location: ../index.php");
//     exit();
}
