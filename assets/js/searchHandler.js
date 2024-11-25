document.getElementById("searchForm").addEventListener("submit", async (e) => {
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

    // Check for cached results in sessionStorage
    let cachedResults = getCache(query);

    if (cachedResults) {
        displayResults(cachedResults, resultsContainer, query); // Pass the query to highlight
        const endTime = performance.now();
        timeDisplay.textContent = `Retrieved from cache in ${(
            endTime - startTime
        ).toFixed(2)} ms.`;
        return;
    }

    try {
        const response = await fetch(
            `search.php?query=${encodeURIComponent(query)}`
        );
        const results = await response.json();

        if (results.length > 0) {
            // Save the search results in cache for future queries
            setCache(query, results);
        }

        displayResults(results, resultsContainer, query); // Pass the query to highlight
    } catch (error) {
        resultsContainer.innerHTML =
            '<p class="text-red-500">Error fetching results.</p>';
    }

    const endTime = performance.now();
    timeDisplay.textContent = `Search completed in ${(
        endTime - startTime
    ).toFixed(2)} ms.`;
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
}

// Function to highlight the search query within the snippet
function highlightQuery(snippet, query) {
    // Create a regex pattern for the query, making it case-insensitive
    const pattern = new RegExp(`(${query})`, "gi"); // global, case-insensitive search
    return snippet.replace(pattern, '<span class="bg-yellow-200">$1</span>'); // Highlight with background color
}

// Function to get cached data from sessionStorage
function getCache(query) {
    const cache = JSON.parse(sessionStorage.getItem("searchCache")) || {};
    return cache[query];
}

// Function to set data to cache
function setCache(query, results) {
    const cache = JSON.parse(sessionStorage.getItem("searchCache")) || {};

    // Store the exact match results for the current query
    cache[query] = results;

    sessionStorage.setItem("searchCache", JSON.stringify(cache));
}