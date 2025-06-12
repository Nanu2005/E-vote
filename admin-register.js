document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get the entered 6-digit code
    const enteredCode = document.getElementById('admin-code').value;
    const reason = document.getElementById('reason').value;

    // Ensure the entered code is a 6-digit number
    if (enteredCode.length === 6 && !isNaN(enteredCode)) {
        // Store the code and reason in localStorage
        localStorage.setItem('adminCode', enteredCode);
        localStorage.setItem('voteReason', reason);

        console.log('Admin Code Stored:', enteredCode);  // Log to verify
        console.log('Vote Reason Stored:', reason);  // Log the reason

        // Redirect to login page after setting the code
        window.location.href = "admin-login.html";
    } else {
        document.getElementById('error-message').textContent = "Please enter a valid 6-digit code.";
    }
});
