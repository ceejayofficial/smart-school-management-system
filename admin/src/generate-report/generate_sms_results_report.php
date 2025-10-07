<?php
session_start();
require_once("../../../db.php");

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

// Optional: Check for admin role
// if ($_SESSION['role'] !== 'admin') {
//     die("Access denied.");
// }

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sms_results_report_" . date("Y-m-d_H-i") . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Phone</th>
        <th>Student Name</th>
        <th>Semester</th>
        <th>Message</th>
        <th>Status</th>
        <th>Sent At</th>
      </tr>";

// Fetch all records, not filtered by user_id
$query = "SELECT id, user_id, phone, student_name, semester, message, status, sent_at 
          FROM sms_results 
          ORDER BY sent_at DESC 
          LIMIT 1000"; // Adjust/remove limit as needed

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $phone = preg_replace('/\D/', '', $row['phone']);
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$phone}</td>
                <td>" . htmlspecialchars($row['student_name']) . "</td>
                <td>" . htmlspecialchars($row['semester']) . "</td>
                <td>" . htmlspecialchars($row['message']) . "</td>
                <td>{$row['status']}</td>
                <td>{$row['sent_at']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found.</td></tr>";
}

echo "</table>";

$conn->close();
?>
