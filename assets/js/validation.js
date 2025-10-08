<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    // TODO: Insert into database (example)
    // $conn = new mysqli(...);
    // $stmt = $conn->prepare("INSERT INTO students (...) VALUES (?, ?, ...)");
    // $stmt->bind_param(...);
    // $stmt->execute();

    header("Location: ../admin_dashboard.php?page=students&success=1");
    exit;
}
?>
