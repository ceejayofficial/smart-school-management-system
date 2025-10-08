<?php
// Determine the active page
$current_page = $_GET['page'] ?? 'home';
?>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<aside class="w-64 bg-blue-900 text-white flex-shrink-0 fixed h-full hidden md:flex flex-col">
  <!-- Logo -->
  <div class="p-6 text-center border-b border-blue-800">
    <i class="fas fa-user-graduate text-white text-5xl mb-2"></i>
    <h1 class="text-white text-lg font-semibold">School Admin</h1>
  </div>

  <!-- Navigation -->
  <nav class="mt-6 flex flex-col space-y-1">
    <?php
    $menuItems = [
        'home' => ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard'],
        'students' => ['icon' => 'fas fa-user-graduate', 'label' => 'Students'],
        'teachers' => ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Teachers'],
        'classes' => ['icon' => 'fas fa-school', 'label' => 'Classes'],
        'exams' => ['icon' => 'fas fa-file-alt', 'label' => 'Exams'],
        'results' => ['icon' => 'fas fa-chart-line', 'label' => 'Results'],
        'fees' => ['icon' => 'fas fa-dollar-sign', 'label' => 'Fees'],
    ];

    foreach ($menuItems as $page => $item) {
        $active = $current_page === $page ? 'bg-blue-700 font-semibold' : '';
        echo '<a href="admin_dashboard.php?page='.$page.'" class="flex items-center py-3 px-6 transition hover:bg-blue-800 '.$active.'">
                <i class="'.$item['icon'].' mr-3 w-5 text-center"></i>
                <span class="truncate">'.$item['label'].'</span>
              </a>';
    }
    ?>
    
    <!-- Divider -->
    <div class="border-t border-blue-800 my-6"></div>

    <!-- Logout -->
    <button id="logoutBtn" class="flex items-center py-3 px-6 mt-2 bg-red-700 hover:bg-red-800 rounded transition w-full">
        <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
        <span>Logout</span>
    </button>
  </nav>
</aside>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>

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

<style>
/* Ensure icons and text align perfectly */
nav a, #logoutBtn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
nav a i, #logoutBtn i {
    min-width: 1.25rem; /* same width for all icons */
    text-align: center;
}
nav a span, #logoutBtn span {
    white-space: nowrap;
}
</style>
