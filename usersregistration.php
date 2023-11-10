<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('https://cdn.gocanvas.com/cdn-images/hero-banner/patient-records.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .top-left-logo {
            position: absolute;
            top: 10px;
            left: 10px;
            max-width: 80px;
        }
        .bg-link {
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            height: 100%;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
           
        }
    </style>
</head>
<body>
    <a href="http://localhost/MHCare/Mental%20Health%20Care/homepage.html" class="bg-link"></a>
    <img src="https://image.freepik.com/free-vector/gradient-mental-health-logo-template_23-2148820570.jpg" alt="Logo" class="top-left-logo">
    <div class="container">

        <h1 class="text-center">St. Joseph’s Health Care Record Management System</h1>
        <?php
        if (isset($_POST["SUBMIT"])) {
            $username = $_POST["username"];
            $staff_id = $_POST["staff_id"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if  (empty($username) || empty($staff_id) || empty($password) || empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($staff_id, FILTER_VALIDATE_INT)) {
                array_push($errors, "ID is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Passwords do not match");
            }

            require_once "userdatabase.php";
            $checkQuery = "SELECT * FROM users WHERE staff_id = ?";
            $checkStmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($checkStmt, $checkQuery)) {
                mysqli_stmt_bind_param($checkStmt, "s", $staff_id);
                mysqli_stmt_execute($checkStmt);
                $checkResult = mysqli_stmt_get_result($checkStmt);
                
                if (mysqli_num_rows($checkResult) > 0) {
                    array_push($errors, "Staff ID already exists");
                }
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                $sql = "INSERT INTO users (username, staff_id, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sss", $username, $staff_id, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Staff created successfully.</div>";
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>
        <form action="usersregistration.php" method="post">
        <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="USERNAME">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="staff_id" placeholder="STAFF ID">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="PASSWORD">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="REPEAT PASSWORD">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="SUBMIT">
            </div>
        </form>
        <div><p>Already a user? <a href="login.php">Click here!</a></p></div>
    </div>
</body>
</html>
