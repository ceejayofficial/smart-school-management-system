<?php
session_start();
include("db.php");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $unique_code = trim($_POST['unique_code'] ?? '');

    if (empty($email) || empty($unique_code)) {
        $error = "Please provide both email and unique code.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND unique_code = ?");
        $stmt->bind_param("ss", $email, $unique_code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $_SESSION['reset_user_id'] = $user_id;
            header("Location: reset-password.php");
            exit();
        } else {
            $error = "Invalid email or unique code.";
        }

        $stmt->close();
    }
}
