<?php
session_start();

// ---- Handle cart actions FIRST ----

// Clear entire cart
if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit();
}

// Remove single item
if (isset($_GET['remove_from_cart'])) {
    $pid = $_GET['remove_from_cart'];
    unset($_SESSION['cart'][$pid]);
    header('Location: cart.php');
    exit();
}

// Update quantity (+/-)
if (isset($_GET['update_qty']) && isset($_GET['product_id'])) {
    $pid = $_GET['product_id'];
    $qty = intval($_GET['update_qty']);
    if ($qty <= 0) {
        unset($_SESSION['cart'][$pid]);
    } elseif (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid]['quantity'] = $qty;
    }
    header('Location: cart.php');
    exit();
}

// ---- Migrate old sequential-keyed cart to product_id-keyed cart ----
if (!empty($_SESSION['cart'])) {
    $needsMigration = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if (is_int($key) && isset($item['id']) && $key !== $item['id']) {
            $needsMigration = true;
            break;
        }
    }
    if ($needsMigration) {
        $newCart = [];
        foreach ($_SESSION['cart'] as $item) {
            $pid = $item['id'];
            if (isset($newCart[$pid])) {
                $newCart[$pid]['quantity'] += intval($item['quantity'] ?? 1);
            } else {
                $newCart[$pid] = $item;
            }
        }
        $_SESSION['cart'] = $newCart;
    }
}

// Calculate totals
$subtotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $raw   = $product['price'] ?? '0';
        $price = is_numeric($raw)
            ? floatval($raw)
            : floatval(preg_replace('/[^0-9.]/', '', explode('-', $raw)[0]));
        $subtotal += $price * intval($product['quantity'] ?? 1);
    }
}
$shipping = 150;
$tax      = $subtotal * 0.16;
$total    = $subtotal + $shipping + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo-title">
            <h1>SIMPLE WEAR</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a class="nav-link" href="home.php">HOME</a></li>
                <li><a class="nav-link" href="men.php">MEN</a></li>
                <li><a class="nav-link" href="women.php">WOMEN</a></li>
                <li><a class="nav-link" href="about.php">ABOUT US</a></li>
                <li><a href="cart.php" class="nav-link nav-cart">
                    <i class="fas fa-shopping-cart"></i> 
                    CART (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Cart Contents -->
    <section class="cart-container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h1 style="margin:0;">Your Shopping Cart</h1>
            <?php if (!empty($_SESSION['cart'])): ?>
                <form method="GET" action="cart.php" style="display:inline;">
                    <input type="hidden" name="clear_cart" value="1">
                    <button type="submit" style="background:#dc3545;color:white;border:none;padding:8px 14px;border-radius:5px;cursor:pointer;font-size:0.9rem;">
                        <i class="fas fa-trash"></i> Clear Cart
                    </button>
                </form>
            <?php endif; ?>
        </div>
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="empty-cart">Your cart is empty. <a href="men.php">Continue shopping</a></p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $pid => $product): 
                    $raw  = $product['price'] ?? '0';
                    $price = is_numeric($raw)
                        ? floatval($raw)
                        : floatval(preg_replace('/[^0-9.]/', '', explode('-', $raw)[0]));
                    $quantity   = intval($product['quantity'] ?? 1);
                    $item_total = $price * $quantity;
                ?>
                <div class="cart-item">
                    <div class="product-image">
                        <img src="<?= htmlspecialchars($product['image_url'] ?? '') ?>"
                             alt="<?= htmlspecialchars($product['name'] ?? 'Product') ?>">
                    </div>
                    <div class="product-details">
                        <h2><?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?></h2>
                        <div class="price-info">
                            <span class="price">Ksh <?= number_format($price, 2) ?></span>
                        </div>
                        <div class="product-options">
                            <div class="quantity-selector">
                                <label>Qty:</label>
                                <div style="display:flex;align-items:center;gap:10px;margin-top:5px;">
                                    <a href="cart.php?update_qty=<?= max(0, $quantity - 1) ?>&product_id=<?= urlencode($pid) ?>" class="qty-btn">&#8722;</a>
                                    <strong><?= $quantity ?></strong>
                                    <a href="cart.php?update_qty=<?= $quantity + 1 ?>&product_id=<?= urlencode($pid) ?>" class="qty-btn">+</a>
                                </div>
                            </div>
                            <a href="cart.php?remove_from_cart=<?= urlencode($pid) ?>" class="remove-btn">
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

            <!-- Brand Column -->
            <div class="footer-section footer-brand">
                <h2 class="footer-logo">SIMPLE WEAR</h2>
                <p class="footer-tagline">Premium quality fashion for every style. Founded in Nairobi, Kenya.</p>
                <div class="footer-social">
                    <a href="https://web.whatsapp.com/" target="_blank" title="WhatsApp" class="social-icon whatsapp"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.facebook.com/" target="_blank" title="Facebook" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" title="Instagram" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com/" target="_blank" title="Twitter" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.tiktok.com/" target="_blank" title="TikTok" class="social-icon tiktok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="home.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="men.php"><i class="fas fa-chevron-right"></i> Men's Collection</a></li>
                    <li><a href="women.php"><i class="fas fa-chevron-right"></i> Women's Collection</a></li>
                    <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="cart.php"><i class="fas fa-chevron-right"></i> My Cart</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-envelope"></i><a href="mailto:simplewear@gmail.com">simplewear@gmail.com</a></li>
                    <li><i class="fas fa-phone"></i><a href="tel:+254713078800">+254 713 078800</a></li>
                    <li><i class="fas fa-map-marker-alt"></i>River Road, Nairobi, Kenya</li>
                    <li><i class="fas fa-clock"></i>Mon–Sat: 8am – 7pm</li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 <strong>Simple Wear Designers</strong>. All Rights Reserved. | Made with <i class="fas fa-heart" style="color:#ff6b6b;"></i> in Nairobi</p>
        </div>
    </footer>
</body>
</html>