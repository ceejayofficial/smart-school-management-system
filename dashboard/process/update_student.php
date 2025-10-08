<?php
require_once "../db.php";          // Database connection
require_once "./includes/auth.php"; // Authentication

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student_id = intval($_POST['student_id']);
    $application_id = $conn->real_escape_string($_POST['application_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $level = $conn->real_escape_string($_POST['level']);
    $class_name = $conn->real_escape_string($_POST['class_name']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $father_phone = $conn->real_escape_string($_POST['father_phone']);
    $mother_name = $conn->real_escape_string($_POST['mother_name']);
    $mother_phone = $conn->real_escape_string($_POST['mother_phone']);
    $passport = $conn->real_escape_string($_POST['passport']);
    $passport_type = $conn->real_escape_string($_POST['passport_type']);

    $sql = "UPDATE students SET 
                application_id='$application_id',
                first_name='$first_name',
                last_name='$last_name',
                dob='$dob',
                gender='$gender',
                phone='$phone',
                level='$level',
                class_name='$class_name',
                father_name='$father_name',
                father_phone='$father_phone',
                mother_name='$mother_name',
                mother_phone='$mother_phone',
                passport='$passport',
                passport_type='$passport_type'
            WHERE student_id=$student_id";

    if ($conn->query($sql)) {
        // Success - show SweetAlert and redirect
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Update Success</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Student record updated successfully',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '../dashboard/admin_dashboard.php?page=students-records';
            });
        </script>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "Error updating student: " . $conn->error;
    }

} else {
    echo "Invalid request.";
}
?>
