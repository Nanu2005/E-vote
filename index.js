function sendOTP() {
  const email = document.getElementById('email');
  const otpMessage = document.getElementById('otpMessage'); // For displaying OTP

  // Validate email
  if (!email.value || !email.value.includes('@')) {
      alert("Please enter a valid email address.");
      return;
  }

  // Generate OTP (6 digits)
  OTP_val = Math.floor(Math.random() * 1000000);
  console.log("Generated OTP:", OTP_val); // For debugging purposes

  otpMessage.innerHTML = `<strong>Generated OTP: </strong> ${OTP_val}`; // Display OTP for reference

  // Log the email to ensure it's passed correctly
  console.log("Sending OTP to: ", email.value);

  const templateParams = {
      to_email: email.value, // The recipient's email address
      otp: OTP_val // The OTP value to send
  };

  // Send OTP via EmailJS
  emailjs.send("service_o2napls", "template_53yur7v", templateParams)
      .then(function(response) {
          console.log("Success", response); // Debugging response
          alert("OTP has been sent to your email.");
      }, function(error) {
          console.error("Error sending email:", error); // Log error in console
          alert("Error sending email. Please try again.");
      });
}
