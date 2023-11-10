<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $staff_id = $_POST['staff_id'];
    $password = $_POST['password'];

$hostname = "localhost"; 
$dbUser = "root";
$dbPassword = ""; 
$dbName = "mhcare"; 

$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);


    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE staff_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staff_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['username'] = $user['username'];

        header('Location: welcome.php');
        exit();
    } else {
        $error_message = "Invalid Staff ID or password";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="...">

    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('https://cdn.gocanvas.com/cdn-images/hero-banner/patient-records.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        .logo {
            max-width: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $staff_id = $_POST["staff_id"];
            $password = $_POST["password"];
            require_once "userdatabase.php";
            $sql = "SELECT * FROM users WHERE staff_id = '$staff_id'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                 $_SESSION["username"] = $user["username"];
                header("location: http://localhost/mhcare/users/welcome.php");
                die();

                } else {
                    echo "<div class='alert alert-danger'>Password does not match!</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Staff ID does not match!</div>";
            }
        }
        ?>
        <div class="text-center">
            <img src="https://image.freepik.com/free-vector/gradient-mental-health-logo-template_23-2148820570.jpg" alt="Logo" class="logo">
            <h1>St. Joseph’s Health Care Record Management System</h1>
        </div>
        <form action="login.php" method="post">
            <div class="form-group">
            <input type="text" placeholder="Enter Staff ID" name="staff_id" class="form-control">
            </div>
            <div class="form-group">
            <input type="password" placeholder="Enter Password" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="LOGIN" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
    <p><a href="resetpassword.php">Forgot Password?</a> | <a href="usersregistration.php">Not yet created</a></p>
</div>
    </div>
</body>
</html>
