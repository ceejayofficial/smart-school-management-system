<?php

// Determine the active page
$current_page = $_GET['page'] ?? 'home';
?>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-papxQ+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<aside class="w-64 bg-blue-900 text-white flex-shrink-0 fixed h-full hidden md:flex flex-col">
  <div class="p-6 text-center border-b border-blue-800">
    <i class="fas fa-user-graduate text-white text-5xl"></i>
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>


   <nav class="mt-6 flex flex-col space-y-1">
    <a href="admin_dashboard.php?page=home" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'home' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
    </a>
    <a href="admin_dashboard.php?page=students" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'students' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-user-graduate mr-3"></i> Students
    </a>
    <a href="admin_dashboard.php?page=teachers" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'teachers' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-chalkboard-teacher mr-3"></i> Teachers
    </a>
    <a href="admin_dashboard.php?page=classes" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'classes' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-school mr-3"></i> Classes
    </a>
    <a href="admin_dashboard.php?page=exams" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'exams' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-file-alt mr-3"></i> Exams & Results
    </a>
    <a href="admin_dashboard.php?page=fees" class="flex items-center py-3 px-6 transition hover:bg-blue-800 <?= $current_page === 'fees' ? 'bg-blue-700 font-semibold' : '' ?>">
        <i class="fas fa-dollar-sign mr-3"></i> Fees
    </a>

    <!-- Divider before logout -->
    <div class="border-t border-blue-800 my-6"></div>

    <!-- Logout -->
    <button id="logoutBtn" class="flex items-center justify-center py-3 px-6 mt-2 bg-red-700 hover:bg-red-800 rounded transition">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </button>
</nav>

</aside>

<?php include "preloader.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const logoutBtn = document.getElementById('logoutBtn');

    logoutBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../logout.php";
            }
        });
    });
</script>
