<?php
session_start();
require_once "../../db.php";
require_once "../includes/auth.php";

// Check if student ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Student ID is missing.";
    header("Location: ../admin_dashboard.php?process=students-records");
    exit;
}

$student_id = (int)$_GET['id'];

// Check if student exists
$check = $conn->query("SELECT * FROM students WHERE student_id = $student_id");
if ($check->num_rows === 0) {
    $_SESSION['error'] = "Student not found.";
    header("Location: ../admin_dashboard.php?process=students-records");
    exit;
}

// Delete the student
if ($conn->query("DELETE FROM students WHERE student_id = $student_id")) {
    $_SESSION['success'] = "Student deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete student: " . $conn->error;
}

// Redirect back to students records page
header("Location: ../admin_dashboard.php?page=students-records");
exit;
