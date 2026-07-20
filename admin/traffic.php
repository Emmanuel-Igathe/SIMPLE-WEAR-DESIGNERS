<?php
require_once '../admin/auth.php';
require_once 'header.php';

$conn = get_db_connection();

// 1. Total product view count
$totalViews = 0;
$res = $conn->query('SELECT COUNT(*) AS cnt FROM product_views');
if ($res) {
    $totalViews = $res->fetch_assoc()['cnt'];
}

// 2. Top 5 most viewed products (overall)
$topProducts = [];
$topStmt = $conn->query("SELECT p.id, p.name, COUNT(v.id) AS views FROM product_views v JOIN products p ON v.product_id = p.id GROUP BY v.product_id ORDER BY views DESC LIMIT 5");
if ($topStmt) {
    while ($row = $topStmt->fetch_assoc()) {
        $topProducts[] = $row;
    }
}

// 3. Views per day for the last 30 days
$viewsByDay = [];
$dayStmt = $conn->query("SELECT DATE(viewed_at) AS day, COUNT(*) AS cnt FROM product_views WHERE viewed_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY day ORDER BY day");
if ($dayStmt) {
    while ($row = $dayStmt->fetch_assoc()) {
        $viewsByDay[] = $row;
    }
}

$conn->close();
?>
<div class="admin-main">
    <h2>Traffic Overview</h2>
    <p>Total product views: <strong><?php echo $totalViews; ?></strong></p>
    <div class="grid">
        <div class="card">
            <h3>Top 5 Viewed Products</h3>
            <ul>
                <?php foreach ($topProducts as $prod): ?>
                    <li><?php echo htmlspecialchars($prod['name']); ?> – <?php echo $prod['views']; ?> views</li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card">
            <h3>Views in the Last 30 Days</h3>
            <canvas id="viewsChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('viewsChart').getContext('2d');
    const labels = <?php echo json_encode(array_column($viewsByDay, 'day')); ?>;
    const data = <?php echo json_encode(array_column($viewsByDay, 'cnt')); ?>;
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Views per Day',
                data: data,
                borderColor: '#ff6b6b',
                backgroundColor: 'rgba(255,107,107,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {responsive:true, scales:{y:{beginAtZero:true}}}
    });
</script>
<?php require_once 'footer.php'; ?>
