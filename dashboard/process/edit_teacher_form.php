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
$stmt = $conn->prepare("SELECT * FROM teachers WHERE teacher_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if (!$teacher) {
    echo "<p>Teacher not found.</p>";
    exit;
}
?>

<h2 class="text-xl font-bold mb-4">Edit Teacher</h2>

<form action="../dashboard/admin_dashboard.php?process=update_teacher&id=<?= htmlspecialchars($teacher['teacher_id']) ?>" 
      method="POST" enctype="multipart/form-data" 
      class="grid grid-cols-1 gap-4">

    <input type="hidden" name="teacher_id" value="<?= htmlspecialchars($teacher['teacher_id']) ?>">

    <label>Full Name:
        <input type="text" name="teacher_name" value="<?= htmlspecialchars($teacher['teacher_name']) ?>" class="border p-2 w-full">
    </label>

    <label>First Name:
        <input type="text" name="first_name" value="<?= htmlspecialchars($teacher['first_name']) ?>" class="border p-2 w-full">
    </label>

    <label>Last Name:
        <input type="text" name="last_name" value="<?= htmlspecialchars($teacher['last_name']) ?>" class="border p-2 w-full">
    </label>

    <label>Date of Birth:
        <input type="date" name="dob" value="<?= htmlspecialchars($teacher['dob']) ?>" class="border p-2 w-full">
    </label>

    <label>Gender:
        <input type="text" name="gender" value="<?= htmlspecialchars($teacher['gender']) ?>" class="border p-2 w-full">
    </label>

    <label>Phone:
        <input type="text" name="phone" value="<?= htmlspecialchars($teacher['phone']) ?>" class="border p-2 w-full">
    </label>

    <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($teacher['email']) ?>" class="border p-2 w-full">
    </label>

    <label>Qualification:
        <input type="text" name="qualification" value="<?= htmlspecialchars($teacher['qualification']) ?>" class="border p-2 w-full">
    </label>

    <label>Experience:
        <input type="text" name="experience" value="<?= htmlspecialchars($teacher['experience']) ?>" class="border p-2 w-full">
    </label>

    <label>Employment Type:
        <input type="text" name="employment_type" value="<?= htmlspecialchars($teacher['employment_type']) ?>" class="border p-2 w-full">
    </label>

    <label>Region:
        <input type="text" name="region" value="<?= htmlspecialchars($teacher['region']) ?>" class="border p-2 w-full">
    </label>

    <label>Level:
        <input type="text" name="level" value="<?= htmlspecialchars($teacher['level']) ?>" class="border p-2 w-full">
    </label>

    <label>Class Assigned:
        <input type="text" name="class_assigned" value="<?= htmlspecialchars($teacher['class_assigned']) ?>" class="border p-2 w-full">
    </label>

    <label>Subjects:
        <input type="text" name="subjects" value="<?= htmlspecialchars($teacher['subjects']) ?>" class="border p-2 w-full">
    </label>

    <label>Passport:
        <input type="file" name="passport" class="border p-2 w-full">
    </label>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
</form>
