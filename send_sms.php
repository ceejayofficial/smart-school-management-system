<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Dotenv\Dotenv;

header('Content-Type: application/json');

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$smsUrl = $_ENV['MNOTIFY_SMS_URL'] ?? '';

$db = new mysqli(
  $_ENV['DB_HOST'],
  $_ENV['DB_USER'],
  $_ENV['DB_PASS'],
  $_ENV['DB_NAME']
);

if ($db->connect_error) {
  exit(json_encode(['status' => 'error', 'message' => 'DB connection failed']));
}

// Helpers
function isValidNumber($phone) {
  return preg_match('/^\+?[0-9]{10,15}$/', preg_replace('/\s+/', '', $phone));
}

function logSms($db, $userId, $to, $msg, $status, $response, $smsLimit, $smsUsed) {
  $stmt = $db->prepare("INSERT INTO sms_history (user_id, recipient, message, status, response, sms_limit, sms_used, sent_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
  $stmt->bind_param("issssii", $userId, $to, $msg, $status, $response, $smsLimit, $smsUsed);
  $stmt->execute();
  $stmt->close();
}

function logSmsByUser($db, $userId, $senderId, $numbers, $msg) {
  $contacts = implode(',', $numbers);
  $stmt = $db->prepare("INSERT INTO sms_logs (user_id, sender_id, contacts, message, status) VALUES (?, ?, ?, ?, 'sent')");
  $stmt->bind_param("isss", $userId, $senderId, $contacts, $msg);
  $stmt->execute();
  $stmt->close();
}

// Session check
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
  exit(json_encode(['status' => 'error', 'message' => 'Not logged in']));
}

// Inputs
$senderId = $_POST['sender_id'] ?? '';
$message = trim($_POST['message'] ?? '');
$inputMethod = $_POST['inputMethod'] ?? 'manual';

if (!$senderId || !$message) {
  exit(json_encode(['status' => 'error', 'message' => 'Sender ID and message required']));
}

// Collect phone numbers
$numbers = [];

if ($inputMethod === 'manual' && !empty($_POST['phone_numbers'])) {
  foreach (explode(',', $_POST['phone_numbers']) as $p) {
    $clean = trim($p);
    if ($clean) $numbers[] = $clean;
  }
}

if ($inputMethod === 'file' && isset($_FILES['contacts_file']) && $_FILES['contacts_file']['error'] === 0) {
  try {
    $sheet = IOFactory::load($_FILES['contacts_file']['tmp_name'])->getActiveSheet();
    foreach ($sheet->toArray() as $i => $row) {
      if ($i === 0) continue; // Skip header
      $cell = trim($row[0]);
      if ($cell) $numbers[] = $cell;
    }
  } catch (Exception $e) {
    exit(json_encode(['status' => 'error', 'message' => 'Excel error: ' . $e->getMessage()]));
  }
}

$numbers = array_unique($numbers);
$totalToSend = count($numbers);

if ($totalToSend === 0) {
  exit(json_encode(['status' => 'error', 'message' => 'No valid phone numbers']));
}

// Fetch latest sms_limit and count only successful ones
$stmt = $db->prepare("
  SELECT 
    (SELECT sms_limit FROM sms_history WHERE user_id = ? AND sms_limit IS NOT NULL ORDER BY sent_at DESC LIMIT 1) AS sms_limit,
    (SELECT COUNT(*) FROM sms_history WHERE user_id = ? AND status = 'success') AS sms_used
");
$stmt->bind_param("ii", $userId, $userId);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

$smsLimit = isset($res['sms_limit']) ? (int)$res['sms_limit'] : null;
$smsUsed = (int)$res['sms_used'];

// Assign 1 free SMS if user is new
if ($smsLimit === null) {
  $smsLimit = 1;
  $smsUsed = 0;
  $stmt = $db->prepare("INSERT INTO sms_history (user_id, recipient, message, status, response, sms_limit, sms_used, sent_at) VALUES (?, '-', '-', 'success', 'Free SMS assigned', ?, 0, NOW())");
  $stmt->bind_param("ii", $userId, $smsLimit);
  $stmt->execute();
  $stmt->close();
}

$smsRemaining = $smsLimit - $smsUsed;

if ($smsRemaining <= 0) {
  exit(json_encode(['status' => 'error', 'message' => 'SMS limit reached. Contact admin for extension.']));
}

if ($totalToSend > $smsRemaining) {
  exit(json_encode([
    'status' => 'error',
    'message' => "Only $smsRemaining SMS left. You tried sending $totalToSend."
  ]));
}

// Send SMS
$success = 0;
$failures = [];

foreach ($numbers as $phone) {
  if (!isValidNumber($phone)) {
    $failures[] = "$phone (invalid)";
    logSms($db, $userId, $phone, $message, 'failed', 'Invalid number', $smsLimit, $smsUsed);
    continue;
  }

  $payload = json_encode([
    'recipient' => [$phone],
    'sender' => $senderId,
    'message' => $message,
    'is_schedule' => false
  ]);

  $context = stream_context_create([
    'http' => [
      'method' => 'POST',
      'header' => "Content-Type: application/json\r\n",
      'content' => $payload
    ]
  ]);

  $response = @file_get_contents($smsUrl, false, $context);

  if ($response !== false) {
    $success++;
    $smsUsed++;
    $smsRemaining--;
    logSms($db, $userId, $phone, $message, 'success', $response, $smsLimit, $smsUsed);
  } else {
    $failures[] = "$phone (failed)";
    logSms($db, $userId, $phone, $message, 'failed', 'Send failed', $smsLimit, $smsUsed);
  }
}

// Log batch
if ($success > 0) {
  logSmsByUser($db, $userId, $senderId, $numbers, $message);
}

if ($success > 0 && empty($failures)) {
  echo json_encode([
    'status' => 'success',
    'message' => "$success SMS sent successfully."
  ]);
} else {
  echo json_encode([
    'status' => 'error',
    'message' => "$success sent, " . count($failures) . " failed: " . implode(', ', $failures) . ".",
    'failed' => $failures
  ]);
}




