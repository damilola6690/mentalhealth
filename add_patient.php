<?php
session_start();
include 'patientdatabase.php';

if (isset($_POST["ADD_PATIENT"])) {
    $unique_patient_id = $_POST['unique_patient_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $DOB = $_POST['DOB'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $Province = $_POST['Province'];
    $postal_code = $_POST['postal_code'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $list_of_current_medications = $_POST['list_of_current_medications'];
    $list_of_allergies = $_POST['list_of_allergies'];
    $referring_doctor = $_POST['referring_doctor'];

    if (!filter_var($Email, FILTER_VALIDATE_EMAIL) || !preg_match("/\.com$/i", $Email)) {
        echo "<div class='alert alert-danger'>Invalid email address. Please enter a valid email ending with '.com'.</div>";
        die();
    }

    $duplicate_check_sql = "SELECT COUNT(*) FROM patient_records WHERE unique_patient_id = ?";
    $stmt = mysqli_prepare($conn, $duplicate_check_sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $unique_patient_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($count > 0) {
            echo "<div class='alert alert-danger'>Patient with the same ID already exists!</div>";
            die();
        }
    }

    $insert_sql = "INSERT INTO patient_records (unique_patient_id, first_name, last_name, gender, DOB, Address, City, Province, postal_code, Phone, Email, list_of_current_medications, list_of_allergies, referring_doctor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssssss", $unique_patient_id, $first_name, $last_name, $gender, $DOB, $Address, $City, $Province, $postal_code, $Phone, $Email, $list_of_current_medications, $list_of_allergies, $referring_doctor);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Record Added Successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Patient Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .bg-img {
            background-image: url("https://cdn4.iconfinder.com/data/icons/medical-health-8/160/medical-record-1024.png");
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
            <h1>Add Patient Record</h1>
            <form action="add_patient.php" method="post">
             <div class="form-group">
                <label for="unique_patient_id">Patient ID:</label>
                <input type="text" id="unique_patient_id" name="unique_patient_id" required><br><br>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required><br><br>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required><br><br>
                <label>Gender:</label>
                <input type="radio" id="male" name="gender" value="Male">
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="Female">
                <label for="female">Female</label>
                <input type="radio" id="others" name="gender" value="Others">
                <label for="others">Others</label>
                <input type="text" id="others-option" name="other_gender" placeholder="Specify"><br><br>
                <label for="DOB">DOB:</label>
                <input type="date" id="DOB" name="DOB" required><br><br>
                <label for="Address">Address:</label>
                <input type="text" id="Address" name="Address" required><br><br>
                <label for="City">City:</label>
                <input type="text" id="City" name="City" required><br><br>
                <label for="Province">Province:</label>
                <select id="Province" name="Province" required>
                    <option value="Alberta">Alberta</option>
                    <option value="British Columbia">British Columbia</option>
                    <option value="Manitoba">Manitoba</option>
                    <option value="New Brunswick">New Brunswick</option>
                    <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                    <option value="Nova Scotia">Nova Scotia</option>
                    <option value="Ontario">Ontario</option>
                    <option value="Prince Edward Island">Prince Edward Island</option>
                    <option value="Quebec">Quebec</option>
                    <option value="Saskatchewan">Saskatchewan</option>
                </select><br><br>
                <label for="postal_code">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" required pattern="[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d" placeholder="A1B 2C3"><br><br>
                <label for="Phone">Phone:</label>
                <input type="tel" id="Phone" name="Phone" required pattern="[\+]\d{1} \d{3} \d{3} \d{4}" placeholder="+X XXX XXX XXXX"><br><br>
                <label for="Email">Email:</label>
                <input type="text" id="Email" name="Email" required><br><br>
                <label for="list_of_current_medications">List of Current Medications:</label>
                <input type="text" id="list_of_current_medications" name="list_of_current_medications" required><br><br>
                <label for="list_of_allergies">List of Allergies:</label>
                <input type="text" id="list_of_allergies" name="list_of_allergies" required><br><br>
                <label for="referring_doctor">Referring Doctor:</label>
                <input type="text" id="referring_doctor" name="referring_doctor" required><br><br>
                
                <button type="submit" class="btn btn-primary" name="ADD_PATIENT">Add Patient</button>
                <a class="btn btn-secondary" href="http://localhost/mhcare/users/welcome.php">Cancel</a>
                </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#Phone').inputmask('+9 999 999 9999');
            $('#postal_code').inputmask('A9A 9A9');
        });
    </script>
</body>
</html>

