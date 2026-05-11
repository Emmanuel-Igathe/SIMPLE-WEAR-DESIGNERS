<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Collection | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="women.css">
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
                    (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Page Title -->
    <section class="page-title">
        <h1>Women's T-Shirts</h1>
        <p>Premium quality for every style</p>
    </section>
    <!-- Product Grid (Same as Holiday Offers layout) -->
   <!-- Replace the static product cards with this PHP code -->
<section class="product-showcase">
    <div class="product-container">
        <?php
        require_once 'db.php';
        $conn = get_db_connection();
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Fetch men's products
        $sql = "SELECT * FROM women WHERE category='women'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
    echo '<div class="product-card">';
    echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
    echo '<p>' . htmlspecialchars($row['name']) . '</p>';
    echo '<p>Reviews (' . $row['reviews'] . ')</p>';
    echo '<h3 class="old-price">was ksh ' . $row['old_price'] . '</h3>';
    echo '<h3 class="new-price">Now Ksh ' . htmlspecialchars($row['new_price']) . '</h3>';
    echo '<h4 class="discount-tag">' . htmlspecialchars($row['discount']) . '</h4>';
    echo '<form action="men_add_to_cart.php" method="post">';
    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
    echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row['name']) . '">';
    echo '<input type="hidden" name="product_price" value="' . $row['new_price'] . '">';
    echo '<input type="hidden" name="product_image" value="' . htmlspecialchars($row['image_url']) . '">';
    echo '<button type="submit" class="cart-btn">Add to Cart</button>';
    echo '</form>';
    echo '</div>';
}
        } else {
            echo '<p>No products found</p>';
        }
        
        $conn->close();
        ?>
    </div>
</section>
    </section>

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