<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Sign Up</title>
</head>

<body class="bg-gray-100 text-gray-900 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <form action="../../authHandler.php?action=signup" method="POST">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Create an Account</h2>
            <p class="text-center text-gray-600 mb-4">Sign up to get started</p>

            <!-- Display Messages -->
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                    <p><?= htmlspecialchars($_SESSION['error']); ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p><?= htmlspecialchars($_SESSION['success']); ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Username Field -->
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="username" id="username" required minlength="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 shadow-md transition transform hover:scale-105">
                Sign Up
            </button>

            <!-- Link to Login Page -->
            <p class="text-center text-gray-600 mt-4">Already have an account? <a href="login.php"
                    class="text-blue-500 font-medium hover:underline">Log in</a></p>
        </form>
    </div>
</body>

</html>