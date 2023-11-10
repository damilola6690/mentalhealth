<?php
session_start();
include 'patientdatabase.php';

$confirmation_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["DELETE_PATIENT"])) {
        $unique_patient_id = $_POST['unique_patient_id'];

        // Fetch first name and last name for confirmation message
        $select_sql = "SELECT first_name, last_name FROM patient_records WHERE unique_patient_id = ?";
        $stmt = mysqli_prepare($conn, $select_sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $unique_patient_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $first_name, $last_name);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            $confirmation_message = "Are you sure you want to delete the record for $first_name $last_name?";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }

    if (isset($_POST["CONFIRM_DELETE_PATIENT"])) {
        // Perform the actual deletion here
        $unique_patient_id = $_POST['unique_patient_id'];
        $delete_sql = "DELETE FROM patient_records WHERE unique_patient_id = ?";
        $stmt = mysqli_prepare($conn, $delete_sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $unique_patient_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Record Deleted Successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Patient Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .bg-img {
            background-image: url("https://cdn.icon-icons.com/icons2/402/PNG/512/delete-file_40456.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            min-height: 100vh;
            opacity: 3.5;
        }
        .container {
            position: relative;
            z-index: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .container label {
            font-weight: bold;
        }
        .container input[type="text"],
        .container input[type="date"],
        .container input[type="tel"],
        .container select {
            width: 40%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            width: 40%;
        }
        #others-option {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="bg-img">
        <div class="container">
            <h1>Delete Patient Record</h1>
            
            <?php if ($confirmation_message) : ?>
                <div class="alert alert-warning"><?php echo $confirmation_message; ?></div>
                <form action="delete_patient.php" method="post">
                    <input type="hidden" name="unique_patient_id" value="<?php echo $unique_patient_id; ?>">
                    <button type="submit" class="btn btn-danger" name="CONFIRM_DELETE_PATIENT">Confirm Delete</button>
                    <a class="btn btn-secondary" href="http://localhost/mhcare/users/welcome.php">Cancel</a>
                </form>
            <?php else : ?>
                <form action="delete_patient.php" method="post">
                    <div class="form-group">
                        <label for="unique_patient_id">Patient ID:</label>
                        <input type="text" id="unique_patient_id" name="unique_patient_id" required><br><br>
                        <button type="submit" class="btn btn-danger" name="DELETE_PATIENT">Delete Patient</button>
                        <a class="btn btn-secondary" href="http://localhost/mhcare/users/welcome.php">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>
</body>
</html>
