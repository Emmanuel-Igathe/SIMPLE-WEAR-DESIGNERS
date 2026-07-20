<?php
// admin/header.php
// Common header for admin pages - styled to match Simple Wear site
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Simple Wear</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="admin-header">
        <h1>
            <i class="fas fa-tshirt" style="color:#ff6b6b;"></i>
            SIMPLE WEAR <span>Admin</span>
        </h1>
        <nav class="admin-nav">
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="products.php"><i class="fas fa-box"></i> Products</a>
            <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
            <a href="users.php"><i class="fas fa-users"></i> Users</a>
            <a href="traffic.php"><i class="fas fa-chart-line"></i> Traffic</a>
            <a href="../logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>
    <main class="admin-main">
