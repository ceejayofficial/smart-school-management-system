<?php include "includes/header.php"; ?>

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
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Enter your username"
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

        <!-- Optional: SweetAlert error display -->
        <?php if (!empty($error)): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: <?= json_encode($error) ?>
                });
            </script>
        <?php endif; ?>
    </div>
</div>
