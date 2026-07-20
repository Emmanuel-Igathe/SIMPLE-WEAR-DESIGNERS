<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registration.php");
    exit();
}

// Collect and sanitize form data
$firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
$lastName = htmlspecialchars(trim($_POST['lastName'] ?? ''));
$dob = $_POST['dob'] ?? '';
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$city = htmlspecialchars(trim($_POST['city'] ?? ''));
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validate inputs
$errors = [];

if (empty($firstName)) $errors[] = "First name is required";
if (empty($lastName)) $errors[] = "Last name is required";
if (empty($dob)) $errors[] = "Date of birth is required";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
if (empty($city)) $errors[] = "City is required";
if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters";
if ($password !== $confirmPassword) $errors[] = "Passwords do not match";

// Validate date format
if (!empty($dob) && !DateTime::createFromFormat('Y-m-d', $dob)) {
    $errors[] = "Invalid date format (YYYY-MM-DD required)";
}

if (!empty($errors)) {
    // More user-friendly error display
    echo "<h2>Registration Errors:</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "<p><a href='registration.php'>Go back to registration form</a></p>";
    exit();
}

// Hash password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

require_once 'db.php';

try {
    $conn = get_pdo_connection();

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM registration WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        die("Email already registered. <a href='login.php'>Click here to login</a> or <a href='registration.php'>try another email</a>.");
    }

    // Insert new user - FIXED query with proper placeholders
    $stmt = $conn->prepare("INSERT INTO registration 
                          (firstName, lastName, dob, email, city, password) 
                          VALUES (:firstName, :lastName, :dob, :email, :city, :password)");
    
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':password', $passwordHash); // Using the hashed password
    
    $stmt->execute();
    
    // Success message with better formatting
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Registration Successful</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px; }
            .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; }
            .btn { display: inline-block; background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='success'>
            <h2>Registration Successful!</h2>
            <p>Welcome, $firstName! Your account has been created.</p>
        </div>
        <p><a href='login.php' class='btn'>Click here to login</a></p>
    </body>
    </html>";
    
} catch(PDOException $e) {
    // More user-friendly database error
    die("<h2>Registration Error</h2><p>We encountered a problem creating your account. Please try again later.</p>");
} finally {
    $conn = null;
}
?>