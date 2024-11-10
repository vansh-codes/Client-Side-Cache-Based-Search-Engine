<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Note - Enhanced Note-Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white shadow-lg rounded-lg p-6 space-y-8">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Enhanced Note-Taking</h1>

        <!-- File Type Selection -->
        <div class="space-y-4">
            <label for="fileType" class="block text-gray-700 font-semibold">Select File Type:</label>
            <select id="fileType" class="w-full p-2 border rounded">
                <option value="txt">Text (.txt)</option>
                <option value="html">HTML (.html)</option>
                <option value="md">Markdown (.md)</option>
            </select>
        </div>

        <!-- Note Title -->
        <input type="text" id="noteTitle" placeholder="Note Title" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">

        <!-- Note Content -->
        <textarea id="noteContent" placeholder="Write your note here..." class="w-full h-36 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>

        <!-- Save Button -->
        <button id="saveButton" class="w-full bg-green-600 text-white py-2 rounded-md font-semibold hover:bg-green-700">Save Note</button>
    </div>

    <script src="app.js?v=1.0.0"></script>
</body>

</html>