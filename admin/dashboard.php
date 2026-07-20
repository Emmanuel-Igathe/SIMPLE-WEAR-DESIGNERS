<?php
require_once 'auth.php';
require_once 'header.php';
?>

<h2>Admin Dashboard</h2>
<div class="grid">
    <div class="card" onclick="location.href='products.php'">
        <i class="fas fa-box" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        Manage Products
    </div>
    <div class="card" onclick="location.href='orders.php'">
        <i class="fas fa-shopping-bag" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        View Orders
    </div>
    <div class="card" onclick="location.href='users.php'">
        <i class="fas fa-users" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        Manage Users
    </div>
    <div class="card" onclick="location.href='traffic.php'">
        <i class="fas fa-chart-line" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        Traffic
    </div>
    <div class="card" onclick="location.href='analytics.php'">
        <i class="fas fa-chart-bar" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        Analytics
    </div>
    <div class="card" onclick="location.href='../logout.php'">
        <i class="fas fa-sign-out-alt" style="font-size:2rem;color:#ff6b6b;margin-bottom:10px;display:block;"></i>
        Logout
    </div>
</div>

<?php require_once 'footer.php'; ?>

