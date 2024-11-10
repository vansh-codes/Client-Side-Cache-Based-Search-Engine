<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Note - Enhanced Note-Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-400 to-blue-500 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white shadow-2xl rounded-lg p-8 space-y-8 transition transform hover:scale-105">
        <h1 class="text-3xl font-bold text-gray-800 text-center">Enhanced Note-Taking</h1>

        <div class="space-y-4">
            <label for="fileType" class="block text-gray-700 font-semibold">Select File Type:</label>
            <select id="fileType" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="txt">Text (.txt)</option>
                <option value="html">HTML (.html)</option>
                <option value="md">Markdown (.md)</option>
            </select>
        </div>

        <input type="text" id="noteTitle" placeholder="Note Title" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <textarea id="noteContent" placeholder="Write your note here..." class="w-full h-40 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

        <button id="saveButton" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 hover:shadow-md transition ease-in-out duration-300">Save Note</button>
    </div>

    <script src="app.js?v=1.0.0"></script>
</body>

</html>
