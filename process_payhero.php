<?php
session_start();
require_once 'config.php'; // For database connection

// Validate session data
if (!isset($_SESSION['checkout_data'])) {
    die(json_encode(['status' => 'error', 'message' => 'Session expired']));
}

$paymentData = $_SESSION['checkout_data'];

// Prepare PayHero request
$payload = [
    "amount" => $paymentData['total_amount'],
    "phone_number" => $paymentData['phone_number'],
    "channel_id" => 1045, // PayHero's M-Pesa channel
    "provider" => "m-pesa",
    "external_reference" => $paymentData['order_id'],
    "customer_name" => $paymentData['customer_name'],
    "callback_url" => "https://yourdomain.com/payhero_callback.php"
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://backend.payhero.co.ke/api/v2/payments',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Basic '.base64_encode(PAYHERO_API_KEY.':') // Store in config.php
    ],
]);

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    // Log error
    file_put_contents('payment_errors.log', date('Y-m-d H:i:s')." - $error\n", FILE_APPEND);
    die(json_encode(['status' => 'error', 'message' => 'Payment processing failed']));
}

$responseData = json_decode($response, true);

// Save to database
$stmt = $conn->prepare("INSERT INTO payments 
    (order_id, amount, phone, reference, status, provider, response) 
    VALUES (?, ?, ?, ?, 'pending', 'payhero-mpesa', ?)");
$stmt->bind_param("sdsss", 
    $paymentData['order_id'],
    $paymentData['total_amount'],
    $paymentData['phone_number'],
    $responseData['transaction_reference'] ?? '',
    $response
);
$stmt->execute();

// Return response to frontend
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Payment initiated',
    'data' => $responseData
]);
?>