<?php
session_start();
include(__DIR__ . '/../../../db.php'); 

$error = '';
$success = '';

// Only allow access if verified
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: /sms-sender/forgot-password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pass = trim($_POST['new_password'] ?? '');
    $confirm_pass = trim($_POST['confirm_password'] ?? '');

    if (empty($new_pass) || empty($confirm_pass)) {
        $error = "All fields are required.";
    } elseif ($new_pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } else {
        $user_id = $_SESSION['reset_user_id'];
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_pass, $user_id);
        if ($stmt->execute()) {
            unset($_SESSION['reset_user_id']);
            header("Location: /sms-sender/index.php?reset=success");
            exit();
        } else {
            $error = "Failed to reset password. Try again.";
        }
        $stmt->close();
    }
}


