<?php
require_once "../db.php";
require_once "./includes/auth.php";

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: 'You are not authorized to perform this action.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '../login.php';
        });
    </script>";
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect inputs
    $teacher_id     = trim($_POST['teacher_id_hidden'] ?? '');
    $first_name     = trim($_POST['first_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $dob            = trim($_POST['dob'] ?? '');
    $gender         = trim($_POST['gender'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $qualification  = trim($_POST['qualification'] ?? '');
    $experience     = trim($_POST['experience'] ?? '');
    $employment     = trim($_POST['employment_type'] ?? '');
    $region         = trim($_POST['region'] ?? '');
    $level          = trim($_POST['level'] ?? '');
    $class_assigned = trim($_POST['class_assigned'] ?? '');
    $subjects       = $_POST['subjects'] ?? [];
    $teacher_name   = $first_name . " " . $last_name;

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    // === VALIDATION ===
    if (
        empty($teacher_id) || empty($first_name) || empty($last_name) || empty($dob) ||
        empty($gender) || empty($phone) || empty($email) || empty($qualification) ||
        $experience === '' || empty($employment) || empty($region) ||
        empty($level) || empty($class_assigned) || empty($subjects)
    ) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Missing Fields', text: 'All fields are required.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $first_name) || !preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Invalid Name', text: 'First and Last name must contain only letters and spaces.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Invalid Email', text: 'Please enter a valid email address.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    if (!preg_match("/^[0-9]{7,15}$/", $phone)) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Invalid Phone', text: 'Phone must be between 7 and 15 digits.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    if (!is_numeric($experience) || (int)$experience < 0) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Invalid Experience', text: 'Experience must be a non-negative number.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    // === PASSPORT UPLOAD VALIDATION ===
    if (!isset($_FILES['passport']) || $_FILES['passport']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Passport Error', text: 'Passport photo is required.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    $passport = $_FILES['passport'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($passport['type'], $allowedTypes)) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Only JPG and PNG images are allowed.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    if ($passport['size'] > 200 * 1024) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Passport photo must not exceed 200KB.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }

    $ext = pathinfo($passport['name'], PATHINFO_EXTENSION);
    $passportFilename = $teacher_id . "_passport." . strtolower($ext);
    $uploadDir = "../uploads/passports/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $passportPath = $uploadDir . $passportFilename;
    move_uploaded_file($passport['tmp_name'], $passportPath);

    // === CONVERT SUBJECTS ARRAY TO STRING ===
    $subjects_str = implode(',', $subjects);

    // === CHECK DUPLICATE EMAIL ===
    $stmt = $conn->prepare("SELECT teacher_id FROM teachers WHERE email = ?");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Duplicate Email', text: 'This email is already registered.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    }
    $stmt->close();

    // === INSERT TEACHER ===
    $stmt = $conn->prepare("INSERT INTO teachers 
        (teacher_id, teacher_name, first_name, last_name, dob, gender, phone, email, qualification, experience, employment_type, region, level, class_assigned, passport, subjects) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }

    $stmt->bind_param(
        "ssssssssssssssss",
        $teacher_id, $teacher_name, $first_name, $last_name, $dob, $gender,
        $phone, $email, $qualification, $experience, $employment, $region, $level, $class_assigned, $passportFilename, $subjects_str
    );

    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>
            Swal.fire({ icon: 'success', title: 'Success!', text: 'Teacher registered successfully.' })
            .then(() => window.location.href = '../dashboard/admin_dashboard.php?page=create_teacher');
        </script>";
        exit;
    } else {
        echo "Database Error: " . $conn->error;
        exit;
    }
}
?>
