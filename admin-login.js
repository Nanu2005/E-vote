document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Retrieve the stored admin code from local storage
    const storedCode = localStorage.getItem('adminCode');
    console.log('Stored Admin Code:', storedCode);  // Log the stored code to verify

    // Get the entered code from the input field
    const enteredCode = document.getElementById('admin-code').value;
    console.log('Entered Code:', enteredCode);  // Log the entered code

    // Check if the entered code matches the stored code
    if (enteredCode === storedCode) {
        window.location.href = "admin.html";  // Redirect to admin panel if the code matches
    } else {
        document.getElementById('error-message').textContent = "Incorrect code. Please try again.";  // Show error message
    }
});
