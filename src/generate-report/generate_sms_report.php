<?php
session_start();
require_once __DIR__ . '/../../db.php'; // DB uses $conn

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sms_report_" . date("Y-m-d_H-i") . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Recipient (Number)</th>
        <th>Message</th>
        <th>Status</th>
        <th>SMS Limit</th>
        <th>SMS Used</th>
        <th>Sent At</th>
      </tr>";

$stmt = $conn->prepare("SELECT id, recipient, message, status, sms_limit, sms_used, sent_at FROM sms_history WHERE user_id = ? ORDER BY sent_at DESC LIMIT 100");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $recipient = preg_replace('/\D/', '', $row['recipient']); // ensure only numbers
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$recipient}</td>
            <td>" . htmlspecialchars($row['message']) . "</td>
            <td>{$row['status']}</td>
            <td>{$row['sms_limit']}</td>
            <td>{$row['sms_used']}</td>
            <td>{$row['sent_at']}</td>
          </tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
