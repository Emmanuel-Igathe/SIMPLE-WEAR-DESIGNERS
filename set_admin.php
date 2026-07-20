<?php
// set_admin.php – promotion of the first registered user to admin
require_once 'db.php';

$conn = get_db_connection();
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Ensure the is_admin column exists (migration script already adds it, but just in case)
$res = $conn->query("SHOW COLUMNS FROM registration LIKE 'is_admin'");
if ($res->num_rows == 0) {
    $conn->query("ALTER TABLE registration ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0");
    echo "Added is_admin column.<br>";
}

// Promote the earliest user (by id) to admin
$update = $conn->prepare("UPDATE registration SET is_admin = 1 WHERE id = (SELECT id FROM (SELECT id FROM registration ORDER BY id ASC LIMIT 1) AS t");
if ($update->execute()) {
    echo "First user promoted to admin.<br>";
} else {
    echo 'Error promoting user: ' . $conn->error . "<br>";
}

$conn->close();
?>
