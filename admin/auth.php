<?php
// admin/auth.php – protect admin pages
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
require_once '../db.php';
$conn = get_db_connection();
$stmt = $conn->prepare('SELECT is_admin FROM registration WHERE id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
if (!$row || $row['is_admin'] == 0) {
    echo 'Access denied – admin only.';
    exit();
}
?>
