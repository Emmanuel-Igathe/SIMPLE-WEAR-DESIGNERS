<?php
require_once '../admin/auth.php';
require_once 'header.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $conn = get_db_connection();
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $message = 'Product deleted successfully.';
} else {
    $message = 'No product ID provided.';
}
?>
<div class="admin-main">
    <h2><?php echo $message; ?></h2>
    <a href="products.php" class="btn">Back to Products</a>
</div>
<?php require_once 'footer.php'; ?>
