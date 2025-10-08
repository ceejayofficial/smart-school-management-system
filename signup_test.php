<?php
session_start();
require_once "db.php";

// Test credentials
$username = "Admin";
$email    = "email@gmail.com";
$phone    = "0541234567";
$password_plain = "123"; // plain password for testing
$role     = "admin";
$unique_code = uniqid("U"); // auto-generate unique code

// Hash password
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Insert test record if it doesn’t already exist
$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();

    $insert = $conn->prepare("INSERT INTO users (username, email, phone, unique_code, password, role, created_at)
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $insert->bind_param("ssssss", $username, $email, $phone, $unique_code, $password_hash, $role);
    $insert->execute();
    $insert->close();

    echo "<h2>✅ Test account created successfully</h2>";
} else {
    echo "<h2>ℹ️ Test account already exists</h2>";
}

$stmt->close();

// Show credentials on screen
echo "<p><b>Email:</b> {$email}</p>";
echo "<p><b>Password:</b> {$password_plain}</p>";
?>
