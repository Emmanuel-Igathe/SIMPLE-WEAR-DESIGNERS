<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id    = $_POST['product_id'];
    $product_name  = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_size  = htmlspecialchars(trim($_POST['product_size'] ?? 'M'));
    
    // Composite key so same product in different size = separate cart entry
    $cart_key = $product_id . '_' . $product_size;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'id'        => $product_id,
            'name'      => $product_name . ' (' . $product_size . ')',
            'price'     => $product_price,
            'image_url' => $product_image,
            'quantity'  => 1,
            'size'      => $product_size,
        ];
    }
    
    // Redirect back to the product page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>