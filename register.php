<?php
require_once 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $employee_id = $_POST['employee_id'];
    $contact = $_POST['contact'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $radius = $_POST['radius'];

    // Insert into database
    try {
        $stmt = $conn->prepare("INSERT INTO employees (name, employee_id, contact, latitude, longitude, radius) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $employee_id, $contact, $latitude, $longitude, $radius]);

        // Redirect to refresh the page
        header("Location: register.php");
        exit(); // Ensure no further code executes
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <!-- External Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Form Container */
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            color: #4facfe;
        }

        label {
            font-weight: 600;
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            background-color: #4facfe;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3a8ad3;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Registration</h1>
        <form method="POST" action="register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required>

            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required>

            <label for="radius">Radius (in meters):</label>
            <input type="text" id="radius" name="radius" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
