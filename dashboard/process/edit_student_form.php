<?php
require_once "../../db.php";
require_once "../includes/auth.php";



if (!isset($_GET['id'])) {
    echo "<p class='text-red-500'>Student ID is missing.</p>";
    exit;
}

$student_id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE student_id = $student_id");

if (!$result || $result->num_rows === 0) {
    echo "<p class='text-red-500'>Student not found.</p>";
    exit;
}

$student = $result->fetch_assoc();
?>

<h2 class="text-xl font-semibold mb-4 text-gray-700">Edit Student</h2>

<form action="admin_dashboard.php?process=update_student&id=<?= $student['student_id'] ?>" method="POST">
    <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-600">Application ID</label>
            <input disabled type="text" name="application_id" value="<?= htmlspecialchars($student['application_id']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">First Name</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Last Name</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">DOB</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($student['dob']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Gender</label>
            <select name="gender" class="w-full p-2 border border-gray-300 rounded">
                <option value="Male" <?= $student['gender']=='Male'?'selected':'' ?>>Male</option>
                <option value="Female" <?= $student['gender']=='Female'?'selected':'' ?>>Female</option>
                <option value="Other" <?= $student['gender']=='Other'?'selected':'' ?>>Other</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-600">Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Level</label>
            <input type="text" name="level" value="<?= htmlspecialchars($student['level']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Class</label>
            <input type="text" name="class_name" value="<?= htmlspecialchars($student['class_name']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>

        <!-- Add remaining fields -->
        <div>
            <label class="block text-gray-600">Father Name</label>
            <input type="text" name="father_name" value="<?= htmlspecialchars($student['father_name']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Father Phone</label>
            <input type="text" name="father_phone" value="<?= htmlspecialchars($student['father_phone']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Mother Name</label>
            <input type="text" name="mother_name" value="<?= htmlspecialchars($student['mother_name']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Mother Phone</label>
            <input type="text" name="mother_phone" value="<?= htmlspecialchars($student['mother_phone']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Passport</label>
            <input type="text" name="passport" value="<?= htmlspecialchars($student['passport']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>
        <div>
            <label class="block text-gray-600">Passport Type</label>
            <input type="text" name="passport_type" value="<?= htmlspecialchars($student['passport_type']) ?>" 
                   class="w-full p-2 border border-gray-300 rounded"/>
        </div>

        <!-- Continue for remaining columns like disability, region, town, etc. -->
    </div>

    <div class="flex justify-end mt-4 space-x-2">
        <button type="button" onclick="closeEditModal()" 
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Update</button>
    </div>
</form>
