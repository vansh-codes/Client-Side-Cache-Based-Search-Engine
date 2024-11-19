<?php
require 'session_manager.php';
require 'parsedown-master/Parsedown.php';

if (!isset($_GET['file'])) {
    die("File not specified.");
}

$filePath = realpath($_GET['file']);
if (!$filePath || strpos($filePath, __DIR__) !== 0 || !is_file($filePath)) {
    die("Invalid file.");
}

// Get file contents
$fileContent = file_get_contents($filePath);
$fileName = basename($filePath);

// Detect file type
$isHtmlFile = pathinfo($filePath, PATHINFO_EXTENSION) === 'html';

$isMarkdown = pathinfo($filePath, PATHINFO_EXTENSION) === 'md';
$parsedMarkdown = null;

if ($isMarkdown) {
    $parsedown = new Parsedown();
    $parsedMarkdown = $parsedown->text($fileContent);
}
/* if ($isHtmlFile) {
    $fileContent = strip_tags($fileContent, '<p><a><h1><h2><h3><ul><ol><li><img><div><span><strong><em><br><hr>');
} */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>View File - <?= htmlspecialchars($fileName) ?></title>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include 'templates/header.php'; ?>

    <main class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <!-- Back Button -->
            <button onclick="window.history.back()"
                class="px-4 py-2 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300 transition-all">
                ← Back
            </button>

            <!-- Copy Button -->
            <button id="copyButton"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                Copy Content
            </button>
        </div>

        <h1 class="text-3xl font-bold text-center mb-8"><?= htmlspecialchars($fileName) ?></h1>

        <!-- Search Bar -->
        <div class="flex justify-center mb-4">
            <div class="relative w-1/2">
                <input type="text" id="searchInput" placeholder="Search..." class="px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <button id="clearButton" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    &#x2715;
                </button>
            </div>
            <button id="searchButton" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                Search
            </button>
        </div>

        <?php if ($isHtmlFile): ?>
            <!-- Tab Buttons -->
            <div class="flex justify-center mb-4 space-x-4">
                <button id="htmlTab" class="px-4 py-2 font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-blue-500 hover:text-white focus:bg-blue-600 focus:text-white active:bg-blue-700 transition-all">
                    HTML
                </button>
                <button id="textTab" class="bg-blue-600 text-white px-4 py-2 font-medium bg-gray-200 rounded-lg hover:bg-blue-500 hover:text-white focus:bg-blue-600 focus:text-white active:bg-blue-700 transition-all">
                    Text
                </button>
            </div>

            <!-- HTML View -->
            <div id="htmlView" class="hidden">
                <div class="bg-white shadow-lg rounded-lg p-6 overflow-auto">
                    <?php echo $fileContent ?>
                </div>
            </div>

            <!-- Text View -->
            <div id="textView" class="block">
                <div class="bg-white shadow-lg rounded-lg p-6 overflow-auto">
                    <pre class="whitespace-pre-wrap text-gray-800"><?= htmlspecialchars($fileContent) ?></pre>
                </div>
            </div>
        <?php elseif ($isMarkdown): ?>
            <!-- Markdown and Text Views -->
            <div class="flex justify-center mb-6 space-x-4">
                <button id="viewMarkdown" class="px-4 py-2 font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-blue-500 hover:text-white focus:bg-blue-600 focus:text-white active:bg-blue-700 transition-all">
                    Markdown
                </button>
                <button id="viewText" class="bg-blue-600 text-white px-4 py-2 font-medium bg-gray-200 rounded-lg hover:bg-blue-500 hover:text-white focus:bg-blue-600 focus:text-white active:bg-blue-700 transition-all">
                    Text
                </button>
            </div>
            <!-- Markdown View -->
            <div id="markdownView" class="bg-white shadow-lg rounded-lg p-6 overflow-auto hidden">
                <?php echo $parsedMarkdown; ?>
            </div>

            <!-- Text View (Initially hidden) -->
            <div id="textView" class="block bg-white shadow-lg rounded-lg p-6 overflow-auto">
                <pre class="whitespace-pre-wrap text-gray-800"><?= htmlspecialchars($fileContent) ?></pre>
            </div>
        <?php else: ?>
            <!-- Default View for Non-HTML Files -->
            <div class="bg-white shadow-lg rounded-lg p-6 overflow-auto">
                <pre id="fileContent" class="whitespace-pre-wrap text-gray-800"><?= htmlspecialchars($fileContent) ?></pre>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'templates/footer.php'; ?>

    <script>
        document.getElementById('copyButton').addEventListener('click', () => {
            let activeView = null;

            // Check for visible HTML or Text content
            const htmlView = document.getElementById('htmlView');
            const textView = document.getElementById('textView');
            const markdownView = document.getElementById('markdownView');
            const txtFileView = document.getElementById('fileContent');

            if (htmlView && htmlView.classList.contains('block')) {
                activeView = htmlView.innerHTML;
            } else if (markdownView && markdownView.classList.contains('block')) {
                activeView = markdownView.innerHTML;
            } else if (textView && textView.classList.contains('block')) {
                activeView = textView.querySelector('.whitespace-pre-wrap')?.textContent;
            } else if (txtFileView) {
                activeView = txtFileView.textContent;
            }

            if (activeView) {
                navigator.clipboard.writeText(activeView).then(() => {
                    alert('File content copied to clipboard!');
                }).catch((err) => {
                    console.error('Failed to copy content:', err);
                    alert('Failed to copy content.');
                });
            } else {
                alert('No content to copy.');
            }
        });

        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const clearButton = document.getElementById('clearButton');
        const fileContentElement = document.getElementById('fileContent') || document.getElementById('htmlView') || document.getElementById('markdownView') || document.getElementById('textView');

        // Search Button Event
        searchButton.addEventListener('click', () => {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                highlightSearchResults(searchTerm);
            }
        });

        // Clear Button Event
        clearButton.addEventListener('click', () => {
            searchInput.value = ''; // Clear input
            removeHighlights(); // Remove highlights
        });

        // Function to highlight search results
        function highlightSearchResults(searchTerm) {
            removeHighlights(); // Remove any existing highlights
            const regex = new RegExp(`(${searchTerm})`, 'gi'); // Case-insensitive search
            const content = fileContentElement.innerHTML;

            // Replace occurrences with highlighted HTML
            const highlightedContent = content.replace(regex, '<span class="bg-yellow-300">$1</span>');
            fileContentElement.innerHTML = highlightedContent;
        }

        // Function to remove all highlights
        function removeHighlights() {
            const content = fileContentElement.innerHTML;
            fileContentElement.innerHTML = content.replace(/<span class="bg-yellow-300">.*?<\/span>/g, (match) => match.replace(/<span.*?>|<\/span>/g, ''));
        }


        // Tab Switching Logic
        const htmlTab = document.getElementById('htmlTab');

        if (htmlTab) {
            const textTab = document.getElementById('textTab');
            const htmlView = document.getElementById('htmlView');
            const textView = document.getElementById('textView');
            htmlTab.addEventListener('click', () => {
                htmlTab.classList.add('bg-blue-600', 'text-white');
                htmlTab.classList.remove('bg-gray-200', 'text-gray-700');
                textTab.classList.add('bg-gray-200', 'text-gray-700');
                textTab.classList.remove('bg-blue-600', 'text-white');

                htmlView.classList.remove('hidden');
                htmlView.classList.add('block');
                textView.classList.remove('block');
                textView.classList.add('hidden');
            });

            textTab.addEventListener('click', () => {
                textTab.classList.add('bg-blue-600', 'text-white');
                textTab.classList.remove('bg-gray-200', 'text-gray-700');
                htmlTab.classList.add('bg-gray-200', 'text-gray-700');
                htmlTab.classList.remove('bg-blue-600', 'text-white');

                textView.classList.remove('hidden');
                textView.classList.add('block');
                htmlView.classList.remove('block');
                htmlView.classList.add('hidden');
            });
        }
        // Markdown View Logic
        const viewMarkdown = document.getElementById('viewMarkdown');

        if (viewMarkdown) {
            const viewText = document.getElementById('viewText');
            const markdownView = document.getElementById('markdownView');
            const textView = document.getElementById('textView');

            // Add event listeners for toggling views
            viewMarkdown.addEventListener('click', () => {
                /* markdownView.classList.remove('hidden');
                textView.classList.add('hidden'); */
                viewMarkdown.classList.add('bg-blue-600', 'text-white');
                viewMarkdown.classList.remove('bg-gray-200', 'text-gray-700');
                viewText.classList.add('bg-gray-200', 'text-gray-700');
                viewText.classList.remove('bg-blue-600', 'text-white');

                markdownView.classList.remove('hidden');
                markdownView.classList.add('block');
                textView.classList.remove('block');
                textView.classList.add('hidden');
            });

            viewText.addEventListener('click', () => {
                viewText.classList.add('bg-blue-600', 'text-white');
                viewText.classList.remove('bg-gray-200', 'text-gray-700');
                viewMarkdown.classList.add('bg-gray-200', 'text-gray-700');
                viewMarkdown.classList.remove('bg-blue-600', 'text-white');

                textView.classList.remove('hidden');
                textView.classList.add('block');
                markdownView.classList.remove('block');
                markdownView.classList.add('hidden');
            });
        }
    </script>
</body>

</html>