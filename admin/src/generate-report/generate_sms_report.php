<?php
session_start();
require_once("../../../db.php");

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sms_report_" . date("Y-m-d_H-i") . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start the table
echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Recipient (Number)</th>
        <th>Message</th>
        <th>Status</th>
        <th>SMS Limit</th>
        <th>SMS Used</th>
        <th>Sent At</th>
      </tr>";

$query = "SELECT id, user_id, recipient, message, status, sms_limit, sms_used, sent_at 
          FROM sms_history 
          ORDER BY sent_at DESC 
          LIMIT 1000"; // You can increase or remove the limit if needed

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipient = preg_replace('/\D/', '', $row['recipient']);
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$recipient}</td>
                <td>" . htmlspecialchars($row['message']) . "</td>
                <td>{$row['status']}</td>
                <td>{$row['sms_limit']}</td>
                <td>{$row['sms_used']}</td>
                <td>{$row['sent_at']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found.</td></tr>";
}

echo "</table>";

$conn->close();
?>
