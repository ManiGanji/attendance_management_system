<?php
require_once 'config.php'; // Include database connection

// 1. Handle Deletion of Employee
if (isset($_GET['delete_employee_id'])) {
    $delete_employee_id = $_GET['delete_employee_id'];

    try {
        // Prepare and execute the DELETE statement
        $deleteStmt = $conn->prepare("DELETE FROM employees WHERE employee_id = :employee_id");
        $deleteStmt->bindParam(':employee_id', $delete_employee_id, PDO::PARAM_STR);
        $deleteStmt->execute();

        // Redirect back with success message
        header("Location: admin_dashboard.php?message=Employee+Deleted+Successfully");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// 2. Fetch Employee Records to Display in Table
try {
    $stmt = $conn->prepare("SELECT * FROM employees");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin: 20px 0;
            color: #007bff;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        p a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            border: 2px solid #007bff;
            background-color: #e9ecef;
            color: #007bff;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
        }

        p a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            font-size: 1.2rem;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Display Success Message -->
    <?php if (isset($_GET['message'])): ?>
        <p class="success-message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- Table for Employee Records -->
    <h2>Employee List</h2>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Radius (meters)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employees) > 0): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['contact']); ?></td>
                        <td><?php echo htmlspecialchars($employee['latitude']); ?></td>
                        <td><?php echo htmlspecialchars($employee['longitude']); ?></td>
                        <td><?php echo htmlspecialchars($employee['radius']); ?></td>
                        <td>
                            <a href="edit_employee.php?employee_id=<?php echo $employee['employee_id']; ?>">Edit</a> |
                            <a href="admin_dashboard.php?delete_employee_id=<?php echo $employee['employee_id']; ?>"
                               onclick="return confirm('Are you sure you want to delete this employee?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No employees found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Optional: Add Links for Admin -->
    <p>
        <a href="register.php"><b>Add New Employee</b></a> 
        <a href="attendance_logs.php"><b>View Attendance Logs</b></a>
    </p>
</body>
</html>
