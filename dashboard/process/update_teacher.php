<?php
require_once "../db.php";          // Database connection
require_once "./includes/auth.php"; // Authentication

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = $_POST['teacher_id'];
    $teacher_name   = $_POST['teacher_name'];
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name'];
    $dob            = $_POST['dob'];
    $gender         = $_POST['gender'];
    $phone          = $_POST['phone'];
    $email          = $_POST['email'];
    $qualification  = $_POST['qualification'];
    $experience     = $_POST['experience'];
    $employment_type= $_POST['employment_type'];
    $region         = $_POST['region'];
    $level          = $_POST['level'];
    $class_assigned = $_POST['class_assigned'];
    $subjects       = $_POST['subjects'];

    // Handle passport if uploaded
    $passportData = null;
    if (isset($_FILES['passport']) && $_FILES['passport']['error'] === UPLOAD_ERR_OK) {
        $passportData = file_get_contents($_FILES['passport']['tmp_name']);
    }

    if ($passportData) {
        $stmt = $conn->prepare("UPDATE teachers SET teacher_name=?, first_name=?, last_name=?, dob=?, gender=?, phone=?, email=?, qualification=?, experience=?, employment_type=?, region=?, level=?, class_assigned=?, subjects=?, passport=? WHERE teacher_id=?");
        $stmt->bind_param("sssssssssssssbss",
            $teacher_name, $first_name, $last_name, $dob, $gender, $phone, $email, $qualification, $experience, $employment_type, $region, $level, $class_assigned, $subjects, $passportData, $id
        );
    } else {
        $stmt = $conn->prepare("UPDATE teachers SET teacher_name=?, first_name=?, last_name=?, dob=?, gender=?, phone=?, email=?, qualification=?, experience=?, employment_type=?, region=?, level=?, class_assigned=?, subjects=? WHERE teacher_id=?");
        $stmt->bind_param("sssssssssssssss",
            $teacher_name, $first_name, $last_name, $dob, $gender, $phone, $email, $qualification, $experience, $employment_type, $region, $level, $class_assigned, $subjects, $id
        );
    }

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Teacher details updated successfully.'
            }).then(() => {
                window.location.href = '../dashboard/admin_dashboard.php?page=teachers_records';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update teacher. Please try again.'
            }).then(() => {
                window.location.href = '../dashboard/admin_dashboard.php?page=teachers_records';
            });
        </script>";
    }
}
?>
