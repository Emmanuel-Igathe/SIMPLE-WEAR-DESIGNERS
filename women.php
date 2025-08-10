<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Collection | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="women.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>SIMPLE WEAR DESIGNERS</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
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
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'simple wear');
        
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
                <div class="footer-section">
                    <h3>Follow us</h3>
                    <ul class="social-links">
                        <li><a href="https://web.whatsapp.com/" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ75KzcZJMW7mC6vsA8vNOzkAc5AwfOWzN6U6UzC5MhSgeSpAaEvZIddWj6CS3lkgKAQc&usqp=CAU"></a></li>
                        <li><a href="https://www.facebook.com/login.php/" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTdoxHpvBb2ovxPTGhqtTBdOwGWvZGeJKi7FnJNTdqHSOoxkqfDctqzX29jCKb8Nep7S0o&usqp=CAU"></a></li>
                        <li><a href="https://www.instagram.com/accounts/login/?hl=en" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTl09hYX3OxCeDnNWkJ00uNvI60MXuvsUuiB2yJ12RBCKA5cXNIn9YP7AlhmUvAnPsOLh0&usqp=CAU"></a></li>
                        <li><a href="https://twitter.com/login" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSg43G1RrHVBJF3GtS_K8HpFs3k4Hc1_q0LN0rQnMJuDg5_-P2B0sj2vFKqF6UnNr9gluo&usqp=CAU"></a></li>
                        <li><a href="https://www.tiktok.com/en/" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTohyGdQMRpi0_pVjKb9HPxZz8OcucFNPJOXEPJ8WxFzq7V6y9ev__Br1xfVsQcR4-ZMIs&usqp=CAU"></a></li>
                        <li><a href="https://www.linkedin.com/login" target="_blank"><img id="social-logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReariTqhVj4v-OJb_8Q_hKb54qsZ1NOGc5b3LneT43VXUW_1bG6Ajk3NPRRfR0VW8JQEQ&usqp=CAU"></a></li>
                    </ul>
                </div>
            </div>
                <div class="footer-section">
                    <h4>Contact Us</h4>
                    <ul class="Contact-info">
                        <li><i class="fas fa-envelope"></i><a href="mailto:emmanueligathe4@gmail.com">simplewear@gmail.com</a></li>
                        <li><i class="fas fa-phone"></i><a href="tel: +254713078800">+25413078800</a></li>
                        <li><i class="fas fa-map-marker-alt"></i>River Road , Nairobi, Kenya</li>
                    </ul>            
                </div>
                <!--Quick links-->
                <div class="footer-section">
                    <h3>QuickLinks</h3>
                    <ul class="quick-links">
                        <li><a href="home.php">HOME</a></li>
                        <li><a href="men.php">MEN</a></li>
                        <li><a href="women.php">WOMEN</a></li>
                        <li><a href="about.php">ABOUT US</a></li>

                    </ul>

                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy;2025 <strong>SIMPLE WEARS DESIGNERS</strong>.All Rights Reserved.</p>
            </div>
        </footer>
</body>
</html>