<?php
require_once '../admin/auth.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: products.php');
    exit();
}

$conn = get_db_connection();

$id = $_POST['id'] ?? null;
$category = $_POST['category'];
$name = $_POST['name'];
$description = $_POST['description'];
$image_url = $_POST['image_url'];
$old_price = $_POST['old_price'] ?: null;
$new_price = $_POST['new_price'];
$discount = $_POST['discount'] ?: null;

if ($id) {
    // Update existing product
    $stmt = $conn->prepare("UPDATE products SET category=?, name=?, description=?, image_url=?, old_price=?, new_price=?, discount=? WHERE id=?");
    $stmt->bind_param('ssssddsi', $category, $name, $description, $image_url, $old_price, $new_price, $discount, $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Product updated successfully.';
} else {
    // Insert new product
    $stmt = $conn->prepare("INSERT INTO products (category, name, description, image_url, old_price, new_price, discount) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssdds', $category, $name, $description, $image_url, $old_price, $new_price, $discount);
    $stmt->execute();
    $stmt->close();
    $message = 'Product created successfully.';
}

$conn->close();
?>
<div class="admin-main">
    <h2><?php echo $message; ?></h2>
    <a href="products.php" class="btn">Back to Products</a>
</div>
<?php require_once 'footer.php'; ?>
