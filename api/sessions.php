<?php

require "const.inc.php";
$_POST = json_decode(file_get_contents("php://input"), true);

if (!isset($_POST['functionname'])) {
  header(NOFUNCNAME);
  exit();
} else {
  require 'dbh.php';

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
    default:
      header(FUNCNOTFOUND);
      exit();
  }
}
