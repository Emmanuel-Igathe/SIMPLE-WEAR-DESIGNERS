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
    $conn = new mysqli($host, $user, $pass, $name, $port);
    if ($conn->connect_error) {
        // More descriptive error for debugging
        die("Cloud Database Connection Failed: " . $conn->connect_error . " (Check your Vercel Environment Variables)");
    }
    return $conn;
}

// For PDO connections (used in registration)
function get_pdo_connection() {
    global $host, $user, $pass, $name, $port;
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Cloud Database (PDO) Failed: " . $e->getMessage());
    }
}
?>
