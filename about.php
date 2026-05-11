<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Simple Wear</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <li><a class="nav-link active" href="about.php">ABOUT US</a></li>
                <li><a href="cart.php" class="nav-link nav-cart">
                    <i class="fas fa-shopping-cart"></i> 
                    (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <main class="about-container">
        <!-- Hero Section -->
        <section class="about-hero">
            <h1>Our Story</h1>
            <p>Quality fashion for everyone since 2020</p>
        </section>

        <!-- About Content -->
        <section class="about-content">
            <div class="about-text">
                <h2>Welcome to Simple Wear</h2>
                <p>Founded in Nairobi, Simple Wear has been providing high-quality, affordable fashion to Kenyans for over 3 years. We specialize in trendy yet comfortable t-shirts for both men and women.</p>
                
                <p>Our mission is to make fashion accessible without compromising on quality. Every piece in our collection is carefully selected to ensure durability, comfort, and style.</p>
            </div>

            <div class="contact-info">
                <h2>Contact Us</h2>
                <div class="contact-method">
                    <i class="fas fa-phone"></i>
                    <p>0713 078800 / 0713 452905</p>
                </div>
                <div class="contact-method">
                    <i class="fas fa-envelope"></i>
                    <p><a href="mailto:emmanueligathe4@gmail.com">simplewear@gmail.com</a></p>
                </div>
                <div class="contact-method">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>River Road, Nairobi, Kenya</p>
                </div>
            </div>
        </section>

        <!-- Google Map -->
        <section class="location-map">
            <h2>Our Location</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.808477395489!2d36.82679731526195!3d-1.286417835980925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d664d95aab%3A0x20d68a1c9a4a0c5e!2sRiver%20Road%2C%20Nairobi!5e0!3m2!1sen!2ske!4v1620000000000!5m2!1sen!2ske" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-container">
                <!-- FAQ 1 -->
                <div class="faq-item">
                    <button class="faq-question">
                        How often do you offer discounts?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We offer seasonal discounts 4 times a year (January, April, August, and November). Additionally, we have flash sales occasionally which are announced on our social media pages.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item">
                    <button class="faq-question">
                        What payment methods do you accept?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We accept M-Pesa, credit/debit cards (Visa, Mastercard), and cash on delivery within Nairobi.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item">
                    <button class="faq-question">
                        How long does delivery take?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Nairobi deliveries take 1-2 business days. Other major towns take 3-5 business days. Rural areas may take up to 7 business days.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item">
                    <button class="faq-question">
                        What's your return policy?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We accept returns within 7 days of purchase if the item is unworn, unwashed, and with original tags. The customer covers return shipping costs.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item">
                    <button class="faq-question">
                        Do you offer custom designs?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Yes! We accept custom design orders for bulk purchases (minimum 10 pieces). Contact us via WhatsApp or email to discuss your design.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Simple Wear. All rights reserved.</p>
    </footer>

    <script src="about.js"></script>
</body>
</html>