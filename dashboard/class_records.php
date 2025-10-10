<?php
require_once "../db.php";

// Fetch all class records
$result = $conn->query("SELECT * FROM classes ORDER BY level, class_name");
?>

<div class="min-h-screen bg-white ml-0 md:ml-64 ">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">Classes Records</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Class Name</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $count = 1;
                        while($row = $result->fetch_assoc()): 
                        ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $count++; ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['level']); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['class_name']); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Edit Button -->
                                        <button 
                                            onclick="window.location.href='edit_class.php?id=<?= $row['class_id'] ?>'"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 transition">
                                            Edit
                                        </button>

                                        <!-- Delete Button with Swal -->
                                        <form action="delete_class.php?id=<?= $row['class_id'] ?>" method="POST" onsubmit="return confirmDelete(this);">
                                            <button type="submit" 
                                                class="px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-4 text-center text-gray-500">No classes found.</div>
        <?php endif; ?>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(form) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "This class will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    return false;
}
</script>
