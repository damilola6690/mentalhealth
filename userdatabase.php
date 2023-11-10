<?php

$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "mhcare";
$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Something went wrong: " . mysqli_connect_error());
}

?>
