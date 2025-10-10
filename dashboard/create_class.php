<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="min-h-screen bg-white ml-0 md:ml-64">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">New Class</h2>

        <?php
        // SweetAlert feedback
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Class created successfully.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }

        if (isset($_GET['error'])) {
            $errorMsg = htmlspecialchars($_GET['error']);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: '{$errorMsg}',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
        ?>

        <form method="POST" action="admin_dashboard.php?process=create_class_process" class="space-y-6" id="classForm">

            <!-- Level Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <select name="level" id="level" required class="input-field">
                    <option value="">Select Level</option>
                    <option value="Creche">Creche</option>
                    <option value="Nursery">Nursery</option>
                    <option value="Primary">Primary</option>
                    <option value="JHS">JHS</option>
                    <option value="SHS">SHS</option>
                </select>

                <!-- Class dropdown -->
                <select name="class_name" id="class_name" required class="input-field">
                    <option value="">Select Class</option>
                </select>
            </div>

            <!-- Optional: Enter New Class -->
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="new_class" placeholder="Or Enter New Class Name (optional)" class="input-field">
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end mt-6 space-x-3">
                <a href="admin_dashboard.php?page=classes" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Create Class
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const classOptions = {
    "Creche": ["Creche 1", "Creche 2"],
    "Nursery": ["KG 1", "KG 2"],
    "Primary": ["Primary 1", "Primary 2", "Primary 3", "Primary 4", "Primary 5", "Primary 6"],
    "JHS": ["JHS 1", "JHS 2", "JHS 3"],
    "SHS": ["SHS 1", "SHS 2", "SHS 3"]
};

document.getElementById('level').addEventListener('change', function() {
    const level = this.value;
    const classDropdown = document.getElementById('class_name');

    classDropdown.innerHTML = '<option value="">Select Class</option>';

    if (classOptions[level]) {
        classOptions[level].forEach(cls => {
            classDropdown.innerHTML += `<option value="${cls}">${cls}</option>`;
        });
    }
});
</script>
