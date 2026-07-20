<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Collection | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="men.css">
    <style>
        /* ===== Color & Size Selector Styles ===== */
        .product-card { position: relative; overflow: visible; }
        .product-img-wrap { position: relative; overflow: hidden; border-radius: 10px; }
        .product-img-wrap img { width: 100%; height: 260px; object-fit: cover; transition: transform 0.4s ease; }
        .product-card:hover .product-img-wrap img { transform: scale(1.04); }

        .color-options {
            display: flex;
            gap: 8px;
            margin: 10px 0 6px;
            flex-wrap: wrap;
            align-items: center;
        }
        .color-options span { font-size: 12px; color: #777; font-weight: 600; margin-right: 2px; }
        .color-swatch {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s;
            position: relative;
        }
        .color-swatch:hover { transform: scale(1.2); }
        .color-swatch.active { border-color: #ff6b6b; transform: scale(1.15); box-shadow: 0 0 0 2px #ff6b6b44; }

        .size-options {
            display: flex;
            gap: 6px;
            margin: 6px 0 10px;
            flex-wrap: wrap;
            align-items: center;
        }
        .size-options span { font-size: 12px; color: #777; font-weight: 600; margin-right: 2px; }
        .size-btn {
            padding: 4px 10px;
            border: 1.5px solid #ddd;
            border-radius: 5px;
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            color: #333;
        }
        .size-btn:hover { border-color: #ff6b6b; color: #ff6b6b; }
        .size-btn.active { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }

        .selected-variant-label {
            font-size: 11px;
            color: #888;
            margin-bottom: 4px;
            min-height: 16px;
        }
    </style>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a class="nav-link" href="profile.php">PROFILE</a></li>
                    <li><a class="nav-link" href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a class="nav-link" href="login.php">LOGIN</a></li>
                <?php endif; ?>
                <li><a href="cart.php" class="nav-link nav-cart">
                    <i class="fas fa-shopping-cart"></i> 
                    (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Page Title -->
    <section class="page-title">
        <h1>Men's T-Shirts</h1>
        <p>Premium quality for every style</p>
    </section>

<?php
// Color variants per product name — curated from public Jumia/Shein image CDNs
$color_variants = [
    'Blue Fashion T-Shirt' => [
        ['color' => '#1565C0', 'label' => 'Blue',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/5937762/1.jpg?0498'],
        ['color' => '#212121', 'label' => 'Black', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/5937762/2.jpg?0498'],
        ['color' => '#FFFFFF', 'label' => 'White', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/5937762/3.jpg?0498'],
        ['color' => '#B71C1C', 'label' => 'Red',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/5937762/4.jpg?0498'],
    ],
    'Trendy Multi sleeve' => [
        ['color' => '#4A235A', 'label' => 'Purple', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/2942992/1.jpg?3427'],
        ['color' => '#1B5E20', 'label' => 'Green',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/2942992/2.jpg?3427'],
        ['color' => '#212121', 'label' => 'Black',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/2942992/3.jpg?3427'],
        ['color' => '#0D47A1', 'label' => 'Navy',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/2942992/4.jpg?3427'],
    ],
    'Sweatshirts' => [
        ['color' => '#37474F', 'label' => 'Grey',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/2942992/1.jpg?6269'],
        ['color' => '#212121', 'label' => 'Black', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/2942992/2.jpg?6269'],
        ['color' => '#FFFFFF', 'label' => 'White', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/2942992/3.jpg?6269'],
        ['color' => '#1565C0', 'label' => 'Blue',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/2942992/4.jpg?6269'],
    ],
    'Thick skull' => [
        ['color' => '#212121', 'label' => 'Black', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/68/4572303/1.jpg?8345'],
        ['color' => '#FFFFFF', 'label' => 'White', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/68/4572303/2.jpg?8345'],
        ['color' => '#B71C1C', 'label' => 'Red',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/68/4572303/3.jpg?8345'],
        ['color' => '#37474F', 'label' => 'Grey',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/68/4572303/4.jpg?8345'],
    ],
    'Duo-color Jesus' => [
        ['color' => '#ECEFF1', 'label' => 'White',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/77/4572303/1.jpg?8346'],
        ['color' => '#212121', 'label' => 'Black',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/77/4572303/2.jpg?8346'],
        ['color' => '#1565C0', 'label' => 'Blue',    'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/77/4572303/3.jpg?8346'],
        ['color' => '#B71C1C', 'label' => 'Red',     'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/77/4572303/4.jpg?8346'],
    ],
    'Duo-color Thick bear' => [
        ['color' => '#546E7A', 'label' => 'Slate',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/52/6382303/1.jpg?0684'],
        ['color' => '#212121', 'label' => 'Black',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/52/6382303/2.jpg?0684'],
        ['color' => '#FFFFFF', 'label' => 'White',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/52/6382303/3.jpg?0684'],
        ['color' => '#4A235A', 'label' => 'Purple', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/52/6382303/4.jpg?0684'],
    ],
    'Vintage African Traditional short sleeve' => [
        ['color' => '#E65100', 'label' => 'Orange', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/71/9680892/1.jpg?3563'],
        ['color' => '#1B5E20', 'label' => 'Green',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/71/9680892/2.jpg?3563'],
        ['color' => '#B71C1C', 'label' => 'Red',    'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/71/9680892/3.jpg?3563'],
        ['color' => '#37474F', 'label' => 'Grey',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/71/9680892/4.jpg?3563'],
    ],
    "Patriot's Shirt" => [
        ['color' => '#FFFFFF', 'label' => 'White', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/43/6382303/1.jpg?5246'],
        ['color' => '#212121', 'label' => 'Black', 'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/43/6382303/2.jpg?5246'],
        ['color' => '#B71C1C', 'label' => 'Red',   'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/43/6382303/3.jpg?5246'],
        ['color' => '#0D47A1', 'label' => 'Navy',  'img' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/43/6382303/4.jpg?5246'],
    ],
];

$sizes = ['S', 'M', 'L', 'XL', 'XXL'];
?>

<section class="product-showcase">
    <div class="product-container">
        <?php
        require_once 'db.php';
        $conn = get_db_connection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM men WHERE category='men'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name    = htmlspecialchars($row['name']);
                $rawName = $row['name'];
                $id      = $row['id'];
                $img     = htmlspecialchars($row['image_url']);
                $variants = $color_variants[$rawName] ?? [];
                $firstImg = !empty($variants) ? htmlspecialchars($variants[0]['img']) : $img;
                $variantsJson = htmlspecialchars(json_encode($variants), ENT_QUOTES);
        ?>
        <div class="product-card" id="card-men-<?= $id ?>">
            <div class="product-img-wrap">
                <img id="img-men-<?= $id ?>" src="<?= $firstImg ?>" alt="<?= $name ?>">
            </div>
            <p class="product-name"><?= $name ?></p>
            <p class="product-reviews"><i class="fas fa-star" style="color:#f4b942;"></i> Reviews (<?= $row['reviews'] ?>)</p>
            <h3 class="old-price">was Ksh <?= $row['old_price'] ?></h3>
            <h3 class="new-price">Now Ksh <?= htmlspecialchars($row['new_price']) ?></h3>
            <h4 class="discount-tag"><?= htmlspecialchars($row['discount']) ?></h4>

            <?php if (!empty($variants)): ?>
            <!-- Color Swatches -->
            <div class="color-options">
                <span>Color:</span>
                <?php foreach ($variants as $i => $v): ?>
                <div class="color-swatch <?= $i === 0 ? 'active' : '' ?>"
                     style="background:<?= $v['color'] ?>; border-color:<?= $v['color'] === '#FFFFFF' ? '#ccc' : $v['color'] ?>;"
                     title="<?= $v['label'] ?>"
                     onclick="selectColor(this, 'label-men-<?= $id ?>', '<?= $v['label'] ?>', 'color-men-<?= $id ?>')">
                </div>
                <?php endforeach; ?>
            </div>
            <p class="selected-variant-label" id="label-men-<?= $id ?>">Color: <?= $variants[0]['label'] ?></p>
            <?php endif; ?>

            <!-- Size Selector -->
            <div class="size-options">
                <span>Size:</span>
                <?php foreach ($sizes as $s): ?>
                <button type="button" class="size-btn <?= $s === 'M' ? 'active' : '' ?>"
                        onclick="selectSize(this, 'size-men-<?= $id ?>')"><?= $s ?></button>
                <?php endforeach; ?>
            </div>

            <!-- Add to Cart Form -->
            <form action="men_add_to_cart.php" method="post">
                <input type="hidden" name="product_id"    value="<?= $id ?>">
                <input type="hidden" name="product_name"  value="<?= $name ?>">
                <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['new_price']) ?>">
                <input type="hidden" name="product_image" value="<?= $img ?>">
                <input type="hidden" name="product_color" id="color-men-<?= $id ?>" value="<?= !empty($variants) ? htmlspecialchars($variants[0]['label']) : '' ?>">
                <input type="hidden" name="product_size"  id="size-men-<?= $id ?>" value="M">
                <button type="submit" class="cart-btn"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>
        <?php
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
            <p>&copy; <?= date('Y') ?> <strong>Simple Wear Designers</strong>. All Rights Reserved. | Made with <span style="color:#ff6b6b;">&#10084;</span> in Nairobi</p>
        </div>
    </footer>

    <script>
        function selectColor(swatchEl, labelId, colorLabel, colorInputId) {
            swatchEl.closest('.color-options').querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
            swatchEl.classList.add('active');
            document.getElementById(labelId).textContent = 'Color: ' + colorLabel;
            document.getElementById(colorInputId).value = colorLabel;
        }

        function selectSize(btn, sizeInputId) {
            btn.closest('.size-options').querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(sizeInputId).value = btn.textContent;
        }
    </script>
</body>
</html>