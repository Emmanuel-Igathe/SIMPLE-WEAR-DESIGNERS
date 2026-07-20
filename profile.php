<?php
session_start();
require_once 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = get_pdo_connection();
$msg = '';
$error = '';

// Handle Delete Account
if (isset($_POST['delete_account'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM registration WHERE id = ?");
        $stmt->execute([$user_id]);
        session_destroy();
        header("Location: registration.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        $error = "Error deleting account.";
    }
}

// Handle Update Profile
if (isset($_POST['update_profile'])) {
    $firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
    $lastName = htmlspecialchars(trim($_POST['lastName'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $city = htmlspecialchars(trim($_POST['city'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($email) || empty($city)) {
        $error = "All fields except password are required.";
    } else {
        try {
            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $error = "Password must be at least 8 characters.";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE registration SET firstName=?, lastName=?, email=?, city=?, password=? WHERE id=?");
                    $stmt->execute([$firstName, $lastName, $email, $city, $passwordHash, $user_id]);
                    $msg = "Profile updated successfully!";
                    $_SESSION['user_name'] = $firstName . ' ' . $lastName;
                }
            } else {
                $stmt = $conn->prepare("UPDATE registration SET firstName=?, lastName=?, email=?, city=? WHERE id=?");
                $stmt->execute([$firstName, $lastName, $email, $city, $user_id]);
                $msg = "Profile updated successfully!";
                $_SESSION['user_name'] = $firstName . ' ' . $lastName;
            }
        } catch (PDOException $e) {
            $error = "Error updating profile. Email might already exist.";
        }
    }
}

// Fetch User Details
$stmt = $conn->prepare("SELECT firstName, lastName, email, city FROM registration WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch User Orders
$stmtOrders = $conn->prepare("SELECT id, order_reference, total_amount, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmtOrders->execute([$user_id]);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Simple Wear</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <a href="home.php" class="header-title" style="text-decoration:none; color:#1a1a2e; font-size:1.5rem; font-weight:800;">SIMPLE WEAR</a>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="profile.php" class="active">PROFILE</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</a></li>
            </ul>
        </nav>
    </header>

    <div class="profile-container">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'order_success'): ?>
            <div class="alert alert-success">Your order was successfully placed!</div>
        <?php endif; ?>
        <?php if ($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <div class="profile-grid">
            <!-- Edit Profile Section -->
            <div class="profile-card">
                <h2><i class="fas fa-user-edit"></i> Edit My Details</h2>
                <form method="POST" action="profile.php" class="profile-form">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastName" value="<?= htmlspecialchars($user['lastName']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>New Password <small>(leave blank to keep current)</small></label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>

                <div class="danger-zone">
                    <h3>Danger Zone</h3>
                    <form method="POST" action="profile.php" onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.');">
                        <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
                    </form>
                </div>
            </div>

            <!-- Order History Section -->
            <div class="profile-card">
                <h2><i class="fas fa-shopping-bag"></i> My Purchases</h2>
                <?php if (count($orders) > 0): ?>
                    <div class="order-list">
                        <?php foreach ($orders as $order): ?>
                            <div class="order-item">
                                <div class="order-header">
                                    <span class="order-ref"><?= htmlspecialchars($order['order_reference']) ?></span>
                                    <span class="order-status status-<?= strtolower($order['status']) ?>"><?= ucfirst(htmlspecialchars($order['status'])) ?></span>
                                </div>
                                <div class="order-details">
                                    <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>
                                    <p><strong>Total:</strong> Ksh <?= number_format($order['total_amount'], 2) ?></p>
                                </div>
                                
                                <?php
                                // Fetch items for this order
                                $stmtItems = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
                                $stmtItems->execute([$order['id']]);
                                $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php if (count($items) > 0): ?>
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>Ksh <?= number_format($item['price'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>You haven't made any purchases yet.</p>
                        <a href="home.php" class="btn btn-secondary">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
