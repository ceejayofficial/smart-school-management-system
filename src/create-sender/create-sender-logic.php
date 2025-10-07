<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../db.php';
require __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

$userId = $_SESSION['user_id'];

// Pagination setup
$limit = 3;
$pageNumber = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$offset = ($pageNumber - 1) * $limit;

// Count total
$countStmt = $conn->prepare("SELECT COUNT(*) FROM sender_id WHERE user_id = ?");
$countStmt->bind_param("i", $userId);
$countStmt->execute();
$countStmt->bind_result($total);
$countStmt->fetch();
$countStmt->close();

$totalPages = ceil($total / $limit);

// Fetch sender IDs
$stmt = $conn->prepare("SELECT id, sender_name, purpose, created_at FROM sender_id WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("iii", $userId, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$senderData = [];
while ($row = $result->fetch_assoc()) {
  $senderData[] = $row;
}
$stmt->close();

// Fetch MNotify statuses
function getSenderStatus($senderName)
{
  $apiKey = getenv('MNOTIFY_SENDER_STATUS_KEY') ?: 'BIrxZ74KLrejBIJwj5Ks27ZNt';
  $url = "https://api.mnotify.com/api/senderid/status?key={$apiKey}";

  $payload = json_encode(['sender_name' => $senderName]);
  $ch = curl_init($url);

  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => $payload
  ]);

  $response = curl_exec($ch);
  curl_close($ch);

  $json = json_decode($response, true);
  return $json['status'] ?? 'Unknown';
}
?>