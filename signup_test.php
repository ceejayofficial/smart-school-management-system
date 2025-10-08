<?php
session_start();
require_once "db.php"; // expects $conn (mysqli)

// ---------- Test admin user ----------
$username        = "Admin";
$email           = "email@gmail.com";
$phone           = "0541234567";
$password_plain  = "123"; // test password
$role            = "admin";
$unique_code     = uniqid("U"); // auto-generated

// ---------- School info ----------
$school_name     = "Bright Future International School";
$school_logo     = "assets/images/school_logo.png"; // path to logo
$school_address  = "12 Education Ave, Accra, Ghana";
$school_phone    = "+233541234567";
$school_email    = "info@brightfuture.edu.gh";
$school_motto    = "Knowledge. Character. Leadership.";

// Hash password
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Begin transaction
$conn->begin_transaction();

try {
    // ---------- 1) Insert school ----------
    $stmt = $conn->prepare("SELECT school_id FROM schools WHERE school_name = ?");
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();

        $insertSchool = $conn->prepare(
            "INSERT INTO schools (school_name, logo, address, phone, email, motto, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        $insertSchool->bind_param("ssssss", $school_name, $school_logo, $school_address, $school_phone, $school_email, $school_motto);
        $insertSchool->execute();
        $school_id = $insertSchool->insert_id;
        $insertSchool->close();

        echo "<p>✅ School created successfully. School ID: {$school_id}</p>";
    } else {
        $stmt->bind_result($school_id);
        $stmt->fetch();
        $stmt->close();
        echo "<p>ℹ️ School already exists. School ID: {$school_id}</p>";
    }

    // ---------- 2) Insert admin user linked to school ----------
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();

        $insertUser = $conn->prepare(
            "INSERT INTO users (username, email, phone, unique_code, password, role, school_id, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $insertUser->bind_param("ssssssi", $username, $email, $phone, $unique_code, $password_hash, $role, $school_id);
        $insertUser->execute();
        $user_id = $insertUser->insert_id;
        $insertUser->close();

        echo "<p>✅ Test admin account created successfully. User ID: {$user_id}</p>";
    } else {
        $stmt->close();
        echo "<p>ℹ️ Test admin account already exists.</p>";
    }

    $conn->commit();

    // ---------- 3) Output credentials ----------
    echo "<h3>Admin Credentials</h3>";
    echo "<p><b>Email:</b> {$email}</p>";
    echo "<p><b>Password:</b> {$password_plain}</p>";
    echo "<p><b>School:</b> {$school_name}</p>";
    echo "<p><b>School ID:</b> {$school_id}</p>";

} catch (Exception $e) {
    $conn->rollback();
    echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

$conn->close();
?>
