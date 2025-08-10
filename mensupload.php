<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple wear";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of all 8 products to insert
$products = [
    [
        'name' => 'Blue Fashion T-Shirt',
        'description' => 'Premium quality blue t-shirt',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/5937762/1.jpg?0498',
        'old_price' => 850,
        'new_price' => '700',
        'discount' => '-20%',
        'reviews' => 78
    ],
    [
        'name' => 'Trendy Multi sleeve',
        'description' => 'Stylish multi-sleeve design',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/30/2942992/1.jpg?3427',
        'old_price' => 750,
        'new_price' => '600',
        'discount' => '-25%',
        'reviews' => 64
    ],
    [
        'name' => 'Sweatshirts',
        'description' => 'Comfortable sweatshirts',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/2942992/1.jpg?6269',
        'old_price' => 1000,
        'new_price' => '660',
        'discount' => '-34%',
        'reviews' => 64
    ],
    [
        'name' => 'Thick skull',
        'description' => 'Thick skull graphic t-shirt',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/68/4572303/1.jpg?8345',
        'old_price' => 704,
        'new_price' => '421',
        'discount' => '-46%',
        'reviews' => 64
    ],
    [
        'name' => 'Duo-color Jesus',
        'description' => 'Jesus graphic duo-color t-shirt',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/77/4572303/1.jpg?8346',
        'old_price' => 704,
        'new_price' => '320',
        'discount' => '-59%',
        'reviews' => 64
    ],
    [
        'name' => 'Duo-color Thick bear',
        'description' => 'Bear graphic duo-color t-shirt',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/52/6382303/1.jpg?0684',
        'old_price' => 750,
        'new_price' => '446 - 489',
        'discount' => '-25%',
        'reviews' => 64
    ],
    [
        'name' => 'Vintage African Traditional short sleeve',
        'description' => 'Vintage African print short sleeve',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/71/9680892/1.jpg?3563',
        'old_price' => 1000,
        'new_price' => '660',
        'discount' => '-34%',
        'reviews' => 64
    ],
    [
        'name' => 'Patriot\'s Shirt',
        'description' => 'Patriotic graphic t-shirt',
        'image_url' => 'https://ke.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/43/6382303/1.jpg?5246',
        'old_price' => 704,
        'new_price' => '513',
        'discount' => '-35%',
        'reviews' => 64
    ]
];

// Insert each product
foreach ($products as $product) {
    $sql = "INSERT INTO men (name, description, image_url, old_price, new_price, discount, reviews, category)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'men')";
    
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