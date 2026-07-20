<?php
require_once 'auth.php';
require_once 'header.php';

// Fetch product if editing
$edit = false;
$product = ['id'=> '', 'category'=>'', 'name'=>'', 'description'=>'', 'image_url'=>'', 'old_price'=>'', 'new_price'=>'', 'discount'=>''];
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $edit = true;
    $id = (int)$_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
    $stmt->close();
    $conn->close();
}
?>
<div class="admin-main">
    <h2><?php echo $edit ? 'Edit' : 'Add'; ?> Product</h2>
    <form action="product_save.php" method="post" class="product-form" style="max-width:600px;">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <?php endif; ?>
        <label>Category:</label><br>
        <select name="category" required>
            <option value="men" <?php echo $product['category']=='men' ? 'selected' : ''; ?>>Men</option>
            <option value="women" <?php echo $product['category']=='women' ? 'selected' : ''; ?>>Women</option>
        </select><br><br>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>
        <label>Description:</label><br>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>
        <label>Image URL:</label><br>
        <input type="url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" required><br><br>
        <label>Old Price:</label><br>
        <input type="number" step="0.01" name="old_price" value="<?php echo $product['old_price']; ?>"><br><br>
        <label>New Price:</label><br>
        <input type="number" step="0.01" name="new_price" value="<?php echo $product['new_price']; ?>" required><br><br>
        <label>Discount (e.g., 20%):</label><br>
        <input type="text" name="discount" value="<?php echo htmlspecialchars($product['discount']); ?>"><br><br>
        <button type="submit" class="btn"><?php echo $edit ? 'Update' : 'Create'; ?> Product</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>
