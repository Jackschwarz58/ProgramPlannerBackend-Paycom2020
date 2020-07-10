<?php

require 'const.inc.php';
$_POST = json_decode(file_get_contents("php://input"), true);

if(isset($_SESSION['userId'])) {

} else {

}
