<?php
require_once '../../db.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = intval($_POST['user_id']);
        $sender_name = trim($_POST['sender_name']);
        $purpose = trim($_POST['purpose']);

        if ($user_id && $sender_name && $purpose) {
            $stmt = $conn->prepare("INSERT INTO sender_id (user_id, sender_name, purpose, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iss", $user_id, $sender_name, $purpose);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
                exit;
            } else {
                throw new Exception($stmt->error);
            }
        } else {
            throw new Exception("All fields are required.");
        }
    } else {
        throw new Exception("Invalid request.");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
