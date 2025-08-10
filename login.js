document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const loginForm = document.getElementById('loginForm');
    const otpForm = document.getElementById('otpForm');
    const loginContainer = document.getElementById('loginFormContainer');
    const otpContainer = document.getElementById('otpContainer');
    const errorMessage = document.getElementById('error-message');
    const otpErrorMessage = document.getElementById('otp-error-message');
    const resendOtpLink = document.getElementById('resendOtp');
    
    // Simulated user database
    const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];
    let generatedOtp = '';
    let userEmail = '';

    // Generate OTP (3 letters + 3 numbers in CAPS)
    function generateOTP() {
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '0123456789';
        let otp = '';
        
        // Add 3 random letters
        for (let i = 0; i < 3; i++) {
            otp += letters.charAt(Math.floor(Math.random() * letters.length));
        }
        
        // Add 3 random numbers
        for (let i = 0; i < 3; i++) {
            otp += numbers.charAt(Math.floor(Math.random() * numbers.length));
        }
        
        // Shuffle the characters
        return otp.split('').sort(() => 0.5 - Math.random()).join('');
    }

    // Login Form Submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        userEmail = email;
        
        // Check if user exists (in a real app, this would be a server call)
        const userExists = registeredUsers.some(user => user.email === email);
        
        if (userExists) {
            // Generate and "send" OTP (in production, send via email/SMS)
            generatedOtp = generateOTP();
            console.log(`OTP for ${email}: ${generatedOtp}`); // For testing
            
            // Show OTP form
            loginContainer.style.display = 'none';
            otpContainer.style.display = 'block';
            errorMessage.style.display = 'none';
        } else {
            // User not registered
            errorMessage.textContent = 'Account not found. Please register first.';
            errorMessage.style.display = 'block';
            setTimeout(() => {
                window.location.href = 'registration.html';
            }, 2000);
        }
    });

    // OTP Form Submission
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const enteredOtp = document.getElementById('otp').value.trim();
        
        if (enteredOtp === generatedOtp) {
            // Successful login
            otpErrorMessage.style.display = 'none';
            alert(`Welcome back! You're now logged in as ${userEmail}`);
            window.location.href = 'home.html';
        } else {
            // Invalid OTP
            otpErrorMessage.textContent = 'Invalid OTP code. Please try again.';
            otpErrorMessage.style.display = 'block';
        }
    });

    // Resend OTP
    resendOtpLink.addEventListener('click', function(e) {
        e.preventDefault();
        generatedOtp = generateOTP();
        console.log(`New OTP for ${userEmail}: ${generatedOtp}`); // For testing
        otpErrorMessage.textContent = 'New OTP sent successfully!';
        otpErrorMessage.style.color = '#28a745';
        otpErrorMessage.style.backgroundColor = '#e8f5e9';
        otpErrorMessage.style.display = 'block';
        
        setTimeout(() => {
            otpErrorMessage.style.display = 'none';
        }, 3000);
    });
});