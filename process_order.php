<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Save cart data or just redirect
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $userId = $_SESSION['user_id'];
    $customerName = htmlspecialchars(trim($_POST['customer_name'] ?? ''));
    $phoneNumber = htmlspecialchars(trim($_POST['phone_number'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $totalAmount = floatval($_POST['total_amount'] ?? 0);
    $orderRef = trim($_POST['order_id'] ?? ('ORD-' . uniqid()));

    if ($totalAmount <= 0 || empty($phoneNumber) || empty($_SESSION['cart'])) {
        die("Invalid order details. <a href='cart.php'>Go back</a>");
    }

    try {
        $conn = get_pdo_connection();
        
        // 1. Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, order_reference, total_amount, status) VALUES (?, ?, ?, 'pending')");
        $stmt->execute([$userId, $orderRef, $totalAmount]);
        $orderId = $conn->lastInsertId();

        // 2. Insert into order_items table
        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($_SESSION['cart'] as $item) {
            $stmtItem->execute([
                $orderId,
                $item['name'],
                $item['quantity'],
                $item['price']
            ]);
        }

        // 3. Set session data for PayHero processing
        $_SESSION['checkout_data'] = [
            'order_id' => $orderRef,
            'total_amount' => $totalAmount,
            'phone_number' => $phoneNumber,
            'customer_name' => $customerName,
            'email' => $email
        ];

        // 4. Clear cart
        unset($_SESSION['cart']);

        // 5. Redirect to processing page (or a success page for now since API might not be configured)
        // Ideally we would redirect to a waiting page that calls process_payhero.php via JS.
        // For simplicity, we'll mark as completed and redirect to profile.
        
        $stmtUpdate = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
        $stmtUpdate->execute([$orderId]);

        header("Location: profile.php?msg=order_success");
        exit();

    } catch (PDOException $e) {
        die("Error processing order: " . $e->getMessage());
    }
} else {
    header("Location: cart.php");
    exit();
}
?>
