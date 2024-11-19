<?php
require 'session_manager.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="assets/js/main.js" type="module"></script>
    <title>Home</title>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <?php include 'templates/header.php'; ?>
    <main class="container mx-auto p-6 lg:p-12">
        <h1 class="text-4xl font-extrabold text-center text-black mb-8">Search and Manage Notes</h1>
        <div class="flex flex-col items-center gap-8">
            <!-- Search Form -->
            <form id="searchForm" class="w-full max-w-4xl flex items-center justify-between space-x-4">
                <input type="text" id="searchInput" class="w-full px-6 py-3 text-lg border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                    placeholder="Search content..." />
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105">
                    <span>Search</span>
                </button>
            </form>
            <!-- Add Note Button -->
            <a href="add_note.php" class="px-8 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition transform hover:scale-105">
                Add Note
            </a>
        </div>
        <!-- Search Time Display -->
        <p id="searchTime" class="text-black text-center mt-4 mb-8"></p>
        <!-- Results Section -->
        <div id="results" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"></div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="assets/js/searchHandler.js" type="module"></script>
</body>

</html>