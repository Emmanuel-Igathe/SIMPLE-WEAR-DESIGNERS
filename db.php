<?php
/**
 * Central Database Configuration
 * Uses Environment Variables for Vercel/Production
 * Falls back to localhost for development
 */

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'simple-wear';
$port = getenv('DB_PORT') ?: '3306';

// For MySQLi connections
function get_db_connection() {
    global $host, $user, $pass, $name, $port;
    
    $conn = mysqli_init();
    
    // If we are on Vercel (DB_HOST is set), use SSL for Aiven compatibility
    if (getenv('DB_HOST')) {
        // Aiven requires SSL. We use the MYSQLI_CLIENT_SSL flag.
        if (!$conn->real_connect($host, $user, $pass, $name, $port, null, MYSQLI_CLIENT_SSL)) {
            die("Cloud Database Connection Failed: " . mysqli_connect_error());
        }
    } else {
        // Local development
        if (!$conn->real_connect($host, $user, $pass, $name, $port)) {
            die("Local Database Connection Failed: " . mysqli_connect_error());
        }
    }
    
    return $conn;
}

// For PDO connections (used in registration)
function get_pdo_connection() {
    global $host, $user, $pass, $name, $port;
    try {
        $options = [];
        if (getenv('DB_HOST')) {
            // Enable SSL for PDO on Vercel
            $options[PDO::MYSQL_ATTR_SSL_CA] = true; 
            // Note: On some systems, you might need a specific path, 
            // but setting it to true often works for 'REQUIRED' mode.
        }
        
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $pass, $options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Cloud Database (PDO) Failed: " . $e->getMessage());
    }
}
?>
