<?php
require_once __DIR__ . '/../../db.php'; // DB uses $conn

$user_id = $_SESSION['user_id'] ?? null;

// Default values
$username = '';
$sms_limit = 0;
$sms_used = 0;
$sms_left = 0;
$sms_sent_success = 0;
$sms_sent_failed = 0;
$total_sender_ids = 0;

if ($user_id && isset($conn)) {
  $stmt1 = $conn->prepare("SELECT username FROM users WHERE id = ?");
  if ($stmt1) {
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $stmt1->bind_result($username_result);
    if ($stmt1->fetch()) {
      $username = $username_result;
    }
    $stmt1->close();
  }

  // ✅ Fetch latest sms_limit and sms_used
  $stmt2 = $conn->prepare("SELECT sms_limit, sms_used FROM sms_history WHERE user_id = ? ORDER BY id DESC LIMIT 1");
  if ($stmt2) {
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $stmt2->bind_result($limit, $used);
    if ($stmt2->fetch()) {
      $sms_limit = $limit;
      $sms_used = $used;
      $sms_left = max(0, $sms_limit - $sms_used);
    }
    $stmt2->close();
  }

  // ✅ Count sender IDs for this user
  $stmt3 = $conn->prepare("SELECT COUNT(*) FROM sender_id WHERE user_id = ?");
  if ($stmt3) {
    $stmt3->bind_param("i", $user_id);
    $stmt3->execute();
    $stmt3->bind_result($sender_count);
    if ($stmt3->fetch()) {
      $total_sender_ids = $sender_count;
    }
    $stmt3->close();
  }

// Count SMS by status for this user, excluding 'Free SMS assigned' from success
$stmt4 = $conn->prepare("
  SELECT status, COUNT(*) as count 
  FROM sms_history 
  WHERE user_id = ? AND NOT (status = 'success' AND response LIKE '%Free SMS assigned%') 
  GROUP BY status
");

if ($stmt4) {
  $stmt4->bind_param("i", $user_id);
  $stmt4->execute();
  $result = $stmt4->get_result();
  $status_data = [];
  while ($row = $result->fetch_assoc()) {
    $status_key = strtolower($row['status']);
    $status_data[$status_key] = $row['count'];
  }
  $stmt4->close();

  $sms_sent_success = $status_data['success'] ?? 0;
  $sms_sent_failed = $status_data['failed'] ?? 0;
}

}
?>