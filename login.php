<?php 
include "includes/header.php"; 
session_start();

// Capture error or success from login_process.php via session
$error = $_SESSION['login_error'] ?? '';
$success = $_SESSION['login_success'] ?? '';
$redirect = $_SESSION['login_redirect'] ?? '';

// Clear session messages so they don’t persist
unset($_SESSION['login_error'], $_SESSION['login_success'], $_SESSION['login_redirect']);
?>

<div class="relative min-h-screen flex items-center justify-center px-4 bg-gray-100">

    <!-- Background Image with Blur -->
    <div class="absolute inset-0">
        <img 
            src="assets/img/school-bg.jpg" 
            alt="School Background" 
            class="w-full h-full object-cover filter blur-sm brightness-75"
        />
    </div>

    <!-- Login Card -->
    <div class="relative bg-white shadow-lg rounded-lg w-full max-w-md p-8 z-10">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Welcome Back</h2>
        <p class="text-center text-gray-500 mb-6">
            Log in to access your Smart School System 
        </p>

        <form method="POST" action="login_process.php" class="space-y-5">
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Enter your email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors font-semibold"
            >
                Login
            </button>

            <div class="text-right">
                <a href="forgot-password.php" class="text-sm text-blue-600 hover:underline">
                    Forgot Password?
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (!empty($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: <?= json_encode($error) ?>
        });
    <?php endif; ?>

    <?php if (!empty($success) && !empty($redirect)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            text: <?= json_encode($success) ?>,
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = <?= json_encode($redirect) ?>;
        });
    <?php endif; ?>
</script>
