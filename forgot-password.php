<?php
include "forgot_password_process.php"; // Include the logic
include "includes/header.php"; // Tailwind header
?>

<div class="relative min-h-screen flex items-center justify-center px-4 bg-gray-100">

    <!-- Optional background image -->
    <div class="absolute inset-0">
        <img 
            src="assets/img/school-bg.jpg" 
            alt="School Background" 
            class="w-full h-full object-cover filter blur-sm brightness-75"
        />
    </div>

    <!-- Forgot Password Card -->
    <div class="relative bg-white shadow-lg rounded-lg w-full max-w-md p-8 z-10">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Forgot Password</h2>
        <p class="text-center text-gray-500 mb-6">
            Enter your email and unique code to verify your account
        </p>

        <form method="POST" class="space-y-5">
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <div>
                <label for="unique_code" class="block text-gray-700 font-medium mb-2">Unique Code</label>
                <input
                    type="text"
                    name="unique_code"
                    placeholder="Enter your unique code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors font-semibold"
            >
                Verify
            </button>

            <div class="text-right">
                <a href="login.php" class="text-sm text-blue-600 hover:underline">Back to login</a>
            </div>
        </form>

        <!-- SweetAlert Error -->
        <?php if (!empty($error)) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    text: <?= json_encode($error) ?>
                });
            </script>
        <?php endif; ?>
    </div>
</div>

