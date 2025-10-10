<?php
require_once "../../db.php";
require_once "../includes/auth.php";

// Validate teacher ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid teacher ID.</p>";
    exit;
}

$id = $_GET['id']; // teacher_id is string like TCH001

// Fetch teacher
$stmt = $conn->prepare("SELECT * FROM teachers WHERE teacher_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $id); // "s" = string
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if ($teacher):
?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><strong>Teacher ID:</strong> <?= htmlspecialchars($teacher['teacher_id']) ?></div>
    <div><strong>Full Name:</strong> <?= htmlspecialchars($teacher['teacher_name']) ?></div>
    <div><strong>First Name:</strong> <?= htmlspecialchars($teacher['first_name']) ?></div>
    <div><strong>Last Name:</strong> <?= htmlspecialchars($teacher['last_name']) ?></div>
    <div><strong>Date of Birth:</strong> <?= htmlspecialchars($teacher['dob']) ?></div>
    <div><strong>Gender:</strong> <?= htmlspecialchars($teacher['gender']) ?></div>
    <div><strong>Phone:</strong> <?= htmlspecialchars($teacher['phone']) ?></div>
    <div><strong>Email:</strong> <?= htmlspecialchars($teacher['email']) ?></div>
    <div><strong>Qualification:</strong> <?= htmlspecialchars($teacher['qualification']) ?></div>
    <div><strong>Experience:</strong> <?= htmlspecialchars($teacher['experience']) ?></div>
    <div><strong>Employment Type:</strong> <?= htmlspecialchars($teacher['employment_type']) ?></div>
    <div><strong>Region:</strong> <?= htmlspecialchars($teacher['region']) ?></div>
    <div><strong>Level:</strong> <?= htmlspecialchars($teacher['level']) ?></div>
    <div><strong>Class Assigned:</strong> <?= htmlspecialchars($teacher['class_assigned']) ?></div>
    <div><strong>Subjects:</strong> <?= htmlspecialchars($teacher['subjects']) ?></div>

    <div class="col-span-2">
        <strong>Passport:</strong><br>
        <?php if (!empty($teacher['passport'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($teacher['passport']) ?>" 
                 alt="Passport" class="w-32 h-32 object-cover rounded border">
        
                 <?php else: ?>
            <p>No passport uploaded.</p>
        <?php endif; ?>
    </div>

    
</div>
<?php else: ?>
<p>Teacher not found.</p>
<?php endif; ?>
