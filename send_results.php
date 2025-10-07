<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Dotenv\Dotenv;

header('Content-Type: application/json');

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// DB connect
$db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
if ($db->connect_error) {
  echo json_encode(['status' => 'error', 'message' => 'DB connection failed']);
  exit;
}

// Generate unique reference
function generateUniqueRef($length = 6) {
  return bin2hex(random_bytes($length));
}

$userId = $_SESSION['user_id'] ?? 0;
$smsUrl = $_ENV['MNOTIFY_SMS_URL'];
$senderId = $_POST['sender_id'] ?? '';
if (!$senderId) {
  echo json_encode(['status' => 'error', 'message' => 'Sender ID required']);
  exit;
}

// Get SMS limit
$stmt = $db->prepare("
  SELECT 
    (SELECT sms_limit FROM sms_history WHERE user_id = ? AND sms_limit IS NOT NULL ORDER BY sent_at DESC LIMIT 1) AS sms_limit,
    (SELECT COUNT(*) FROM sms_history WHERE user_id = ? AND status = 'success') AS sms_used
");
$stmt->bind_param("ii", $userId, $userId);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

$smsLimit = $res['sms_limit'] ?? 1;
$smsUsed = $res['sms_used'] ?? 0;
$smsRemaining = $smsLimit - $smsUsed;

if ($smsLimit === null) {
  $smsLimit = 1;
  $smsUsed = 0;
  $stmt = $db->prepare("INSERT INTO sms_history (user_id, recipient, message, status, response, sms_limit, sms_used, sent_at) VALUES (?, '-', '-', 'info', 'Free SMS assigned', ?, 0, NOW())");
  $stmt->bind_param("ii", $userId, $smsLimit);
  $stmt->execute();
  $stmt->close();
}

if ($smsRemaining <= 0) {
  echo json_encode(['status' => 'error', 'message' => 'SMS limit reached. Contact admin.']);
  exit;
}

$sentCount = 0;
$skippedCount = 0;
$rows = [];

if (isset($_FILES['results_file']) && $_FILES['results_file']['error'] === 0) {
  try {
    $spreadsheet = IOFactory::load($_FILES['results_file']['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();
    $dataRows = $sheet->toArray(null, true, true, true);
    $headers = array_values($dataRows[1]);
    unset($dataRows[1]);

    // Locate programme and promoted columns
    $programmeIndex = array_search('programme', array_map('strtolower', $headers));
    $promotedIndex = array_search('promoted', array_map('strtolower', $headers));

    foreach ($dataRows as $row) {
      $values = array_values($row);
      $rows[] = [
        'number' => $values[0] ?? '',
        'semester' => $values[1] ?? '',
        'name' => $values[2] ?? '',
        'programme' => $programmeIndex !== false ? ($values[$programmeIndex] ?? '') : '',
        'promoted' => $promotedIndex !== false ? ($values[$promotedIndex] ?? '') : '',
        'subjects' => array_slice($values, 3),
        'headers' => $headers
      ];
    }

  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Excel error: ' . $e->getMessage()]);
    exit;
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'No Excel file uploaded']);
  exit;
}

// 🔁 Loop and send
foreach ($rows as $row) {
  if ($smsRemaining <= 0) break;

  $num = preg_replace('/\D/', '', $row['number']);
  if (preg_match('/^0\d{9}$/', $num)) {
    $formatted = '233' . substr($num, 1);
  } elseif (preg_match('/^233\d{9}$/', $num)) {
    $formatted = $num;
  } else {
    $skippedCount++;
    continue;
  }

  // Build results part
  $subjectText = [];
  foreach ($row['subjects'] as $i => $entry) {
    if (!empty($entry)) {
      $headerIndex = $i + 3;
      $subject = isset($row['headers'][$headerIndex]) ? strtoupper(trim($row['headers'][$headerIndex])) : "SUB" . ($i + 1);
      if (strtolower($subject) === 'programme' || strtolower($subject) === 'promoted') {
        continue;
      }
      $subjectText[] = "$subject: $entry";
    }
  }

  if (empty($subjectText)) {
    $skippedCount++;
    continue;
  }

  $name = $row['name'];
  $sem = $row['semester'];
  $prog = trim($row['programme']);
  $promotion = trim($row['promoted']);

  $subjectLines = implode("\n", $subjectText);

  $message = "Hi, your ward $name's results for $sem are:\n$subjectLines";

  if (!empty($promotion)) {
    $message .= "\nPromoted to: $promotion";
  }

  // Add result view link
  $ref = generateUniqueRef();
  $link = $_ENV['BASE_URL'] . "/view_result.php?ref=$formatted";
  $message .= "\nView: $link";

  // Send SMS
  $payload = json_encode([
    'recipient' => [$formatted],
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
  $result = $response ? json_decode($response, true) : null;

  $status = 'failed';
  if ($result && $result['code'] === '2000') {
    $status = 'success';
    $sentCount++;
    $smsUsed++;
    $smsRemaining--;

    $stmt = $db->prepare("INSERT INTO sms_history (user_id, recipient, message, status, response, sms_limit, sms_used, sent_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issssii", $userId, $formatted, $message, $status, $response, $smsLimit, $smsUsed);
    $stmt->execute();
    $stmt->close();

    // Save result ref
    $stmt = $db->prepare("INSERT INTO result_links (user_id, phone, ref_code, full_message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isss", $userId, $formatted, $ref, $message);
    $stmt->execute();
    $stmt->close();
  }

  $stmt = $db->prepare("INSERT INTO sms_results (user_id, phone, student_name, semester, message, status, sent_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
  $stmt->bind_param("isssss", $userId, $formatted, $name, $sem, $message, $status);
  $stmt->execute();
  $stmt->close();
}

echo json_encode(['status' => 'success', 'message' => "Sent $sentCount, Skipped $skippedCount"]);
