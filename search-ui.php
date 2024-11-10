<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Enhanced Note-Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-pink-400 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white shadow-2xl rounded-lg p-8 space-y-8 transition transform hover:scale-105">
        <h1 class="text-3xl font-bold text-gray-800 text-center">Search Content</h1>

        <form action="results.php" method="get" class="space-y-4">
            <input type="text" name="query" placeholder="Search content..." class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
            <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 hover:shadow-md transition ease-in-out duration-300">Search 🔍</button>
        </form>
    </div>
</body>

</html>