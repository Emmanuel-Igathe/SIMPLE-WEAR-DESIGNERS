<?php 
session_start();
require_once 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        try {
            $conn = get_pdo_connection();
            $stmt = $conn->prepare("SELECT id, firstName, lastName, password, is_admin FROM registration WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password'])) {
                    // Password is correct, start session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['firstName'] . ' ' . $user['lastName'];
                    $_SESSION['user_email'] = $email;
                    
                    // Redirect based on admin flag
                    if (!empty($user['is_admin']) && $user['is_admin'] == 1) {
                        header("Location: admin/dashboard.php");
                    } else {
                        header("Location: home.php");
                    }
                    exit();
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "Account not found. Please register first.";
            }
        } catch (PDOException $e) {
            $error = "Database error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Simple Wear</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <a href="home.php" class="header-title">SIMPLE WEAR</a>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">PROFILE</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="login.php">LOGIN</a></li>
                <?php endif; ?>
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
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
            </div>
            
            <form class="login-form" method="POST" action="login.php">
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
    </main>
</body>
</html>