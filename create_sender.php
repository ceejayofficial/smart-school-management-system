<?php
if (session_status() === PHP_SESSION_NONE) session_start();
ob_start();
require __DIR__ . '/vendor/autoload.php';
require_once 'db.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$sender_name = trim($input['sender_name'] ?? '');
$purpose = trim($input['purpose'] ?? '');

if ($sender_name === '' || $purpose === '') {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Sender name and purpose are required.']);
    exit;
}

// ✅ Check user sender count
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM sender_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userSenderCount = $result->fetch_assoc()['total'] ?? 0;
$stmt->close();

// ✅ Get user's limit
$stmt = $conn->prepare("SELECT `limit` FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userLimit = $result->fetch_assoc()['limit'] ?? 3;
$stmt->close();

if ($userSenderCount >= $userLimit) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => "Sender ID limit of $userLimit reached."]);
    exit;
}

// ✅ Check if sender name already exists for the same user
$stmt = $conn->prepare("SELECT id FROM sender_id WHERE user_id = ? AND sender_name = ?");
$stmt->bind_param("is", $user_id, $sender_name);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => "Sender name already exists."]);
    exit;
}
$stmt->close();

// ✅ Call MNotify API
$apiUrl = $_ENV['MNOTIFY_SENDER_REGISTER_URL'] ?? '';
if (!$apiUrl) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'MNotify URL is missing.']);
    exit;
}

$payload = json_encode([
    'sender_name' => $sender_name,
    'purpose' => $purpose
]);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => "Network Failure "]);
    exit;
}

$mnotify = json_decode($response, true);

if (isset($mnotify['status']) && $mnotify['status'] === 'success') {
    $stmt = $conn->prepare("INSERT INTO sender_id (user_id, sender_name, purpose) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $sender_name, $purpose);
    if (!$stmt->execute()) {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
        $stmt->close();
        exit;
    }
    $stmt->close();

    ob_clean();
    echo json_encode([
        'status' => 'success',
        'message' => 'Sender ID created and saved.',
        'mnotify_response' => $mnotify
    ]);
    exit;
} else {
    ob_clean();
    $msg = $mnotify['message'] ?? 'Unknown  error.';
    echo json_encode([
        'status' => 'error',
        'message' => " failed: $msg",
        'mnotify_response' => $mnotify
    ]);
    exit;
}
