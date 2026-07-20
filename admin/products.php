<?php
require_once '../admin/auth.php';
require_once 'header.php';

$conn = get_db_connection();
$res = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>
<div class="admin-main">
    <h2>Products Management</h2>
    <a href="product_form.php" class="btn">+ Add New Product</a>
    <table class="admin-table" style="width:100%; margin-top:20px; border-collapse:collapse;">
        <thead>
            <tr style="background:#2a2a48;">
                <th>ID</th><th>Category</th><th>Name</th><th>Price</th><th>Discount</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
            <tr style="border-bottom:1px solid #444;">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo number_format($row['new_price'],2); ?></td>
                <td><?php echo htmlspecialchars($row['discount']); ?></td>
                <td>
                    <a href="product_form.php?id=<?php echo $row['id']; ?>" class="btn" style="margin-right:5px;">Edit</a>
                    <a href="product_delete.php?id=<?php echo $row['id']; ?>" class="btn" style="background:#ff6b6b;">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php'; ?>
