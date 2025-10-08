<?php
session_start();
require_once "../db.php"; // Make sure your DB connection is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect student info safely
    $application_id = $_POST['application_id_hidden'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $nationality = trim($_POST['nationality'] ?? '');
    $religion = $_POST['religion'] ?? '';
    $disability = $_POST['disability'] ?? '';
    $previous_school = trim($_POST['previous_school'] ?? '');
    $town = trim($_POST['town'] ?? '');
    $ghana_card = trim($_POST['ghana_card'] ?? '');
    $house_address = trim($_POST['house_address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $region = $_POST['region'] ?? '';
    $special_student = isset($_POST['special_student']) ? 1 : 0;
    $level = $_POST['level'] ?? '';
    $class_name = $_POST['class_name'] ?? '';

    $father_name = trim($_POST['father_name'] ?? '');
    $father_phone = trim($_POST['father_phone'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $mother_phone = trim($_POST['mother_phone'] ?? '');
    $result_receiver = $_POST['result_receiver'] ?? '';

    // Handle passport upload
    $passport_path = '';
    if (isset($_FILES['passport']) && $_FILES['passport']['error'] === 0) {
        $file = $_FILES['passport'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (!in_array($file['type'], $allowed_types)) {
            die("❌ Invalid file type. Only JPEG, PNG, and GIF allowed.");
        }

        if ($file['size'] > 200 * 1024) { // 200KB limit
            die("❌ File too large. Maximum size allowed is 200KB.");
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'passport_' . uniqid() . '.' . $ext;
        $target_dir = "../uploads/passports/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $passport_path = $target_dir . $filename;
        if (!move_uploaded_file($file['tmp_name'], $passport_path)) {
            die("❌ Failed to upload passport photo.");
        }
    } else {
        die("❌ Passport photo is required.");
    }

    // Insert student record
    $stmt = $conn->prepare("INSERT INTO students 
        (application_id, first_name, last_name, dob, gender, nationality, religion, disability, previous_school, town, ghana_card, house_address, phone, region, special_student, level, class_name, father_name, father_phone, mother_name, mother_phone, result_receiver, passport) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "sssssssssssssssssssssss",
        $application_id, $first_name, $last_name, $dob, $gender, $nationality, $religion, $disability, $previous_school, $town, $ghana_card, $house_address, $phone, $region, $special_student, $level, $class_name, $father_name, $father_phone, $mother_name, $mother_phone, $result_receiver, $passport_path
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "✅ Student registered successfully!";
    } else {
        $_SESSION['error'] = "❌ Failed to register student. " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../dashboard/admin_dashboard.php?page=students");
    exit;
}
?>
