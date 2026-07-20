<?php
require_once 'auth.php'; // ensure admin is logged in
require_once '../db.php';
$conn = get_db_connection();
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// 1. Sales over the last 30 days
$salesData = [];
$salesStmt = $conn->query("SELECT DATE(created_at) AS day, SUM(total_amount) AS total FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY day ORDER BY day");
if ($salesStmt) {
    while ($row = $salesStmt->fetch_assoc()) {
        $salesData[] = $row;
    }
}

// 2. Top 5 most viewed products (last 30 days)
$topViews = [];
$viewsQuery = "SELECT p.id, p.name, COUNT(v.id) AS views
               FROM product_views v
               JOIN products p ON v.product_id = p.id
               WHERE v.viewed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
               GROUP BY v.product_id
               ORDER BY views DESC
               LIMIT 5";
$viewsStmt = $conn->query($viewsQuery);
if ($viewsStmt) {
    while ($row = $viewsStmt->fetch_assoc()) {
        $topViews[] = $row;
    }
}

// 3. Order status distribution
$statusDist = [];
$statusStmt = $conn->query("SELECT status, COUNT(*) AS cnt FROM orders GROUP BY status");
if ($statusStmt) {
    while ($row = $statusStmt->fetch_assoc()) {
        $statusDist[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics | Simple Wear</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Outfit', sans-serif; background:#1a1a2e; color:#fff; margin:0; padding:20px;}
        h1 {text-align:center; margin-bottom:30px;}
        .chart-container {max-width:800px; margin:30px auto; background:#2a2a48; padding:20px; border-radius:8px;}
        canvas {background:#fff; border-radius:4px;}
        a {color:#ff6b6b; text-decoration:none;}
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Analytics Dashboard</h1>
    <div class="chart-container">
        <h2>Sales in Last 30 Days</h2>
        <canvas id="salesChart"></canvas>
    </div>
    <div class="chart-container">
        <h2>Top 5 Viewed Products (30d)</h2>
        <canvas id="viewsChart"></canvas>
    </div>
    <div class="chart-container">
        <h2>Order Status Distribution</h2>
        <canvas id="statusChart"></canvas>
    </div>
    <div style="text-align:center; margin-top:20px;">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesData = <?php echo json_encode(array_column($salesData, 'total')); ?>;
        const salesLabels = <?php echo json_encode(array_column($salesData, 'day')); ?>;
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Total Sales (KSH)',
                    data: salesData,
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255,107,107,0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {responsive:true, scales:{y:{beginAtZero:true}}}
        });

        // Views Chart
        const viewsCtx = document.getElementById('viewsChart').getContext('2d');
        const viewLabels = <?php echo json_encode(array_column($topViews, 'name')); ?>;
        const viewData = <?php echo json_encode(array_column($topViews, 'views')); ?>;
        new Chart(viewsCtx, {
            type: 'bar',
            data: {
                labels: viewLabels,
                datasets: [{
                    label: 'Views',
                    data: viewData,
                    backgroundColor: '#1a1a2e',
                    borderColor: '#ff6b6b',
                    borderWidth: 1
                }]
            },
            options: {responsive:true, scales:{y:{beginAtZero:true}}}
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusLabels = <?php echo json_encode(array_column($statusDist, 'status')); ?>;
        const statusData = <?php echo json_encode(array_column($statusDist, 'cnt')); ?>;
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#ff6b6b','#ffb74d','#4fc3f7','#81c784'],
                    borderColor: '#1a1a2e',
                    borderWidth: 1
                }]
            },
            options: {responsive:true}
        });
    </script>
</body>
</html>
