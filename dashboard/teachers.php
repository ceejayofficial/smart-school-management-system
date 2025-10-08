<?php
require_once "auth.php"; // Ensure admin is logged in
?>

<div class="p-8 h-screen bg-white overflow-auto ml-0 md:ml-64">
    <!-- Teachers Actions Grid: 2 per row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Create Teacher -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-plus text-4xl text-blue-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Create Teacher</h3>
            <p class="text-sm text-gray-500 mt-1">Add a new teacher account to the system.</p>
            <a href="create_teacher.php" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-plus mr-1"></i> Add Teacher
            </a>
        </div>

        <!-- View Teachers -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-chalkboard-teacher text-4xl text-green-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">View Teachers</h3>
            <p class="text-sm text-gray-500 mt-1">See all registered teachers with full details.</p>
            <a href="teachers_list.php" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Teachers
            </a>
        </div>

        <!-- Attendance -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-calendar-check text-4xl text-purple-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Attendance</h3>
            <p class="text-sm text-gray-500 mt-1">Track teacher attendance records.</p>
            <a href="teacher_attendance.php" class="mt-4 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-clipboard-list mr-1"></i> View Attendance
            </a>
        </div>

        <!-- Subjects -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-book-open text-4xl text-yellow-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Subjects</h3>
            <p class="text-sm text-gray-500 mt-1">Assign or manage subjects taught by teachers.</p>
            <a href="teacher_subjects.php" class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-book mr-1"></i> Manage Subjects
            </a>
        </div>

        <!-- Active Teachers -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-check text-4xl text-indigo-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Active Teachers</h3>
            <p class="text-sm text-gray-500 mt-1">See currently active teachers in the system.</p>
            <a href="active_teachers.php" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Active
            </a>
        </div>

    </div>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
