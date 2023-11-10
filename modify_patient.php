<?php
session_start();
include 'patientdatabase.php';

$patient = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unique_patient_id = $_POST['unique_patient_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
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

    $sql = "UPDATE patient_records SET 
            last_name = '$last_name',
            first_name = '$first_name',
            gender = '$gender',
            DOB = '$DOB',
            Address = '$Address',
            City = '$City',
            Province = '$Province',
            postal_code = '$postal_code',
            Phone = '$Phone',
            Email = '$Email',
            list_of_current_medications = '$list_of_current_medications',
            list_of_allergies = '$list_of_allergies',
            referring_doctor = '$referring_doctor'
            WHERE unique_patient_id = $unique_patient_id";

    if (mysqli_query($conn, $sql)) {
        header('Location: view_patient.php');
        exit();
    } else {
        $error_message = "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $unique_patient_id = $_GET['id'];
    $sql = "SELECT * FROM patient_records WHERE unique_patient_id = $unique_patient_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $patient = mysqli_fetch_assoc($result);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modify Patient Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .bg-img {
            background-image: url('https://www.databankimx.com/wp-content/uploads/meta_upload/Patient-Records-updated.png');
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
<body class="bg-img">
    <div class="container">
        <h1 style="text-align: center;">Modify Patient Record</h1>
        <?php
        if (isset($error_message)) {
            echo "<div style='color: red; text-align: center;'>$error_message</div>";
        }
        ?>
        <form method="post">
            <input type="hidden" name="unique_patient_id" value="<?php echo $patient['unique_patient_id'] ?? ''; ?>">
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo $patient['last_name'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo $patient['first_name'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" name="gender" id="gender" value="<?php echo $patient['gender'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="DOB">DOB:</label>
                <input type="text" name="DOB" id="DOB" value="<?php echo $patient['DOB'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" name="Address" id="Address" value="<?php echo $patient['Address'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="City">City:</label>
                <input type="text" name="City" id="City" value="<?php echo $patient['City'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="Province">Province:</label>
                <input type="text" name="Province" id="Province" value="<?php echo $patient['Province'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code:</label>
                <input type="text" name="postal_code" id="postal_code" value="<?php echo $patient['postal_code'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="Phone">Phone:</label>
                <input type="text" name="Phone" id="Phone" value="<?php echo $patient['Phone'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="text" name="Email" id="Email" value="<?php echo $patient['Email'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="list_of_current_medications">List of Current Medications:</label>
                <input type="text" name="list_of_current_medications" id="list_of_current_medications" value="<?php echo $patient['list_of_current_medications'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="list_of_allergies">List of Allergies:</label>
                <input type="text" name="list_of_allergies" id="list_of_allergies" value="<?php echo $patient['list_of_allergies'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="referring_doctor">Referring Doctor:</label>
                <input type="text" name="referring_doctor" id="referring_doctor" value="<?php echo $patient['referring_doctor'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <input type="submit" value="Update" name="update_patient" class="btn btn-primary">
                <a class="btn btn-secondary" href="http://localhost/mhcare/users/welcome.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
