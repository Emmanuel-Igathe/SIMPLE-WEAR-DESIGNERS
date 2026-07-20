<?php
// set_admin_emmanuel.php – promote Emmanuel Igathe to admin
require_once 'db.php';

$conn = get_db_connection();
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Ensure is_admin column exists (safety)
$res = $conn->query("SHOW COLUMNS FROM registration LIKE 'is_admin'");
if ($res->num_rows == 0) {
    $conn->query("ALTER TABLE registration ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0");
    echo "Added is_admin column.<br>";
}

// Promote user Emmanuel Igathe
$stmt = $conn->prepare("UPDATE registration SET is_admin = 1 WHERE firstName = ? AND lastName = ?");
$first = 'Emmanuel';
$last  = 'Igathe';
$stmt->bind_param('ss', $first, $last);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "User Emmanuel Igathe is now an admin.<br>";
    } else {
        echo "No matching user found for Emmanuel Igathe.<br>";
    }
} else {
    echo 'Error promoting user: ' . $stmt->error . "<br>";
}

$stmt->close();
$conn->close();
?>
