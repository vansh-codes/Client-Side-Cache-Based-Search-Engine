if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('./service-worker.js')
            .then((registration) => {
                console.log('Service Worker registered with scope: ', registration.scope);
            })
            .catch((error) => {
                console.log('Service Worker registration failed: ', error);
            });
    });
}

/* document.getElementById("searchForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const query = document.getElementById("searchInput").value.trim();
    const resultsContainer = document.getElementById("results");
    const timeDisplay = document.getElementById("searchTime");
    resultsContainer.innerHTML = "";
    timeDisplay.textContent = "";

    if (!query) {
        resultsContainer.innerHTML =
            '<p class="text-gray-600">Please enter a search term.</p>';
        return;
    }

    const startTime = performance.now();

    try {
        const response = await fetch(`search.php?query=${encodeURIComponent(query)}`);
        const data = await response.json();

        if (data.error) {
            resultsContainer.innerHTML =
                `<p class="text-red-500">${data.error}</p>`;
            return;
        }

        const { source, results } = data;
        displayResults(results, resultsContainer, query);

        const endTime = performance.now();
        timeDisplay.textContent = `${source === 'cache' ? 'Retrieved from cache' : 'Search completed'} in ${(endTime - startTime).toFixed(2)} ms.`;
    } catch (error) {
        resultsContainer.innerHTML =
            '<p class="text-red-500">Error fetching results.</p>';
    }
});

// Function to display results with highlighted query
function displayResults(results, container, query) {
    if (results.length === 0) {
        container.innerHTML = '<p class="text-gray-600">No results found.</p>';
        return;
    }

    results.forEach((result) => {
        const item = document.createElement("div");
        item.classList.add("p-4", "bg-white", "rounded", "shadow-md", "mb-4");

        // Highlight the query in the snippet
        const highlightedSnippet = highlightQuery(result.snippet, query);

        item.innerHTML = `
            <h3 class="font-bold">${result.file}</h3>
            <p>${highlightedSnippet}</p>
            <a href="${result.path}" class="text-blue-500 hover:underline">View More</a>
        `;
        container.appendChild(item);
    });
} */