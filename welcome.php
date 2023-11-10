<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WELCOME TO PATIENT RECORD SYSTEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-img {
            background-image: url("http://www.dactari.co/image/home-img.svg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            min-height: 110vh;
        }

        .logo {
            max-width: 80px;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
            transition: width 0.3s ease;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 15px;
            transition: margin-left 0.3s ease;
        }

        .sidebar-btn {
            position: absolute;
            left: 10px;
            top: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="bg-img">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                <img src="https://image.freepik.com/free-vector/gradient-mental-health-logo-template_23-2148820570.jpg" alt="Logo" class="logo">
            </a>
        </nav>
        <div class="content">
        <p class="welcome-text">Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>
        <button class="sidebar-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        </div>
        <style>
        .welcome-text {
            position: absolute;
            top: 20px;
            right: 20px;
            font-weight: bold;
            color: #fff;
            background-color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
    </style>

        <div class="sidebar">
            <a href="http://localhost/mhcare/patients/view_patient.php">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="http://localhost/mhcare/patients/add_patient.php">
                <i class="fas fa-plus"></i> Add
            </a>
            <a href="http://localhost/mhcare/patients/modify_patient.php">
                <i class="fas fa-pencil-alt"></i> Modify
            </a>
            <a href="http://localhost/mhcare/patients/delete_patient.php">
                <i class="fas fa-trash"></i> Delete
            </a>
            <a href="#">
                <i class="fas fa-cogs"></i> Settings
            </a>
            <a href="http://localhost/mhcare/patients/logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
        <div class="content">
            <!-- Your page content goes here -->
        </div>

        <script>
            function toggleSidebar() {
                var sidebar = document.querySelector('.sidebar');
                var content = document.querySelector('.content');

                if (sidebar.style.left === "0px") {
                    sidebar.style.width = "0";
                    content.style.marginLeft = "0";
                } else {
                    sidebar.style.width = "250px";
                    content.style.marginLeft = "250px";
                }
            }
        </script>
    </div>
</body>
</html>
