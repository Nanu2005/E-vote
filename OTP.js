function  sendOTP(){
    const email = document.getElementById('email');
    const OTPverify = document.getElementsByClassName('OTPverify')[0];

    let  OTP_val = Math.floor(Math.random() *100000);

    let  emailbody = '<h1>Your OTP is </h1>${otp_val}';

    Email.send({
        SecureToken : "bab883be-571b-476d-9902-f419740ffb0d",
        To : email.Value,
        From : "ny8097014468@gmail.com",
        Subject : "Verification of OTP",
        Body : emailbody,
    }).then(
      message => {
        if (message === "ok"){
           alert("OTP sent to your email " + email.value);
           
           OTPverify.style.display ="flex";
           const OTP_inp = document.getElementById("OTP_input");
           const OTP_btn = document.getElementById("btn-verify-OTP");

           OTP_btn.addEventListener('click', () => {
            if (OTP_inp.value == OTP_val)
                {
                alert("Registration is sucffull");
                OTPverify.style.display ="none";
                OTP_inp.value ="";
            }
            else{
                alert("Invalid OTP");
            }
           })
        }
      } 
    );
}