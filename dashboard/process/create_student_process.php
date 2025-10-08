<?php
require_once "../db.php"; // Database connection
require_once "./includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $appID = $_POST['application_id_hidden'];
    $first = htmlspecialchars($_POST['first_name']);
    $last = htmlspecialchars($_POST['last_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $nationality = htmlspecialchars($_POST['nationality']);
    $religion = $_POST['religion'];
    $disability = $_POST['disability'];
    $previous_school = htmlspecialchars($_POST['previous_school']);
    $region = $_POST['region'];
    $town = htmlspecialchars($_POST['town']);
    $ghana_card = $_POST['ghana_card'];
    $house_address = htmlspecialchars($_POST['house_address']);
    $phone = $_POST['phone'];
    $special = isset($_POST['special_student']) ? 1 : 0;
    $level = $_POST['level'];
    $class = $_POST['class_name'];
    $father_name = htmlspecialchars($_POST['father_name']);
    $father_phone = $_POST['father_phone'];
    $mother_name = htmlspecialchars($_POST['mother_name']);
    $mother_phone = $_POST['mother_phone'];
    $result_receiver = $_POST['result_receiver'];

    // Passport validation
    if (!isset($_FILES['passport']) || $_FILES['passport']['error'] !== 0) {
        echo "<script>
                Swal.fire('Oops!', 'Passport image is required.', 'error');
              </script>";
        exit;
    }

    if ($_FILES['passport']['size'] > 200000) {
        echo "<script>
                Swal.fire('Oops!', 'Passport image must be under 200KB.', 'error');
              </script>";
        exit;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['passport']['type'], $allowedTypes)) {
        echo "<script>
                Swal.fire('Oops!', 'Only JPG, PNG, and GIF formats are allowed.', 'error');
              </script>";
        exit;
    }

    $passportData = file_get_contents($_FILES['passport']['tmp_name']); // Binary
    $passportType = $_FILES['passport']['type'];

    // Prepare insert
    $stmt = $conn->prepare("INSERT INTO students (
        application_id, first_name, last_name, dob, gender, nationality, religion, disability,
        previous_school, region, town, ghana_card, house_address, phone, special_student,
        level, class_name, father_name, father_phone, mother_name, mother_phone,
        result_receiver, passport, passport_type
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        echo "<script>
                Swal.fire('Error!', 'Prepare failed: ".addslashes($conn->error)."', 'error');
              </script>";
        exit;
    }

    $stmt->bind_param(
        "ssssssssssssssisssssssss",
        $appID, $first, $last, $dob, $gender, $nationality, $religion, $disability,
        $previous_school, $region, $town, $ghana_card, $house_address, $phone, $special,
        $level, $class, $father_name, $father_phone, $mother_name, $mother_phone,
        $result_receiver, $passportData, $passportType
    );

    $stmt->send_long_data(22, $passportData); // For BLOB

    if ($stmt->execute()) {
        // Success alert and redirect back to create_student
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Student registered successfully.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../dashboard/admin_dashboard.php?page=create_student';
                });
              </script>";
        exit;
    } else {
        // Error alert
        $err = addslashes($stmt->error);
        echo "<script>
                Swal.fire('Error!', '{$err}', 'error');
              </script>";
        exit;
    }
}
?>
