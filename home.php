<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="home.css"/>
</head>
<body>
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
        <div class="offer-container"><!--Offer container to allow side by side placement-->
         <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgH0SeihXmU_vWSmkqXoezWajwqzsqaiijRrHgpWMsLkATk7-QcXvNrQzYAGjc4Jb7gJg&usqp=CAU">
                <p>Sword T-shirt</p>
                <p>Reviews 78</p>
                <h3 id="previous-prize"> was ksh 750</h3>
                <h3>Now Ksh 700</h3>
                <h4>-20%</h4>
                <!--Add to cart button-->
                <a href="cart.php" class="add-to-cart-btn">Add to Cart</a>                                  
            </div>
            <div class="offerproduct">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcDzCTmwpr_IrG0rUqFtDgaiWYcqObCaMwkXJzscBIkYsooypZ2oPYEIVpvmnx9kPjyLE&usqp=CAU">
                <p>Production T-shirt</p>
                <p>Reviews 78</p>
                <h3 id="previous-prize"> was ksh 550</h3>
                <h3>Now Ksh 400</h3>
                <h4>-20%</h4> 
                <!--Add to cart button-->
                <a href="cart.php" class="add-to-cart-btn">Add to Cart</a>                                 
            </div>
                <div class="offerproduct">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSNWAydRECaKNjv75X6beOyFc1NCl9EN8uajhKoE4tzJqv8rl_4nSGsPhY5ZIJ8VgfATQ&usqp=CAU">
                    <p>Modern T-shirts</p>
                    <p>Reviews 132</p>
                    <h3 id="previous-prize">was ksh 2000</h3>
                    <h3>Now ksh 1500</h3>
                    <h4>-25%</h4>
                    <a href="cart.php" class="add-to-cart-btn">Add to cart</a>
                </div>
                <div>
                    <div class="offerproduct">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRq1zlThGrgKbsx2-Cc3-5Ll1FLdC0CAulSC6CSOkOFsnpWyIMHvO8Nwjuc09lcUA-GRsw&usqp=CAU">
                        <p>BUBUSHIBO T-shirts</p>
                        <p>Reviews 200</p>
                        <h3 id="previous-prize">was ksh 1800</h3>
                        <h3>Now ksh 1200</h3>
                        <h4>-30%</h4>
                        <a href="cart.php" class="add-to-cart-btn">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
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
        <script src="script.js"></script>
</body>
</html>