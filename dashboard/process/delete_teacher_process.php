<?php
session_start();
require_once "../../db.php";
require_once "../includes/auth.php";

// Check if teacher ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Teacher ID is missing.";
    header("Location: ../admin_dashboard.php?page=teachers-records");
    exit;
}

$teacher_id = (int)$_GET['id'];

// Check if teacher exists
$check = $conn->query("SELECT * FROM teachers WHERE teacher_id = $teacher_id");
if ($check->num_rows === 0) {
    $_SESSION['error'] = "Teacher not found.";
    header("Location: ../admin_dashboard.php?page=teachers-records");
    exit;
}

// Delete the teacher
if ($conn->query("DELETE FROM teachers WHERE teacher_id = $teacher_id")) {
    $_SESSION['success'] = "Teacher deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete teacher: " . $conn->error;
}

// Redirect back to teachers records page
header("Location: ../admin_dashboard.php?page=teachers_records");
exit;
?>
