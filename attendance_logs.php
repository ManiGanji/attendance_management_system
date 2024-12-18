<?php
require_once 'config.php'; // Database connection

// Fetch attendance records
try {
    $stmt = $conn->prepare("SELECT a.id, e.name, e.employee_id, a.timestamp, a.latitude, a.longitude
                            FROM attendance_logs a
                            JOIN employees e ON a.employee_id = e.employee_id
                            ORDER BY a.timestamp DESC");
    $stmt->execute();
    $attendanceLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(247, 248, 249); /* Light grayish blue background */
            color: #333; /* Darker text for better contrast */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Attendance Logs</h1>

    <!-- Attendance Table -->
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Timestamp</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($attendanceLogs) > 0): ?>
                <?php foreach ($attendanceLogs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['id']); ?></td>
                        <td><?php echo htmlspecialchars($log['name']); ?></td>
                        <td><?php echo htmlspecialchars($log['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                        <td><?php echo htmlspecialchars($log['latitude']); ?></td>
                        <td><?php echo htmlspecialchars($log['longitude']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a  style="border:2px solid black ;background-color:whitesmoke; color:black; padding:5px 5px;" href="admin_dashboard.php">Back to Admin Dashboard</a></p>
</body>
</html>
