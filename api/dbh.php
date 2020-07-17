<?php
//Establishes a connection to the database to be used across all the other PHP files

$servername = "localhost"; //This was for the local database
$dBUsername = "root";
$dBPassword = "";
$dBName = "paycom_project_db";

//Sets connection
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection Failed!: " . mysqli_connect_error());
}
