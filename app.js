// Register the service worker
if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("./service_worker.js")
        .then((reg) => console.log("Service Worker Registered", reg))
        .catch((err) =>
            console.error("Service Worker Registration Failed", err)
        );
}

// Add event listener for saving notes
document.addEventListener("DOMContentLoaded", function () {
    const fileTypeSelect = document.getElementById("fileType");
    const noteContent = document.getElementById("noteContent");

    // Save note function
    document
        .getElementById("saveButton")
        .addEventListener("click", async function () {
            const title = document.getElementById("noteTitle").value.trim();
            const content = noteContent.value.trim();
            const fileType = fileTypeSelect.value;

            if (!title || !content) {
                return alert("Title and content cannot be empty!");
            }

            const date = new Date();
            const formattedDate = date.toISOString().split("T")[0];
            const time = date.toTimeString().split(" ")[0];
            const fileName = `${title}_${formattedDate}.${fileType}`;

            try {
                const response = await fetch(`./save_note.php`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        title,
                        content,
                        fileType,
                        date: formattedDate,
                        time,
                        fileName,
                    }),
                });

                if (response.ok) {
                    alert("Note saved successfully!");
                    document.getElementById("noteTitle").value = "";
                    document.getElementById("noteContent").value = "";
                } else {
                    alert("Failed to save note.");
                }
            } catch (error) {
                console.error("Error saving note:", error);
                alert("An error occurred while saving the note.");
            }
        });
});
