<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen text-gray-900">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <form action="../../authHandler.php?action=login" method="POST">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Welcome Back!</h2>
            <p class="text-center text-gray-600 mb-4">Login to your account</p>

            <!-- Display Error Messages -->
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                    <p><?= htmlspecialchars($_SESSION['error']); ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Display Success Messages -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p><?= htmlspecialchars($_SESSION['success']); ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="username" id="username" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition-shadow shadow-sm hover:shadow-md">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 shadow-md transition transform hover:scale-105">
                Login
            </button>

            <p class="text-center text-gray-600 mt-4">Don't have an account? <a href="signup.php"
                    class="text-blue-500 font-medium hover:underline">Sign up</a></p>
        </form>
    </div>
</body>

</html>