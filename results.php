<?php
require_once 'utils/file_indexer.php';

$startTime = microtime(true);
$query = $_GET['query'] ?? '';
$results = searchContent($query);
$endTime = microtime(true);
$elapsedTime = $endTime - $startTime;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-400 to-indigo-500 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-3xl w-full bg-white shadow-2xl rounded-lg p-8 space-y-6">
        <h1 class="text-3xl font-bold text-blue-700 text-center">
            Results for "<?php echo htmlspecialchars($query); ?>"
        </h1>

        <?php if (!empty($query) && strlen(trim($query)) > 0 && $results): ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($results as $result): ?>
                    <li class="flex items-start p-4 space-x-4 hover:bg-gray-50 rounded-lg">
                        <a href="<?php echo htmlspecialchars($result['path']); ?>" target="_blank" class="text-blue-500 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 115.656 5.656l-2.828 2.828a4 4 0 01-5.656-5.656l2.828-2.828zm-3.536 3.536l2.828-2.828" />
                            </svg>
                        </a>
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-700"><?php echo htmlspecialchars($result['file']); ?></h2>
                            <p class="text-gray-600 mt-1"><?php echo $result['snippet']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center text-gray-500 text-lg">No results found.</p>
        <?php endif; ?>

        <div class="text-center mt-4 text-gray-600 text-sm">
            Time taken: <?php echo number_format($elapsedTime, 4); ?> seconds
        </div>

        <div class="text-center">
            <a href="index.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium underline">Back to Search</a>
        </div>
    </div>
</body>

</html>