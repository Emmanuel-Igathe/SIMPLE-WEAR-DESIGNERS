<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css"/>
</head>
<body>
    <header>
        <div class="logo-title">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFsgfUjcl2hqmWVpsW1xG8KbxRn40XU2IY-5aInmZTexf1ztNBIZPcRpj8HV7tkPKVdBs&usqp=CAU" alt="simplewear logo" class="logo">
            <h1>SIMPLE WEAR</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a class="nav-link" href="home.php">HOME</a></li>
                <li><a class="nav-link" href="men.php">MEN</a></li>
                <li><a class="nav-link" href="women.php">WOMEN</a></li>
                <li><a class="nav-link" href="about.php">ABOUT US</a></li> 
                <li><a class="nav-link" href="login.php">LOGIN</a></li>
                <li><a href="cart.php" class="nav-link nav-cart">
                    <i class="fas fa-shopping-cart"></i> 
                    CART (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>
    <section class="category-banners">
        <div class="banner-container">
            <a href="men.php" class="category-banner"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmNaMPPwwBPedMjEy6bjcIqEo0eTKw5NHBBrpWIT-903OAK-hg76VoDr9zi5AmtlyBmpQ&usqp=CAU" alt="Mens collection" class="category-img">
                <div class="banner-text">
                  <h2>Men's T-shirts</h2>
            <span>Shop Now</span>
                </div>
    </a>
    <a href="women.php" class="category-banner">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL0sT1c3piAn9gb-FxTmmp5RWWpmBPXnt0rjSM0VrQMOPICW2xFWaHq6Lm2q76lp4NTxc&usqp=CAU" alt="Women's collection" class="category-img">
            <div class="banner-text">
            <h2>Women's T-shirts</h2> 
            <span>Shop Now</span>          
        </div>
    </a>
    </section>
    <section class="offers">
        <h2>Holiday Offers</h2>
        <div class="offer-container">

            <!-- Product 1: Sword T-shirt -->
            <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgH0SeihXmU_vWSmkqXoezWajwqzsqaiijRrHgpWMsLkATk7-QcXvNrQzYAGjc4Jb7gJg&usqp=CAU">
                <p>Sword T-shirt</p>
                <p>Reviews 78</p>
                <h3 id="previous-prize"> was ksh 750</h3>
                <h3>Now Ksh 700</h3>
                <h4>-20%</h4>
                <form action="men_add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="home_1">
                    <input type="hidden" name="product_name" value="Sword T-shirt">
                    <input type="hidden" name="product_price" value="700">
                    <input type="hidden" name="product_image" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgH0SeihXmU_vWSmkqXoezWajwqzsqaiijRrHgpWMsLkATk7-QcXvNrQzYAGjc4Jb7gJg&usqp=CAU">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>

            <!-- Product 2: Production T-shirt -->
            <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcDzCTmwpr_IrG0rUqFtDgaiWYcqObCaMwkXJzscBIkYsooypZ2oPYEIVpvmnx9kPjyLE&usqp=CAU">
                <p>Production T-shirt</p>
                <p>Reviews 78</p>
                <h3 id="previous-prize"> was ksh 550</h3>
                <h3>Now Ksh 400</h3>
                <h4>-20%</h4>
                <form action="men_add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="home_2">
                    <input type="hidden" name="product_name" value="Production T-shirt">
                    <input type="hidden" name="product_price" value="400">
                    <input type="hidden" name="product_image" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcDzCTmwpr_IrG0rUqFtDgaiWYcqObCaMwkXJzscBIkYsooypZ2oPYEIVpvmnx9kPjyLE&usqp=CAU">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>

            <!-- Product 3: Modern T-shirts -->
            <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSNWAydRECaKNjv75X6beOyFc1NCl9EN8uajhKoE4tzJqv8rl_4nSGsPhY5ZIJ8VgfATQ&usqp=CAU">
                <p>Modern T-shirts</p>
                <p>Reviews 132</p>
                <h3 id="previous-prize">was ksh 2000</h3>
                <h3>Now ksh 1500</h3>
                <h4>-25%</h4>
                <form action="men_add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="home_3">
                    <input type="hidden" name="product_name" value="Modern T-shirts">
                    <input type="hidden" name="product_price" value="1500">
                    <input type="hidden" name="product_image" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSNWAydRECaKNjv75X6beOyFc1NCl9EN8uajhKoE4tzJqv8rl_4nSGsPhY5ZIJ8VgfATQ&usqp=CAU">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>

            <!-- Product 4: BUBUSHIBO T-shirts -->
            <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRq1zlThGrgKbsx2-Cc3-5Ll1FLdC0CAulSC6CSOkOFsnpWyIMHvO8Nwjuc09lcUA-GRsw&usqp=CAU">
                <p>BUBUSHIBO T-shirts</p>
                <p>Reviews 200</p>
                <h3 id="previous-prize">was ksh 1800</h3>
                <h3>Now ksh 1200</h3>
                <h4>-30%</h4>
                <form action="men_add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="home_4">
                    <input type="hidden" name="product_name" value="BUBUSHIBO T-shirts">
                    <input type="hidden" name="product_price" value="1200">
                    <input type="hidden" name="product_image" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRq1zlThGrgKbsx2-Cc3-5Ll1FLdC0CAulSC6CSOkOFsnpWyIMHvO8Nwjuc09lcUA-GRsw&usqp=CAU">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>

        </div>
    </section>
        <!--Animation-->
        <section class="animated-showcase">
            <h2>Featured T-shirts</h2>
            <div class="slider-container">
                <div class="slider-track" id="slider-track">
                    
                </div>                
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="script.js"></script>
</body>
</html>