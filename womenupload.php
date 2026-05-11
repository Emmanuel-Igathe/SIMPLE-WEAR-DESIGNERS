<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple-wear";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of all 8 women's products to insert
$products = [
    [
        'name' => 'Ladies top tees',
        'description' => 'Stylish ladies top t-shirts',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/58/043766/1.jpg?7709',
        'old_price' => 1398,
        'new_price' => '899',
        'discount' => '-36%',
        'reviews' => 78
    ],
    [
        'name' => 'Graphic Cute Tees',
        'description' => 'Cute graphic print t-shirts',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/97/4145962/1.jpg?0198',
        'old_price' => 535,
        'new_price' => '390',
        'discount' => '-27%',
        'reviews' => 64
    ],
    [
        'name' => 'BLWOENS Cute fit shirts',
        'description' => 'Comfortable cute fit shirts',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/89/4145962/1.jpg?0196',
        'old_price' => 535,
        'new_price' => '390',
        'discount' => '-27%',
        'reviews' => 64
    ],
    [
        'name' => 'Top round neck',
        'description' => 'Classic round neck tops',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/41/3861232/1.jpg?6872',
        'old_price' => 904,
        'new_price' => '904', // No discount price shown in original
        'discount' => '0%',
        'reviews' => 64
    ],
    [
        'name' => 'PCS ladies tops',
        'description' => 'Premium PCS brand tops',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/06/9363271/1.jpg?0112',
        'old_price' => 1398,
        'new_price' => '899',
        'discount' => '-36%',
        'reviews' => 64
    ],
    [
        'name' => 'Casual short sleeve',
        'description' => 'Casual short sleeve tops',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/43/0379662/1.jpg?8140',
        'old_price' => 1000,
        'new_price' => '610',
        'discount' => '-25%',
        'reviews' => 64
    ],
    [
        'name' => 'Yixin 3 pieces',
        'description' => 'Yixin brand 3-piece set',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/78/9532291/1.jpg?0553',
        'old_price' => 1340,
        'new_price' => '1059',
        'discount' => '-21%',
        'reviews' => 64
    ],
    [
        'name' => 'Summer shirt',
        'description' => 'Lightweight summer shirts',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/37/7011562/1.jpg?1388',
        'old_price' => 535,
        'new_price' => '377 - 390',
        'discount' => '-34%',
        'reviews' => 64
    ]
];

// Insert each product
foreach ($products as $product) {
    $sql = "INSERT INTO women (name, description, image_url, old_price, new_price, discount, reviews, category)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'women')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdssi", 
        $product['name'],
        $product['description'],
        $product['image_url'],
        $product['old_price'],
        $product['new_price'],
        $product['discount'],
        $product['reviews']
    );
    
    if ($stmt->execute()) {
        echo "Product '{$product['name']}' inserted successfully.<br>";
    } else {
        echo "Error inserting product: " . $stmt->error . "<br>";
    }
    
    $stmt->close();
}

$conn->close();
?>