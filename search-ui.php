<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Enhanced Note-Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-6 space-y-8">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Search Content</h1>

        <!-- Search Form -->
        <form action="results.php" method="get" class="space-y-4">
            <input type="text" name="query" placeholder="Search content..." class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700">Search</button>
        </form>
    </div>
</body>

</html>