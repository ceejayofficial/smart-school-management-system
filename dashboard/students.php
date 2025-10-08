
<div class="p-8 h-screen bg-white ml-0 md:ml-64">
    <!-- Students Actions Grid: 2 per row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Create Student -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-plus text-4xl text-blue-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Create Student</h3>
            <p class="text-sm text-gray-500 mt-1">Add a new student account to the system.</p>
            <a href="admin_dashboard.php?page=create_student"
   class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
   <i class="fas fa-plus mr-1"></i> Add Student
</a>

        </div>

        <!-- View Students -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-users text-4xl text-green-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">View Students</h3>
            <p class="text-sm text-gray-500 mt-1">See all registered students with full details.</p>
             <a href="admin_dashboard.php?page=students-records" 
            class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Students
            </a>
        </div>

        <!-- Student Results -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-file-alt text-4xl text-yellow-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Student Results</h3>
            <p class="text-sm text-gray-500 mt-1">Check or upload results for students.</p>
            <a href="student_results.php" class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-chart-line mr-1"></i> View Results
            </a>
        </div>

        <!-- Attendance -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-calendar-check text-4xl text-purple-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Attendance</h3>
            <p class="text-sm text-gray-500 mt-1">Track student attendance records.</p>
            <a href="attendance.php" class="mt-4 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-clipboard-list mr-1"></i> View Attendance
            </a>
        </div>

        <!-- Fees -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-dollar-sign text-4xl text-red-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Student Fees</h3>
            <p class="text-sm text-gray-500 mt-1">Manage and view student fee payments.</p>
            <a href="student_fees.php" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-wallet mr-1"></i> Manage Fees
            </a>
        </div>

        <!-- Active Students -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-check text-4xl text-indigo-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Active Students</h3>
            <p class="text-sm text-gray-500 mt-1">See currently active students in the system.</p>
            <a href="active_students.php" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Active
            </a>
        </div>

    </div>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
