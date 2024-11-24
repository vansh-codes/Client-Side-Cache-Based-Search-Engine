<?php
require 'session_manager.php';

// Fetch available directories
function getDirectories($baseDir = __DIR__)
{
    return array_filter(glob("$baseDir/*"), function ($path) {
        return is_dir($path) && !in_array(basename($path), ['assets', 'templates', 'dfd', 'parsedown-master']);
    });
}

$directories = getDirectories();
$directoryNames = array_map('basename', $directories);

// Get the selected directory from the query parameter
$selectedDirectory = isset($_GET['directory']) ? $_GET['directory'] : null;

// Validate the selected directory
if ($selectedDirectory && in_array($selectedDirectory, $directoryNames)) {
    $selectedDirectory = realpath(__DIR__ . '/' . $selectedDirectory);
} else {
    $selectedDirectory = null; // Reset to default if invalid or not provided
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Add Note</title>
</head>

<body class="bg-gray-100">
    <?php include 'templates/header.php'; ?>
    <main class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-xl mx-auto">
            <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-6">Add a New Note</h1>
            <p class="text-center text-gray-600 mb-8">
                Create a new note by providing a title and content to capture your thoughts, tasks, or ideas.
            </p>
            <form id="addNoteForm" method="POST" action="add_note_handler.php" class="space-y-6">
                <!-- Directory Dropdown -->
                <div>
                    <label for="directory" class="block text-gray-700 font-medium mb-2">Select Directory</label>
                    <select
                        name="directory"
                        id="directory"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        required>
                        <option value="">-- Select a directory --</option>
                        <?php foreach ($directories as $directory): ?>
                            <option value="<?= htmlspecialchars(basename($directory)) ?>"
                                <?= realpath($directory) === $selectedDirectory ? 'selected' : '' ?>>
                                <?= htmlspecialchars(basename($directory)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Note Title -->
                <div>
                    <label for="noteTitle" class="block text-gray-700 font-medium mb-2">Note Title</label>
                    <input
                        type="text"
                        name="noteTitle"
                        id="noteTitle"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="Enter note title..."
                        required />
                </div>
                <!-- File Type Dropdown -->
                <div>
                    <label for="fileType" class="block text-gray-700 font-medium mb-2">Select File Type</label>
                    <select
                        name="fileType"
                        id="fileType"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        required>
                        <option value="txt">Text (.txt)</option>
                        <option value="html">HTML (.html)</option>
                        <option value="md">Markdown (.md)</option>
                    </select>
                </div>
                <!-- Note Content -->
                <div>
                    <label for="noteContent" class="block text-gray-700 font-medium mb-2">Note Content</label>
                    <textarea
                        name="noteContent"
                        id="noteContent"
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="Write your note here..."
                        required></textarea>
                </div>
                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all">
                    Save Note
                </button>
            </form>
        </div>
    </main>
    <?php include 'templates/footer.php'; ?>

    <script>
        const form = document.getElementById('addNoteForm');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });
                const result = await response.json();

                if (result.success) {
                    alert('Note saved successfully!');
                    form.reset(); // Optionally reset the form
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Failed to save the note. Please try again.');
            }
        });
    </script>
</body>

</html>