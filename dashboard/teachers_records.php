<?php
require_once "../db.php";
require_once "./includes/auth.php";

// Pagination settings
$limit = 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$offset = ($page - 1) * $limit;

// Total teachers
$totalResult = $conn->query("SELECT COUNT(*) as total FROM teachers");
$totalTeachers = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalTeachers / $limit);

// Fetch teachers for current page
$result = $conn->query("SELECT * FROM teachers ORDER BY teacher_id DESC LIMIT $limit OFFSET $offset");
?>

<div class="p-8 h-screen bg-white ml-0 md:ml-64 overflow-auto">

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Search teachers..." 
               class="w-full md:w-2/2 p-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <?php if (!$result || $result->num_rows === 0): ?>
        <p class="text-gray-500 text-center py-6">No teachers found.</p>
    <?php else: ?>
        <div class="overflow-auto border shadow-sm rounded-lg">
            <table id="teachersTable" class="min-w-full text-sm border-collapse">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="text-left text-gray-600">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Full Name</th>
                        <th class="p-3 border">Gender</th>
                        <th class="p-3 border">Phone</th>
                        <th class="p-3 border">Qualification</th>
                        <th class="p-3 border">Level</th>
                        <th class="p-3 border">Class</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $count = $offset + 1; ?>
                    <?php while($teacher = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 border"><?= $count++ ?></td>
                            <td class="p-3 border font-medium"><?= htmlspecialchars($teacher['teacher_name']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($teacher['gender']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($teacher['phone']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($teacher['qualification']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($teacher['level']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($teacher['class_assigned']) ?></td>
                            <td class="p-3 border">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <button onclick="viewTeacher('<?= $teacher['teacher_id'] ?>')" 
                                        class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition">
                                        View
                                    </button>
                                    <button onclick="editTeacher('<?= $teacher['teacher_id'] ?>')" 
                                        class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600 transition">
                                        Edit
                                    </button>
                                    <button onclick="deleteTeacher('<?= $teacher['teacher_id'] ?>')" 
                                        class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center space-x-2">
            <?php for ($i=1; $i <= $totalPages; $i++): ?>
                <a href="/dashboard/admin_dashboard.php?process=teachers-records&page_num=<?= $i ?>" 
                   class="px-3 py-1 border rounded-lg <?= $i==$page?'bg-blue-500 text-white':'bg-white text-gray-700 hover:bg-gray-200' ?>">
                   <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Teacher Modals -->
<div id="teacherModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow max-w-4xl w-full relative overflow-auto max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 text-xl font-bold">&times;</button>
        <div id="teacherDetails"></div>
    </div>
</div>

<div id="editTeacherModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow max-w-4xl w-full relative overflow-auto max-h-[90vh]">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-600 text-xl font-bold">&times;</button>
        <div id="editTeacherContent"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function viewTeacher(id){
    fetch(`process/view_teacher.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('teacherDetails').innerHTML = html;
            document.getElementById('teacherModal').classList.remove('hidden');
        });
}
function closeModal(){ document.getElementById('teacherModal').classList.add('hidden'); }

function editTeacher(id){
    fetch(`process/edit_teacher_form.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editTeacherContent').innerHTML = html;
            document.getElementById('editTeacherModal').classList.remove('hidden');
        });
}
function closeEditModal(){ document.getElementById('editTeacherModal').classList.add('hidden'); }

function deleteTeacher(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the teacher!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = `process/delete_teacher_process.php?id=${id}`;
        }
    });
}

// Live search
document.getElementById('searchInput').addEventListener('keyup', function(){
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('#teachersTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
    });
});
</script>
