<?php

require "../const.inc.php";
$_POST = json_decode(file_get_contents("php://input"), true); //Pull data from request

if (!isset($_POST['functionname'])) { //Makes sure function name is deinfed, otheriwse exit
  header(NOFUNCNAME);
  exit();
} else {
  $functionname = $_POST['functionname'];

  //I split up the functions into different files as they were getting absolutely massive and it made more sense
  //for clarity and efficiency to load them in individually
  require '../dbh.php';
  if ($functionname == "addSession" || $functionname == "addRelationship") {
    include('addSessions.php'); //All Add Session functions
  } elseif ($functionname == "getUserSessions" || $functionname == "getAllSessions") {
    include('getSessions.php'); //Add getter functions
  } elseif ($functionname == "deleteSession" || $functionname == "editSession") {
    include('editSessions.php'); //Anything that explicit mutates existing data
  } else {
    header(NOFUNCNAME); //Another check to make sure the function specified is defined
    exit();
  }
}
