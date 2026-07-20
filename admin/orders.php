<?php
require_once '../admin/auth.php';
require_once 'header.php';

// Pagination settings
$itemsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $itemsPerPage;

$conn = get_db_connection();

// Get total count for pagination
$totalResult = $conn->query('SELECT COUNT(*) AS cnt FROM orders');
$totalRows = $totalResult->fetch_assoc()['cnt'];
$totalPages = ceil($totalRows / $itemsPerPage);

// Fetch orders for the current page
$stmt = $conn->prepare('SELECT id, customer_name, contact, total_amount, status, created_at FROM orders ORDER BY created_at DESC LIMIT ?, ?');
$stmt->bind_param('ii', $offset, $itemsPerPage);
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="admin-main">
    <h2>Orders Management</h2>
    <table class="admin-table" style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background:#2a2a48;">
                <th>ID</th><th>Customer</th><th>Contact</th><th>Total (KSH)</th><th>Status</th><th>Created</th><th>Details</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
            <tr style="border-bottom:1px solid #444;">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                <td><?php echo number_format($row['total_amount'],2); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn">View</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Pagination -->
    <div style="margin-top:20px; text-align:center;">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page-1; ?>" class="btn" style="margin-right:8px;">&laquo; Prev</a>
        <?php endif; ?>
        <?php if($page < $totalPages): ?>
            <a href="?page=<?php echo $page+1; ?>" class="btn">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>
<?php require_once 'footer.php'; ?>
