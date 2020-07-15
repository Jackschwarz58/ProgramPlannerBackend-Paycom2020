<?php

require "../const.inc.php";
$_POST = json_decode(file_get_contents("php://input"), true);

if (!isset($_POST['functionname'])) {
  header(NOFUNCNAME);
  exit();
} else {
  $functionname = $_POST['functionname'];

  require '../dbh.php';
  if ($functionname == "addSession" || $functionname == "addRelationship") {
    include('addSessions.php');
  } elseif ($functionname == "getUserSessions" || $functionname == "getAllSessions") {
    include('getSessions.php');
  } elseif ($functionname == "deleteSession" || $functionname == "editSession") {
    include('editSessions.php');
  } else {
    header(NOFUNCNAME);
    exit();
  }
}
