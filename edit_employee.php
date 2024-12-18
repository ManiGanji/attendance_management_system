<?php
require_once 'config.php'; // Include database connection

// Check if the employee_id is provided in the URL
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Fetch the employee's current details from the database
    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = :employee_id");
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: admin_dashboard.php");
    exit();
}

// Handle the form submission to update employee details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $radius = $_POST['radius'];

    // Update the employee details in the database
    $updateStmt = $conn->prepare("UPDATE employees SET name = :name, contact = :contact, latitude = :latitude, longitude = :longitude, radius = :radius WHERE employee_id = :employee_id");
    $updateStmt->bindParam(':employee_id', $employee_id);
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':contact', $contact);
    $updateStmt->bindParam(':latitude', $latitude);
    $updateStmt->bindParam(':longitude', $longitude);
    $updateStmt->bindParam(':radius', $radius);
    $updateStmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        label {
            font-size: 1rem;
            color: #555;
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            form {
                width: 90%;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>">

        <label for="contact">Contact:</label>
        <input type="text" name="contact" value="<?php echo htmlspecialchars($employee['contact']); ?>">

        <label for="latitude">Latitude:</label>
        <input type="text" name="latitude" value="<?php echo htmlspecialchars($employee['latitude']); ?>">

        <label for="longitude">Longitude:</label>
        <input type="text" name="longitude" value="<?php echo htmlspecialchars($employee['longitude']); ?>">

        <label for="radius">Radius:</label>
        <input type="number" name="radius" value="<?php echo htmlspecialchars($employee['radius']); ?>">

        <input type="submit" value="Update Employee">
    </form>
</body>
</html>
