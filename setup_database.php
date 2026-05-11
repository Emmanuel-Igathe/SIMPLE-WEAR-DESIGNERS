<?php
// Database connection details
require_once 'db.php';

// Create connection to MySQL (without selecting DB first to ensure it exists)
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `$name`";
if ($conn->query($sql) === TRUE) {
    echo "Database '$name' ensured.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($name);

// 1. Create registration table
$sql = "CREATE TABLE IF NOT EXISTS registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    address TEXT,
    city VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'registration' ensured.<br>";
} else {
    echo "Error creating registration table: " . $conn->error . "<br>";
}

// 2. Create men table
$sql = "CREATE TABLE IF NOT EXISTS men (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_url TEXT,
    old_price DECIMAL(10,2),
    new_price VARCHAR(50),
    discount VARCHAR(20),
    reviews INT DEFAULT 0,
    category VARCHAR(50) DEFAULT 'men'
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'men' ensured.<br>";
} else {
    echo "Error creating men table: " . $conn->error . "<br>";
}

// 3. Create women table
$sql = "CREATE TABLE IF NOT EXISTS women (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_url TEXT,
    old_price DECIMAL(10,2),
    new_price VARCHAR(50),
    discount VARCHAR(20),
    reviews INT DEFAULT 0,
    category VARCHAR(50) DEFAULT 'women'
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'women' ensured.<br>";
} else {
    echo "Error creating women table: " . $conn->error . "<br>";
}

echo "<h3>Setup Complete!</h3>";
echo "<p>Now seeding products...</p>";

// Close connection before including upload scripts which create their own connections
$conn->close();

// Include the upload scripts to seed data
echo "<h4>Seeding Men's Products:</h4>";
include 'mensupload.php';

echo "<h4>Seeding Women's Products:</h4>";
include 'womenupload.php';

echo "<br><br><a href='home.php'>Go to Home Page</a>";
?>
