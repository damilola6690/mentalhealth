<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'userdatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = $_POST['token'];

    $update_query = "UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ss", $password, $token);

    if (mysqli_stmt_execute($update_stmt)) {
        echo "Password reset successfully!";
    } else {
        echo "Error resetting password: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
