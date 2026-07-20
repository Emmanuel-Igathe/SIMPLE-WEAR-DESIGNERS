<?php
// migrate_admin.php – run once to add admin-related columns and tables
require_once 'db.php';

$conn = new mysqli($host, $user, $pass, $name);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// 1. Add is_admin column to registration if not exists
$res = $conn->query("SHOW COLUMNS FROM registration LIKE 'is_admin'");
if ($res->num_rows == 0) {
    $sql = "ALTER TABLE registration ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0";
    if ($conn->query($sql) === TRUE) {
        echo "Added is_admin column to registration.<br>";
    } else {
        echo "Error adding is_admin: " . $conn->error . "<br>";
    }
}

// 2. Add customer_name and contact to orders if not exists

// 2b. Create unified products table if not exists
$res = $conn->query("SHOW TABLES LIKE 'products'");
if ($res->num_rows == 0) {
    $sql = "CREATE TABLE products (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        category ENUM('men','women') NOT NULL,\n        name VARCHAR(255) NOT NULL,\n        description TEXT,\n        image_url TEXT,\n        old_price DECIMAL(10,2),\n        new_price DECIMAL(10,2),\n        discount VARCHAR(20),\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n    )";
    if ($conn->query($sql) === TRUE) {
        echo "Created unified products table.<br>";
    } else {
        echo "Error creating products table: " . $conn->error . "<br>";
    }
}
$res = $conn->query("SHOW COLUMNS FROM orders LIKE 'customer_name'");
if ($res->num_rows == 0) {
    $sql = "ALTER TABLE orders ADD COLUMN customer_name VARCHAR(255) NOT NULL DEFAULT ''";
    $conn->query($sql);
    echo "Added customer_name column to orders.<br>";
}
$res = $conn->query("SHOW COLUMNS FROM orders LIKE 'contact'");
if ($res->num_rows == 0) {
    $sql = "ALTER TABLE orders ADD COLUMN contact VARCHAR(50) NOT NULL DEFAULT ''";
    $conn->query($sql);
    echo "Added contact column to orders.<br>";
}

// 3. Create product_views table for analytics
$res = $conn->query("SHOW TABLES LIKE 'product_views'");
if ($res->num_rows == 0) {
    $sql = "CREATE TABLE product_views (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        product_id INT NOT NULL,\n        category ENUM('men','women') NOT NULL,\n        viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        ip VARCHAR(45),\n        user_id INT NULL,\n        FOREIGN KEY (user_id) REFERENCES registration(id) ON DELETE SET NULL\n    )";
    if ($conn->query($sql) === TRUE) {
        echo "Created product_views table.<br>";
    } else {
        echo "Error creating product_views: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
