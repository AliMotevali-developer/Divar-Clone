let searchTimeout;

async function searchAjax(query) {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(async () => {
        try {
            const response = await fetch(`search.php?search=${encodeURIComponent(query)}`);
            const html = await response.text();
            document.getElementById("resultContainer").innerHTML = html;
        } catch (error) {
            console.error("خطا در جستجو:", error);
        }
    }, 250);
}