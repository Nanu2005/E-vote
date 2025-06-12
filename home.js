// home.js

// Event listener to handle the "Admin" button click to generate a 4-digit code
document.getElementById('generateCodeBtn').addEventListener('click', function() {
    // Generate a random 4-digit code
    const randomCode = Math.floor(1000 + Math.random() * 9000); // Generates a random number between 1000 and 9999

    // Store the generated code in localStorage
    localStorage.setItem('adminCode', randomCode);

    // Retrieve the existing history from localStorage
    let adminCodeHistory = JSON.parse(localStorage.getItem('adminCodeHistory')) || [];

    // Add the new code to the history
    adminCodeHistory.push(randomCode);

    // Save the updated history back to localStorage
    localStorage.setItem('adminCodeHistory', JSON.stringify(adminCodeHistory));

    // Show the admin login form where the admin can enter the code
    document.getElementById('adminLoginForm').style.display = 'block';
    alert('Admin Code Generated: ' + randomCode);
});

// Event listener to handle the submission of the code entered by the admin
document.getElementById('submitCodeBtn').addEventListener('click', function() {
    const enteredCode = document.getElementById('adminCodeInput').value;
    const storedCode = localStorage.getItem('adminCode');

    // Validate the entered code against the stored code
    if (enteredCode === storedCode) {
        // If the code matches, show the reason input box
        document.getElementById('adminReasonDiv').style.display = 'block';
        document.getElementById('error-message').textContent = ''; // Clear error message if the code is correct
    } else {
        // Show error message if the entered code does not match
        document.getElementById('error-message').textContent = 'Incorrect code. Please try again.';
    }
});

// Event listener to handle the submission of the admin's reason for taking the vote
document.getElementById('submitReasonBtn').addEventListener('click', function() {
    const reason = document.getElementById('adminReason').value;

    // You can process or save the reason here, for example, storing it in localStorage
    localStorage.setItem('adminReason', reason);

    // Alert the reason for now as an example
    alert('Reason Submitted: ' + reason);

    // You could redirect to the admin panel or any other action
    window.location.href = 'admin-panel.html';
});
