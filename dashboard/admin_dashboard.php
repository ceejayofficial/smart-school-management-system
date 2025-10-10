<?php
require_once "includes/auth.php"; // include this for all admin pages
?>

<?php include "includes/header.php"; ?>

<body class="flex bg-white min-h-screen">

    <!-- Sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Fixed Top Header -->
        <header class="fixed top-0 left-0 md:left-64 right-0 bg-white shadow z-30 p-4 flex justify-between items-center">
            <!-- Dashboard Title -->
            <span class="text-gray-700 font-semibold">Hi, <?= htmlspecialchars($username) ?></span>

            <!-- User Profile -->
            <div class="flex items-center space-x-3">
                <i class="fas fa-user-circle text-3xl text-gray-700"></i>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="p-8 mt-20 h-screen bg-white">

            <?php
            // Get query parameters
            $page = $_GET['page'] ?? 'home';
            $process = $_GET['process'] ?? '';

            // Allowed pages and processes
            $allowed_pages = ['home', 'students', 'class_records', 'teachers', 'classes', 'exams', 'fees', 'results', 'create_student', 'students-records', 'teachers_records', 'create_teacher', 'create_class'];
            $allowed_processes = ['create_class_process','edit_teacher_form','create_student_process', 'view_student', 'view_teacher', 'delete_student', 'delete_teacher', 'delete_teacher_process', 'delete_teacher_form.php', 'update_student', 'update_teacher', 'edit_student_form', 'students-records', 'create_teacher_process'];

            if ($process && in_array($process, $allowed_processes)) {
                include "process/$process.php"; // include the process file
            } elseif (in_array($page, $allowed_pages)) {
                include "$page.php"; // include normal page
            } else {
                echo "<p class='text-gray-600'>Page not found.</p>";
            }
            ?>

        </main>

    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>

</body>

</html>