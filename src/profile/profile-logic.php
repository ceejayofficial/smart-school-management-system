<?php
require_once __DIR__ . '/../../db.php'; //

$user_id = $_SESSION['user_id'] ?? null;
$user = null;

if ($user_id && isset($conn)) {
  $stmt = $conn->prepare("SELECT username, email, phone, role, unique_code, created_at FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
}
?>

