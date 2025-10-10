

<div class=" h-screen bg-white  ml-0 md:ml-64">
    <!-- Exams & Results Actions Grid: 2 per row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Create Exam -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-file-circle-plus text-4xl text-blue-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Create Exam</h3>
            <p class="text-sm text-gray-500 mt-1">Schedule a new exam for students.</p>
            <a href="create_exam.php" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-plus mr-1"></i> Add Exam
            </a>
        </div>

        <!-- View Exams -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-calendar-alt text-4xl text-green-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">View Exams</h3>
            <p class="text-sm text-gray-500 mt-1">See all scheduled exams with full details.</p>
            <a href="exams_list.php" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Exams
            </a>
        </div>

        <!-- Manage Results -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-file-alt text-4xl text-yellow-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Manage Results</h3>
            <p class="text-sm text-gray-500 mt-1">Upload, edit, or view student exam results.</p>
            <a href="manage_results.php" class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-upload mr-1"></i> Manage Results
            </a>
        </div>

        <!-- Exam Fees -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-dollar-sign text-4xl text-red-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Exam Fees</h3>
            <p class="text-sm text-gray-500 mt-1">Collect and track payments related to exams.</p>
            <a href="exam_fees.php" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-wallet mr-1"></i> Manage Fees
            </a>
        </div>

        <!-- Active Exams -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-check-circle text-4xl text-indigo-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Active Exams</h3>
            <p class="text-sm text-gray-500 mt-1">View currently ongoing exams.</p>
            <a href="active_exams.php" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Active
            </a>
        </div>

    </div>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
