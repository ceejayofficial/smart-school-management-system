

<div class="p-8 h-screen bg-white  ml-0 md:ml-64">
    <!-- Fees Management Grid: 2 per row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Collect Fees -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-hand-holding-dollar text-4xl text-blue-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Collect Fees</h3>
            <p class="text-sm text-gray-500 mt-1">Record payments made by students.</p>
            <a href="collect_fees.php" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-plus mr-1"></i> Collect Fees
            </a>
        </div>

        <!-- View All Payments -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-wallet text-4xl text-green-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">View Payments</h3>
            <p class="text-sm text-gray-500 mt-1">See all student fee payments with full details.</p>
            <a href="fees_list.php" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Payments
            </a>
        </div>

        <!-- Fee Reports -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-file-invoice-dollar text-4xl text-yellow-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Fee Reports</h3>
            <p class="text-sm text-gray-500 mt-1">Generate reports for all collected fees.</p>
            <a href="fee_reports.php" class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-chart-line mr-1"></i> View Reports
            </a>
        </div>

        <!-- Pending Fees -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-clock text-4xl text-red-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Pending Fees</h3>
            <p class="text-sm text-gray-500 mt-1">Check unpaid or overdue fees for students.</p>
            <a href="pending_fees.php" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-exclamation-circle mr-1"></i> View Pending
            </a>
        </div>

        <!-- Active Students Fees -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
            <i class="fas fa-user-check text-4xl text-indigo-500 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-600">Active Student Fees</h3>
            <p class="text-sm text-gray-500 mt-1">View fees for students currently active in the system.</p>
            <a href="active_student_fees.php" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded transition">
                <i class="fas fa-eye mr-1"></i> View Active
            </a>
        </div>

    </div>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
