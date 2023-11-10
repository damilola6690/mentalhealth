<?php
session_start();

$_SESSION = array();

session_destroy();

header("Location: http://localhost/mhcare/users/login.php");
exit();
?>
