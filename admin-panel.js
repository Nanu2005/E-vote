document.getElementById('generateCodeBtn').addEventListener('click', function() {
    // Generate a 4-digit code and store it in localStorage
    const generatedCode = Math.floor(1000 + Math.random() * 9000); // Generates a 4-digit code
    localStorage.setItem('generatedAdminCode', generatedCode); // Store the code in localStorage
    alert('Admin Code Generated: ' + generatedCode); // Show the generated code for testing purposes (you can remove this line)
    
    // Show the input form to enter the generated code
    document.getElementById('adminLoginForm').style.display = 'block';
    document.getElementById('adminBtnContainer').style.display = 'none'; // Hide the "Generate Admin Code" button
});

document.getElementById('submitCodeBtn').addEventListener('click', function() {
    const adminCodeInput = document.getElementById('adminCodeInput').value;
    const generatedCode = localStorage.getItem('generatedAdminCode'); // Retrieve the generated code from localStorage
    
    if (adminCodeInput === generatedCode) {
        // If the entered code matches the generated code, show the reason input
        document.getElementById('adminReasonDiv').style.display = 'block';
        document.getElementById('adminLoginForm').style.display = 'none'; // Hide the code input form
    } else {
        // If the code is incorrect, display an error message
        document.getElementById('error-message').textContent = "Incorrect code. Please try again.";
    }
});

document.getElementById('submitReasonBtn').addEventListener('click', function() {
    const reason = document.getElementById('adminReason').value;
    if (reason) {
        alert('Reason submitted: ' + reason);
        // You can save the reason or perform further actions here
    } else {
        alert('Please enter a reason.');
    }
});
