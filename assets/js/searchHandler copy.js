const cache = new Map();

document.getElementById("searchForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const query = document.getElementById("searchInput").value.trim();
    const resultsContainer = document.getElementById("results");
    const timeDisplay = document.getElementById('searchTime');
    resultsContainer.innerHTML = "";
    timeDisplay.textContent = '';
    
    if (!query) {
        resultsContainer.innerHTML = '<p class="text-gray-600 text-center">Please enter a search term.</p>';
        return;
    }
    
    const startTime = performance.now();
    if (cache.has(query)) {
        const cachedResults = cache.get(query);
        displayResults(cachedResults, resultsContainer);
        const endTime = performance.now();
        console.log(`Retrieved from cache in ${endTime - startTime}ms`);
        timeDisplay.textContent = `Retrieved from cache in ${(endTime - startTime).toFixed(2)} ms.`;
        return;
    }

    try {
        const response = await fetch(
            `search.php?query=${encodeURIComponent(query)}`
        );
        const results = await response.json();

        if (results.length > 0) {
            cache.set(query, results);
        }
        displayResults(results, resultsContainer);
    } catch (error) {
        resultsContainer.innerHTML =
            '<p class="text-red-500">Error fetching results.</p>';
    }

    const endTime = performance.now();
    console.log(`Search completed in ${endTime - startTime}ms`);
    timeDisplay.textContent = `Search completed in ${(endTime - startTime).toFixed(2)} ms.`;
});

function displayResults(results, container) {
    if (results.length === 0) {
        container.innerHTML = '<p class="text-gray-600">No results found.</p>';
        return;
    }
    results.forEach((result) => {
        const item = document.createElement("div");
        item.classList.add("p-4", "bg-white", "rounded", "shadow-md");
        item.innerHTML = `
            <h3 class="font-bold">${result.file}</h3>
            <p>${result.snippet}</p>
            <a href="${result.path}" class="text-blue-500 hover:underline">View More</a>
        `;
        container.appendChild(item);
    });
}
