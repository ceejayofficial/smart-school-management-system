<?php
require_once "../db.php";
require_once "./includes/auth.php";

// Pagination settings
$limit = 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$offset = ($page - 1) * $limit;

// Total students
$totalResult = $conn->query("SELECT COUNT(*) as total FROM students");
$totalStudents = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalStudents / $limit);

// Fetch students for current page
$result = $conn->query("SELECT * FROM students ORDER BY student_id DESC LIMIT $limit OFFSET $offset");
?>

<div class="p-8 h-screen bg-white ml-0 md:ml-64 overflow-auto">

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Search students..." 
               class="w-full md:w-4/4 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <?php if (!$result || $result->num_rows === 0): ?>
        <p class="text-gray-500">No students found.</p>
    <?php else: ?>
        <div class="overflow-auto border rounded shadow">
            <table id="studentsTable" class="min-w-full border-collapse border border-gray-200 text-sm">
                <thead class="bg-gray-100 sticky top-0">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">App ID</th>
                        <th class="p-2 border">First Name</th>
                        <th class="p-2 border">Last Name</th>
                        <th class="p-2 border">DOB</th>
                        <th class="p-2 border">Gender</th>
                        <th class="p-2 border">Phone</th>
                        <th class="p-2 border">Level</th>
                        <th class="p-2 border">Class</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($student = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border"><?= $student['student_id'] ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['application_id']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['first_name']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['last_name']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['dob']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['gender']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['phone']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['level']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($student['class_name']) ?></td>
                            <td class="p-2 border space-x-1">
                                <button onclick="viewStudent(<?= $student['student_id'] ?>)" 
                                        class="px-2 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition">View</button>
                                <button onclick="editStudent(<?= $student['student_id'] ?>)" 
                                        class="px-2 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600 transition">Edit</button>
                                <button onclick="deleteStudent(<?= $student['student_id'] ?>)" 
                                        class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600 transition">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center space-x-2">
            <?php for ($i=1; $i <= $totalPages; $i++): ?>
                <a href="/dashboard/admin_dashboard.php?process=students-records&page_num=<?= $i ?>" 
                   class="px-3 py-1 border rounded <?= $i==$page?'bg-blue-500 text-white':'bg-white text-gray-700 hover:bg-gray-200' ?>">
                   <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- View Student Modal -->
<div id="studentModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow max-w-3xl w-full relative overflow-auto max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 text-xl font-bold">&times;</button>
        <div id="studentDetails"></div>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editStudentModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow max-w-3xl w-full relative overflow-auto max-h-[90vh]">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-600 text-xl font-bold">&times;</button>
        <div id="editStudentContent"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function viewStudent(id){
    fetch(`process/view_student.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('studentDetails').innerHTML = html;
            document.getElementById('studentModal').classList.remove('hidden');
        });
}
function closeModal(){
    document.getElementById('studentModal').classList.add('hidden');
}

function editStudent(id){
    fetch(`process/edit_student_form.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editStudentContent').innerHTML = html;
            document.getElementById('editStudentModal').classList.remove('hidden');
        });
}
function closeEditModal(){
    document.getElementById('editStudentModal').classList.add('hidden');
}

function deleteStudent(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = `process/delete_student_process.php?id=${id}`;
        }
    });
}

// Live search
document.getElementById('searchInput').addEventListener('keyup', function(){
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
    });
});
</script>
