<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Simple Wear</title>
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <h1>SIMPLE WEAR DESIGNERS</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">PROFILE</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="registration.php" class="active">REGISTER</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                <?php endif; ?>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</a></li>
            </ul>
        </nav>
    </header>
    <div class="registration-container">
        <div class="registration-header">
            <h1>Create Your Account</h1>
            <p>Join Simple Wear for exclusive offers</p>
        </div>

        <form  id="registrationForm" class="registration-form" action="connect.php" method="post">
            <div class="form-group">
                <label for="firstName">First Name*</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name*</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth*</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" required>
            </div>



            <div class="form-group">
                <label for="city">City*</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>
                <div class="password-requirements">
                    <p>Password must contain:</p>
                    <ul>
                        <li id="length">At least 8 characters</li>
                        <li id="capital">One capital letter</li>
                        <li id="number">One number</li>
                        <li id="special">One special character (*/?!.)</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password*</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <p id="passwordMatch" class="validation-message"></p>
            </div>

            <button type="submit" class="register-btn">Register</button>

            <div class="login-link">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const lengthValid = password.length >= 8;
    const capitalValid = /[A-Z]/.test(password);
    const numberValid = /[0-9]/.test(password);
    const specialValid = /[*\/?!.]/.test(password);

    // Update validation indicators
    document.getElementById('length').style.color = lengthValid ? 'green' : 'red';
    document.getElementById('capital').style.color = capitalValid ? 'green' : 'red';
    document.getElementById('number').style.color = numberValid ? 'green' : 'red';
    document.getElementById('special').style.color = specialValid ? 'green' : 'red';
});

document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const matchMessage = document.getElementById('passwordMatch');
    
    if (password === confirmPassword) {
        matchMessage.textContent = 'Passwords match!';
        matchMessage.style.color = 'green';
    } else {
        matchMessage.textContent = 'Passwords do not match';
        matchMessage.style.color = 'red';
    }
});

document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Check all password requirements
    const isValid = password.length >= 8 && 
                   /[A-Z]/.test(password) && 
                   /[0-9]/.test(password) && 
                   /[*\/?!.]/.test(password) && 
                   password === confirmPassword;
    
    if (!isValid) {
        e.preventDefault();
        alert('Please ensure your password meets all requirements and matches the confirmation');
    }
});
</script>
</body>
</html>