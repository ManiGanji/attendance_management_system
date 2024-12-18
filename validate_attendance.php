<?php
session_start();
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$currentLat = $data['latitude'];
$currentLng = $data['longitude'];
$employeeId = $_SESSION['employee_id'];

// Fetch geofence data
$stmt = $conn->prepare("SELECT latitude, longitude, radius FROM employees WHERE employee_id = ?");
$stmt->execute([$employeeId]);
$employee = $stmt->fetch();

function haversine($lat1, $lng1, $lat2, $lng2) {
    $earthRadius = 6371000;
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}

$distance = haversine($currentLat, $currentLng, $employee['latitude'], $employee['longitude']);

if ($distance <= $employee['radius']) {
    $stmt = $conn->prepare("INSERT INTO attendance_logs (employee_id, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->execute([$employeeId, $currentLat, $currentLng]);
    echo json_encode(['message' => 'Attendance marked successfully!']);
} else {
    echo json_encode(['message' => 'You are outside the geofence.']);
}
?>
