<?php
session_start();
include 'patientdatabase.php';

$sql = "SELECT * FROM patient_records ORDER BY last_name";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Records</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('https://www.iconbunny.com/icons/media/catalog/product/2/4/2494.13-medical-records-icon-iconbunny.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 3.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.8);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Unique Patient ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Address</th>
            <th>City</th>
            <th>Province</th>
            <th>Postal Code</th>
            <th>Phone</th>
            <th>Email</th>
            <th>List of current medications</th>
            <th>List of allergies</th>
            <th>Referring doctor</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['unique_patient_id'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['DOB'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['City'] . "</td>";
            echo "<td>" . $row['Province'] . "</td>";
            echo "<td>" . $row['postal_code'] . "</td>";
            echo "<td>" . $row['Phone'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['list_of_current_medications'] . "</td>";
            echo "<td>" . $row['list_of_allergies'] . "</td>";
            echo "<td>" . $row['referring_doctor'] . "</td>";
            echo "<td><a href='modify_patient.php?id=" . $row['unique_patient_id'] . "'>Edit</a> | <a href='delete_patient.php?id=" . $row['unique_patient_id'] . "'>Remove</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
