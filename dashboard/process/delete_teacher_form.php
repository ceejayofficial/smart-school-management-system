<?php
require_once "../../db.php";
require_once "../includes/auth.php";

// Validate teacher ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid teacher ID.</p>";
    exit;
}

$id = $_GET['id'];

// Fetch teacher
$stmt = $conn->prepare("SELECT teacher_id, teacher_name FROM teachers WHERE teacher_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if (!$teacher) {
    echo "<p>Teacher not found.</p>";
    exit;
}
?>

<h2 class="text-xl font-bold mb-4 text-red-600">Delete Teacher</h2>
<p>Are you sure you want to delete <strong><?= htmlspecialchars($teacher['teacher_name']) ?></strong> (ID: <?= htmlspecialchars($teacher['teacher_id']) ?>)?</p>

<form action="delete_teacher&id=<?= $teacher['teacher_id'] ?>" method="POST">
    <input type="hidden" name="teacher_id" value="<?= htmlspecialchars($teacher['teacher_id']) ?>">
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Yes, Delete</button>
    <a href="view_teacher.php?id=<?= htmlspecialchars($teacher['teacher_id']) ?>" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
</form>
