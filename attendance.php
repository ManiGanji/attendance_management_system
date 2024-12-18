<?php
// attendance.php

session_start();
require_once 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture submitted data
    $employeeId = $_POST['employee_id'];
    $currentLat = $_POST['current_lat'];
    $currentLon = $_POST['current_lon'];

    try {
        // Fetch the assigned geolocation data for the employee
        $stmt = $conn->prepare("SELECT latitude, longitude, radius FROM employees WHERE employee_id = :employee_id");
        $stmt->bindParam(':employee_id', $employeeId);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee) {
            $assignedLat = $employee['latitude'];
            $assignedLon = $employee['longitude'];
            $radius = $employee['radius'];

            // Calculate distance between employee's location and assigned geofence
            $distance = haversine($assignedLat, $assignedLon, $currentLat, $currentLon);

            if ($distance <= $radius) {
                // Within geofence - record attendance
                $insert = $conn->prepare("INSERT INTO attendance_logs (employee_id, timestamp, latitude, longitude) VALUES (:employee_id, NOW(), :latitude, :longitude)");
                $insert->bindParam(':employee_id', $employeeId);
                $insert->bindParam(':latitude', $currentLat);
                $insert->bindParam(':longitude', $currentLon);
                $insert->execute();

                echo "Attendance marked successfully!";
            } else {
                echo "You are outside the allowed attendance location!";
            }
        } else {
            echo "Invalid Employee ID!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to calculate distance using Haversine formula
function haversine($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Radius of the earth in km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c; // Distance in km
    return $distance * 1000; // Convert to meters
}
?>

<!-- HTML Form to Capture Employee's Current Location -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Marking</title>
    <script>
        // Function to fetch user's current location
        function fetchLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.getElementById("current_lat").value = position.coords.latitude;
            document.getElementById("current_lon").value = position.coords.longitude;
        }

        function showError(error) {
            alert("Error fetching location: " + error.message);
        }
    </script>

    <style>
        /* General Page Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            color: #333;
            text-align: center;
            font-size: 2em;
            margin-top: 20px;
        }

        /* Form Styling */
        form {
            background-color: #fff;
            padding: 20px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        label {
            font-size: 1.1em;
            margin-top: 15px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            background-color: #f9f9f9;
        }

        input[type="text"]:readonly {
            background-color: #e9e9e9;
        }

        button {
            background-color: #28a745;
            color: white;
            font-size: 1.1em;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        /* Message Styling */
        .message {
            text-align: center;
            font-size: 1.2em;
            margin-top: 20px;
            color: #dc3545;
        }
    </style>
</head>
<body onload="fetchLocation()">
    <h1>Employee Attendance</h1>
    
    <!-- Display Message if Attendance is marked or error occurs -->
    <?php if (isset($message)) : ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="attendance.php">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required><br>

        <label for="current_lat">Current Latitude:</label>
        <input type="text" id="current_lat" name="current_lat" readonly><br>

        <label for="current_lon">Current Longitude:</label>
        <input type="text" id="current_lon" name="current_lon" readonly><br>

        <button type="submit">Mark Attendance</button>
    </form>
</body>
</html>
