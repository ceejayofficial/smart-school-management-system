<?php
require_once "../../db.php";
require_once "../includes/auth.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid student ID.</p>";
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($student):
?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><strong>Student ID:</strong> <?= htmlspecialchars($student['student_id']) ?></div>
    <div><strong>Application ID:</strong> <?= htmlspecialchars($student['application_id']) ?></div>
    <div><strong>First Name:</strong> <?= htmlspecialchars($student['first_name']) ?></div>
    <div><strong>Last Name:</strong> <?= htmlspecialchars($student['last_name']) ?></div>
    <div><strong>Date of Birth:</strong> <?= htmlspecialchars($student['dob']) ?></div>
    <div><strong>Gender:</strong> <?= htmlspecialchars($student['gender']) ?></div>
    <div><strong>Nationality:</strong> <?= htmlspecialchars($student['nationality']) ?></div>
    <div><strong>Religion:</strong> <?= htmlspecialchars($student['religion']) ?></div>
    <div><strong>Disability:</strong> <?= htmlspecialchars($student['disability']) ?></div>
    <div><strong>Previous School:</strong> <?= htmlspecialchars($student['previous_school']) ?></div>
    <div><strong>Region:</strong> <?= htmlspecialchars($student['region']) ?></div>
    <div><strong>Town:</strong> <?= htmlspecialchars($student['town']) ?></div>
    <div><strong>Ghana Card:</strong> <?= htmlspecialchars($student['ghana_card']) ?></div>
    <div><strong>House Address:</strong> <?= htmlspecialchars($student['house_address']) ?></div>
    <div><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></div>
    <div><strong>Special Student:</strong> <?= htmlspecialchars($student['special_student']) ?></div>
    <div><strong>Level:</strong> <?= htmlspecialchars($student['level']) ?></div>
    <div><strong>Class Name:</strong> <?= htmlspecialchars($student['class_name']) ?></div>
    <div><strong>Father Name:</strong> <?= htmlspecialchars($student['father_name']) ?></div>
    <div><strong>Father Phone:</strong> <?= htmlspecialchars($student['father_phone']) ?></div>
    <div><strong>Mother Name:</strong> <?= htmlspecialchars($student['mother_name']) ?></div>
    <div><strong>Mother Phone:</strong> <?= htmlspecialchars($student['mother_phone']) ?></div>
    <div><strong>Result Receiver:</strong> <?= htmlspecialchars($student['result_receiver']) ?></div>

    <div class="col-span-2">
        <strong>Passport:</strong><br>
        <?php if(!empty($student['passport'])): ?>
            <img src="data:<?= htmlspecialchars($student['passport_type']) ?>;base64,<?= base64_encode($student['passport']) ?>" 
                 alt="Passport" class="w-32 h-32 object-cover rounded">
        <?php else: ?>
            <p>No passport uploaded.</p>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<p>Student not found.</p>
<?php endif; ?>
