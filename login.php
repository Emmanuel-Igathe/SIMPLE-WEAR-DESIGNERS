<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Simple Wear</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <a href="home.html" class="header-title">SIMPLE WEAR</a>
        <nav>
            <ul class="nav-links">
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
            </ul>
        </nav>
        <div class="header-icons">
            <a href="cart.php">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYDlmGP8qRC2WJ29Fo4r9-iC3uqxDMznboywvaXvsOLO3MU1UV-wsz_N1eu-oG7m9nOKQ&usqp=CAU" alt="Cart" class="nav-icon">
                (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
            </a>
        </div>
    </header>

    <main class="login-main">
        <div class="login-container" id="loginFormContainer">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
                <div id="error-message"></div>
            </div>
            
            <form class="login-form" id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">Continue</button>
            </form>
            
            <div class="register-prompt">
                <p>Don't have an account? <a href="registration.php" class="register-link">Register here</a></p>
            </div>
        </div>

        <!-- OTP Verification (hidden by default) -->
        <div class="otp-container" id="otpContainer" style="display:none;">
            <div class="login-header">
                <h1>Verify Your Identity</h1>
                <p>We've sent a 6-digit code to your email</p>
                <div id="otp-error-message"></div>
            </div>
            
            <form class="otp-form" id="otpForm">
                <div class="form-group">
                    <label for="otp">Enter OTP Code</label>
                    <input type="text" id="otp" name="otp" maxlength="6" required>
                    <p class="otp-hint">(3 letters + 3 numbers in CAPS)</p>
                </div>
                
                <button type="submit" class="login-btn">Verify & Login</button>
            </form>
            
            <div class="otp-resend">
                <p>Didn't receive code? <a href="#" id="resendOtp">Resend OTP</a></p>
            </div>
        </div>
    </main>

    <script src="login.js"></script>
</body>
</html>