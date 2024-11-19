<?php
require 'session_manager.php';

// Helper function to fetch directories and files
function getDirectories($baseDir = __DIR__)
{
    return array_filter(glob("$baseDir/*"), function ($path) {
        return is_dir($path) && !in_array(basename($path), ['assets', 'templates', 'parsedown-master', 'dfd']);
    });
}

function sortItems($items, $sortType)
{
    switch ($sortType) {
        case 'a-z':
            usort($items, fn($a, $b) => strcasecmp(basename($a), basename($b)));
            break;
        case 'z-a':
            usort($items, fn($a, $b) => strcasecmp(basename($b), basename($a)));
            break;
        case 'created-first':
            usort($items, fn($a, $b) => filemtime($a) <=> filemtime($b));
            break;
        case 'created-recently':
            usort($items, fn($a, $b) => filemtime($b) <=> filemtime($a));
            break;
    }
    return $items;
}

// Fetch directories and files dynamically
$sortType = $_GET['sort'] ?? 'a-z'; // Default sorting is A-Z
$currentDirectory = isset($_GET['directory']) ? realpath($_GET['directory']) : null;

// Determine context (file view or directory view)
if ($currentDirectory && strpos($currentDirectory, __DIR__) === 0) {    // file view
    $files = glob("$currentDirectory/*");
    $files = sortItems($files, $sortType);
} else {    // dir view
    $files = [];
    $currentDirectory = null;
}

$directories = getDirectories();
$directories = sortItems($directories, $sortType);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Manage Notes</title>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include 'templates/header.php'; ?>

    <main class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-8">Manage Notes</h1>

        <!-- Sorting Dropdown -->
        <div class="flex justify-end mb-4 space-x-4">
            <form action="" method="GET" class="flex items-center">
                <?php if ($currentDirectory): ?>
                    <input type="hidden" name="directory" value="<?= urlencode($currentDirectory) ?>" />
                <?php endif; ?>
                <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                    <option value="a-z" <?= $sortType === 'a-z' ? 'selected' : '' ?>>A-Z</option>
                    <option value="z-a" <?= $sortType === 'z-a' ? 'selected' : '' ?>>Z-A</option>
                    <option value="created-first" <?= $sortType === 'created-first' ? 'selected' : '' ?>>Created First</option>
                    <option value="created-recently" <?= $sortType === 'created-recently' ? 'selected' : '' ?>>Created Recently</option>
                </select>
            </form>
            <form action="add_directory.php" method="POST" class="flex items-center gap-2">
                <input type="text" name="directoryName" placeholder="New Directory Name"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" required />
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Create Directory
                </button>
            </form>
        </div>

        <?php if (!$currentDirectory) : ?>
            <!-- Directory View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($directories as $directory) :
                    $dirName = basename($directory);
                ?>
                    <div class="bg-white shadow-lg rounded-lg p-4 hover:shadow-2xl transition">
                        <a href="?directory=<?= urlencode($directory) ?>&sort=<?= urlencode($sortType) ?>" class="block text-center">
                            <div class="text-gray-600 text-4xl mb-2">📁</div>
                            <span class="text-lg font-medium"><?= htmlspecialchars($dirName) ?></span>
                        </a>
                        <form action="delete_directory.php" method="POST" class="mt-4"
                            onsubmit="return confirm(`Are you sure you want to delete this directory: '<?= htmlspecialchars($dirName) ?>'?`);">
                            <input type="hidden" name="directory" value="<?= htmlspecialchars($directory) ?>" />
                            <button type="submit"
                                class="block w-full text-center text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <!-- File View -->
            <div>
                <button onclick="window.history.back()"
                    class="mb-6 px-4 py-2 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300">
                    ← Back to Directories
                </button>
                <h2 class="text-xl font-bold mb-4"><?= htmlspecialchars(basename($currentDirectory)) ?> Files</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php if (!empty($files)) : ?>
                        <?php foreach ($files as $file) :
                            $fileName = basename($file);
                        ?>
                            <div class="bg-white shadow-lg rounded-lg p-4 hover:shadow-2xl transition">
                                <a href="view_file.php?file=<?= urlencode($file) ?>" class="block text-center">
                                    <div class="text-gray-600 text-4xl mb-2">📄</div>
                                    <span class="text-lg font-medium"><?= htmlspecialchars($fileName) ?></span>
                                </a>
                                <form action="delete_file.php" method="POST" class="mt-4"
                                    onsubmit="return confirm(`Are you sure you want to delete this file: '<?= htmlspecialchars($fileName) ?>'?`);">
                                    <input type="hidden" name="file" value="<?= htmlspecialchars($file) ?>" />
                                    <button type="submit"
                                        class="block w-full text-center text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-500 italic">No files found.</p>
                    <?php endif; ?>
                </div>
                <a href="add_note.php?directory=<?= urlencode(basename($currentDirectory)) ?>"
                    class="mt-6 block text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Add New File
                </a>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>

</html>