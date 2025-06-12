document.getElementById('final-result-btn').addEventListener('click', function() {
    const voteData = {
        labels: ["Candidate 1", "Candidate 2", "Candidate 3"],  // Labels for the candidates
        datasets: [{
            label: "Votes",
            data: [120, 200, 150],  // Example votes for each candidate
            backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],  // Colors for the chart
            borderColor: ['#FF5733', '#33FF57', '#3357FF'],
            borderWidth: 1
        }]
    };

    // Create bar chart
    const ctx = document.getElementById('resultsChart').getContext('2d');
    const resultsChart = new Chart(ctx, {
        type: 'bar',  // Chart type
        data: voteData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Populate results table
    const tableBody = document.querySelector('#resultsTable tbody');
    voteData.labels.forEach((candidate, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${candidate}</td><td>${voteData.datasets[0].data[index]}</td>`;
        tableBody.appendChild(row);
    });

    // Display result table
    document.getElementById('results-table').style.display = "block";
});
