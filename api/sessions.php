<?php

require "const.inc.php";
$_POST = json_decode(file_get_contents("php://input"), true);

if( !isset($_POST['functionname']) ) {
  header(NOFUNCNAME);
  exit();

} else {
  require 'dbh.php';

  switch($_POST['functionname']) {
    case 'getSessions':
      $sql = "SELECT * FROM sessions";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header(SQLERROR);
        exit();
      } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($result)){
            $sessions[] = $row;
        }

        echo json_encode($sessions);
        header(OPSUCCESS);
        exit();
      }
    case 'editSession':
      $info = $_POST['session'];

      if(sizeof($info) > 5){
        header(EDITFIELDNOTFOUND);
        exit();
      } else {

      foreach($info as $value) {
        if(isset($value)) {
          continue;
        } else {
          header(EDITFIELDNOTFOUND);
          exit();
        }
      }

      $sql = "UPDATE `sessions` SET `sessionId` = ?, `sessionName` = ?,
            `sessionAttendees` = ?, `sessionTime` = ?, `sessionDesc` = ? WHERE `sessions`.`sessionId` = ? ";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header(SQLERROR);
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "isiisi", $info['sessionId'], $info['sessionName'], $info['sessionAttendees'],
        $info['sessionTime'], $info['sessionDesc'], $info['sessionId']);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        header(OPSUCCESS);
        exit();
      }
    }
    case 'deleteSession':
      $id = $_POST['sessionId'];

      if(empty($id)) {
        header(SQLERROR);
        exit();
      } else {

        $sql = "DELETE FROM `sessions` WHERE `sessions`.`sessionId` = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
          header(SQLERROR);
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "i", $id);

          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          header(OPSUCCESS);
          exit();
        }
      }
    default:
      header(FUNCNOTFOUND);
      exit();
  }
}
