// history.js

// Function to load and display the history of admin codes from localStorage
function loadHistory() {
    const historyList = document.getElementById('history-list');
    
    // Get the admin codes stored in localStorage (as an array)
    const adminCodeHistory = JSON.parse(localStorage.getItem('adminCodeHistory')) || [];
    
    // If there are no codes, show a message
    if (adminCodeHistory.length === 0) {
        historyList.innerHTML = "<li>No admin codes have been generated yet.</li>";
    } else {
        // Display each stored admin code as a list item
        adminCodeHistory.forEach(function(code) {
            const listItem = document.createElement('li');
            listItem.textContent = `Admin Code: ${code}`;
            historyList.appendChild(listItem);
        });
    }
}

// Load history when the page loads
window.onload = loadHistory;
