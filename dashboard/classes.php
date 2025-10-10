

<div class=" h-screen bg-white  ml-0 md:ml-64">
    <!-- Classes Actions Grid: 2 per row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Create Class -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-plus-circle text-4xl text-blue-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Create Class</h3>
            <p class="text-sm text-gray-500 mt-1">Add a new class to the school system.</p>
            <a href="admin_dashboard.php?page=create_class"
            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-plus mr-1"></i> Add Class
            </a>
        </div>

        <!-- View Classes -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-chalkboard text-4xl text-green-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">View Classes</h3>
            <p class="text-sm text-gray-500 mt-1">See all school classes with full details.</p>
                        <a href="admin_dashboard.php?page=class_records"

            class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Classes
            </a>
        </div>

  

        <!-- Assign Teachers -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-tie text-4xl text-purple-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Assign Teachers</h3>
            <p class="text-sm text-gray-500 mt-1">Assign teachers to classes and subjects.</p>
            <a href="assign_teachers.php" class="mt-4 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-user-edit mr-1"></i> Assign
            </a>
        </div>

        <!-- Active Classes -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-check-circle text-4xl text-indigo-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Active Classes</h3>
            <p class="text-sm text-gray-500 mt-1">View currently active classes in the system.</p>
            <a href="active_classes.php" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Active
            </a>
        </div>

    </div>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
