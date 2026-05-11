<?php
// Start session and check admin login
session_start();
//if (!isset($_SESSION['admin_logged_in'])) {
 //   header('Location: admin_login.php');
 //   exit;
//}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'simple-wear');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Add new product
        $stmt = $conn->prepare("INSERT INTO men (name, description, image_url, old_price, new_price, discount, reviews, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdssis", 
            $_POST['name'],
            $_POST['description'],
            $_POST['image_url'],
            $_POST['old_price'],
            $_POST['new_price'],
            $_POST['discount'],
            $_POST['reviews'],
            $_POST['category']
        );
        $stmt->execute();
    } elseif (isset($_POST['update_product'])) {
        // Update product
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, image_url=?, old_price=?, new_price=?, discount=?, reviews=?, category=? WHERE id=?");
        $stmt->bind_param("sssdssisi", 
            $_POST['name'],
            $_POST['description'],
            $_POST['image_url'],
            $_POST['old_price'],
            $_POST['new_price'],
            $_POST['discount'],
            $_POST['reviews'],
            $_POST['category'],
            $_POST['id']
        );
        $stmt->execute();
    } elseif (isset($_GET['delete'])) {
        // Delete product
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $_GET['delete']);
        $stmt->execute();
    }
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        form { display: inline; }
    </style>
</head>
<body>
    <header>
        <header>
        <div class="logo-title">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFsgfUjcl2hqmWVpsW1xG8KbxRn40XU2IY-5aInmZTexf1ztNBIZPcRpj8HV7tkPKVdBs&usqp=CAU" alt="simplewear logo" class="logo">
            <h1>SIMPLE WEAR DESIGNERS</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a class="nav-link" href="home.php">HOME</a></li>
                <li><a class="nav-link" href="admin_products.php">ADMIN</a></li>
                <li><a class="nav-link" href="about.php">ABOUT US</a></li> 
                <li><a class="nav-link" href="men.php">MEN</a></li>
                <li><a class="nav-link" href="women.php">WOMEN</a></li>
                <li><a class="nav-link" href="login.php">LOGIN</a></li>
                <li><a  class="nav-link" href="registration.php">REGISTRATION</a></li>
                <li><a  class="nav-link" href="cart.php">CART</a></li>
                <li><a class="nav-link" href="checkout.php">CHECKOUT</a></li>
            </ul>
        </nav>
    </header>
    </header>
    <h1>Manage Products</h1>
    
    <!-- Add Product Form -->
    <h2>Add New Product</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <input type="number" step="0.01" name="old_price" placeholder="Old Price" required>
        <input type="text" name="new_price" placeholder="New Price" required>
        <input type="text" name="discount" placeholder="Discount" required>
        <input type="number" name="reviews" placeholder="Reviews" required>
        <select name="category" required>
            <option value="men">Men</option>
            <option value="women">Women</option>
        </select>
        <button type="submit" name="add_product">Add Product</button>
    </form>
    
    <!-- Products Table -->
    <h2>Existing Products</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Actions</th>
        </tr>
        <?php while($product = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><img src="<?= htmlspecialchars($product['image_url']) ?>" width="50"></td>
            <td><?= $product['new_price'] ?> (was <?= $product['old_price'] ?>)</td>
            <td><?= htmlspecialchars($product['discount']) ?></td>
            <td>
                <!-- Edit Form -->
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                    <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>">
                    <button type="submit" name="update_product">Update</button>
                </form>
                <a href="?delete=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conn->close(); 
?>