<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple wear";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add to cart functionality
if (isset($_GET['men_add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        // Ensure all required fields are present
        $required_fields = ['id', 'name', 'price', 'image_url'];
        foreach ($required_fields as $field) {
            if (!isset($product[$field])) {
                die("Product data is missing required field: $field");
            }
        }
        
        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Check if product already in cart
        if (array_key_exists($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Add new product with all required fields
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => 1,
                'old_price' => $product['old_price'] ?? null,
                'discount' => $product['discount'] ?? null
            ];
        }
    }
}

// Remove from cart
if (isset($_GET['remove_from_cart'])) {
    $product_id = $_GET['remove_from_cart'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Calculate total amount
$total = 0;
if (!empty($_SESSION['cart'])) {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $id => $product) {
        $raw_price = $product['price'] ?? '0';
        if (!is_numeric($raw_price)) {
            $price = floatval(preg_replace('/[^0-9.]/', '', explode('-', $raw_price)[0]));
        } else {
            $price = floatval($raw_price);
        }
        $quantity = $product['quantity'] ?? 1;
        $subtotal += $price * $quantity;
    }
    $total = $subtotal + 200 + ($subtotal * 0.16); // Add shipping and tax
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>SIMPLE WEAR DESIGNERS</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> 
                    (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Cart Contents -->
    <section class="cart-container">
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="empty-cart">Your cart is empty. <a href="men.php">Continue shopping</a></p>
        <?php else: ?>
            <div class="cart-items">
                <?php 
                $subtotal = 0;
                foreach ($_SESSION['cart'] as $id => $product): 
                    // Extract numeric price
                    $raw_price = $product['price'] ?? '0';
                    if (!is_numeric($raw_price)) {
                        $price = floatval(preg_replace('/[^0-9.]/', '', explode('-', $raw_price)[0]));
                    } else {
                        $price = floatval($raw_price);
                    }
                    $quantity = $product['quantity'] ?? 1;
                    $item_total = $price * $quantity;
                    $subtotal += $item_total;
                ?>
                <div class="cart-item">
                    <div class="product-image">
                        <img src="<?= htmlspecialchars($product['image_url'] ?? '') ?>" 
                             alt="<?= htmlspecialchars($product['name'] ?? '') ?>">
                    </div>
                    
                    <div class="product-details">
                        <h2><?= htmlspecialchars($product['name'] ?? '') ?></h2>
                        <div class="price-info">
                            <span class="price">Ksh <?= number_format($price, 2) ?></span>
                            <?php if (isset($product['old_price']) && floatval($product['old_price']) > $price): ?>
                                <span class="old-price">was Ksh <?= number_format(floatval($product['old_price']), 2) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-options">
                            <div class="quantity-selector">
                                <label>Quantity: <?= $quantity ?></label>
                            </div>
                            
                            <a href="cart.php?remove_from_cart=<?= $id ?>" class="remove-btn">
                                <i class="fas fa-trash"></i> Remove
                            </a>
                        </div>
                        
                        <div class="item-total">
                            <p>Item Total: <span>Ksh <?= number_format($item_total, 2) ?></span></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <div class="summary-card">
                    <h2>Order Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal (<?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?> items)</span>
                        <span>Ksh <?= number_format($subtotal, 2) ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Ksh 150.00</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>Ksh <?= number_format($subtotal * 0.16, 2) ?></span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Ksh <?= number_format($subtotal + 200 + ($subtotal * 0.16), 2) ?></span>
                    </div>
                    
                   <!-- Simple Payment Button -->
<div class="checkout-section">
    <h2>Complete Your Order</h2>
    <form method="POST" action="checkout.php">
        <input type="hidden" name="total_amount" value="<?= $total ?>">
        <input type="hidden" name="order_id" value="<?= 'ORD-' . uniqid() ?>">
        
        <div class="form-group">
            <label for="customer_name">Full Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        
        <div class="form-group">
            <label for="phone_number">Phone Number (254...)</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                   pattern="254[0-9]{9}" title="Format: 2547XXXXXXXX" required>
            <small class="text-muted">Enter your M-Pesa registered number (format: 2547XXXXXXXX)</small>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        
        <button type="submit" name="checkout" class="checkout-btn">
            <i class="fas fa-credit-card"></i> Pay Ksh <?= number_format($total, 2) ?>
        </button>
    </form>
</div>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Follow Us</h3>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-tiktok"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-envelope"></i> <a href="mailto:emmanueligathe4@gmail.com">simplewear@gmail.com</a></li>
                    <li><i class="fas fa-phone"></i> <a href="tel:+254713078800">0713 078800</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> River Road, Nairobi, Kenya</li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="quick-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="men.php">Men</a></li>
                    <li><a href="women.php">Women</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="cart.php">Your Cart</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <strong>SIMPLE WEAR DESIGNERS</strong>.
        </div>
    </footer>
</body>
</html>