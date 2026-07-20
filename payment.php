<?php
session_start();

// Check if checkout data exists
if (!isset($_SESSION['checkout_data'])) {
    header("Location: cart.php");
    exit();
}

// Get data from session
$paymentData = $_SESSION['checkout_data'];
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Simple Wear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
    <style>
        /* Additional Styles */
        .payment-method-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .payment-method-card:hover {
            border-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.2);
        }
        .payment-method-card.active {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
        #loader {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            display: none;
        }
        #loader .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .countdown {
            font-size: 1.2rem;
            font-weight: bold;
            color: #dc3545;
            margin-top: 10px;
        }
        .back-to-cart {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- Header - Same as cart.php -->
    <header>
        <h1>SIMPLE WEAR DESIGNERS</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> (<?= $cart_count ?>)</a></li>
            </ul>
        </nav>
    </header>

    <div class="container py-5">
        <div class="payment-form">
            <div class="form-header">
                <h2>Complete Your Payment</h2>
                <p class="text-muted">Order Total: Ksh <?= number_format($paymentData['total_amount'], 2) ?></p>
            </div>
            
            <form id="paymentForm" class="needs-validation" novalidate>
                <div class="row g-4">
                    <!-- Pre-filled Readonly Fields -->
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="customerName" 
                                   value="<?= htmlspecialchars($paymentData['customer_name']) ?>" readonly>
                            <label for="customerName"><i class="bi bi-person-fill"></i> Customer Name</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phoneNumber" 
                                   value="<?= htmlspecialchars($paymentData['phone_number']) ?>" readonly>
                            <label for="phoneNumber"><i class="bi bi-phone-fill"></i> Phone Number</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="amount" 
                                   value="<?= htmlspecialchars($paymentData['total_amount']) ?>" readonly>
                            <label for="amount"><i class="bi bi-cash"></i> Amount (KES)</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="reference" 
                                   value="<?= htmlspecialchars($paymentData['order_id']) ?>" readonly>
                            <label for="reference"><i class="bi bi-hash"></i> Order Reference</label>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="col-12">
                        <h5>Select Payment Method:</h5>
                        
                        <div class="payment-method-card active" data-method="mpesa" onclick="selectPaymentMethod('mpesa')">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="mpesa" value="mpesa" checked>
                                <label class="form-check-label fw-bold" for="mpesa">
                                    <i class="bi bi-phone"></i> M-Pesa (via PayHero)
                                </label>
                            </div>
                            <p class="text-muted mt-2">You'll receive an STK Push on your phone to complete payment</p>
                        </div>
                        
                        <div class="payment-method-card" data-method="card" onclick="selectPaymentMethod('card')">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="card" value="card">
                                <label class="form-check-label fw-bold" for="card">
                                    <i class="bi bi-credit-card"></i> Credit/Debit Card
                                </label>
                            </div>
                            <p class="text-muted mt-2">Secure payment via cards (Visa, Mastercard, etc.)</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg position-relative" id="submitBtn">
                                <i class="bi bi-credit-card-fill me-2"></i>
                                Confirm Payment (KES <?= number_format($paymentData['total_amount'], 2) ?>)
                            </button>
                            <a href="cart.php" class="btn btn-outline-secondary back-to-cart">
                                <i class="bi bi-arrow-left me-2"></i> Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            
            <div id="loader">
                <div class="spinner"></div>
                <p class="mt-3">Processing payment...</p>
                <div class="countdown" id="countdown">Time remaining: 2:00</div>
            </div>
            
            <div class="payment-status" id="paymentStatus"></div>
        </div>
    </div>

    <!-- Footer - Same as cart.php -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Follow Us</h3>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-tiktok"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-envelope"></i> <a href="mailto:simplewear@gmail.com">simplewear@gmail.com</a></li>
                    <li><i class="fas fa-phone"></i> <a href="tel:+254713078800">0713 078800</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> River Road, Nairobi, Kenya</li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="quick-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="men.php">Men</a></li>
                    <li><a href="women.php">Women</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="cart.php">Your Cart</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <strong>SIMPLE WEAR DESIGNERS</strong>.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    
    <script>
    // Select payment method with visual feedback
    function selectPaymentMethod(method) {
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('active');
        });
        document.querySelector(`.payment-method-card[data-method="${method}"]`).classList.add('active');
        document.getElementById(method).checked = true;
    }

    // Countdown timer
    function startCountdown(duration, display) {
        let timer = duration, minutes, seconds;
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = "Time remaining: " + minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(interval);
                Swal.fire({
                    title: 'Time Expired',
                    text: 'Payment session has expired. Please try again.',
                    icon: 'error'
                }).then(() => {
                    window.location.reload();
                });
            }
        }, 1000);
        return interval;
    }

    // Main form submission handler
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        const submitBtn = document.getElementById('submitBtn');
        const loader = document.getElementById('loader');
        const countdownDisplay = document.getElementById('countdown');
        
        submitBtn.disabled = true;
        loader.style.display = 'block';
        
        // Start 2-minute countdown
        let countdownInterval = startCountdown(120, countdownDisplay);

        if (paymentMethod === 'mpesa') {
            processPayHeroPayment()
                .finally(() => {
                    clearInterval(countdownInterval);
                });
        } else {
            processCardPayment()
                .finally(() => {
                    clearInterval(countdownInterval);
                });
        }
    });

    async function processPayHeroPayment() {
        try {
            const response = await fetch('process_payhero.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    order_id: "<?= $paymentData['order_id'] ?>",
                    amount: "<?= $paymentData['total_amount'] ?>",
                    phone: "<?= $paymentData['phone_number'] ?>",
                    customer_name: "<?= $paymentData['customer_name'] ?>"
                })
            });
            
            const result = await response.json();
            
            if (result.status === 'success') {
                Swal.fire({
                    title: 'Payment Initiated',
                    html: `
                        <p>Please check your phone to complete M-Pesa payment</p>
                        <p><strong>Amount:</strong> Ksh <?= number_format($paymentData['total_amount'], 2) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($paymentData['phone_number']) ?></p>
                    `,
                    icon: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'I have completed payment'
                }).then(() => {
                    // Redirect to order tracking page
                    window.location.href = 'order_status.php?id='+result.data.external_reference;
                });
            } else {
                Swal.fire({
                    title: 'Payment Failed',
                    text: result.message || 'Could not initiate payment. Please try again.',
                    icon: 'error'
                });
            }
        } catch (error) {
            console.error('Payment error:', error);
            Swal.fire({
                title: 'Network Error',
                text: 'Could not connect to payment service. Please check your connection and try again.',
                icon: 'error'
            });
        } finally {
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('loader').style.display = 'none';
        }
    }

    async function processCardPayment() {
        try {
            // Simulate API call delay
            await new Promise(resolve => setTimeout(resolve, 1500));
            
            // In a real implementation, you would integrate Flutterwave/Pesapal here
            Swal.fire({
                title: 'Redirecting to Payment Gateway',
                text: 'You will be redirected to complete card payment',
                icon: 'info',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                // Simulate success for demo purposes
                window.location.href = "order_success.php?order_id=<?= $paymentData['order_id'] ?>";
            });
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: 'Card payment processing failed',
                icon: 'error'
            });
        }
    }
    </script>
</body>
</html>