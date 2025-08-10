<?php
// payhero_callback.php
require_once 'config.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

file_put_contents('payhero_callback.log', date('Y-m-d H:i:s')." - $input\n", FILE_APPEND);

if (isset($data['status']) && $data['status'] == 'success') {
    // Update payment status
    $stmt = $conn->prepare("UPDATE payments SET 
        status = 'completed',
        transaction_id = ?,
        updated_at = NOW()
        WHERE reference = ?");
    $stmt->bind_param("ss", $data['transaction_id'], $data['external_reference']);
    $stmt->execute();
    
    // Update order status
    $stmt = $conn->prepare("UPDATE orders SET 
        status = 'paid',
        payment_reference = ?
        WHERE order_id = ?");
    $stmt->bind_param("ss", $data['transaction_id'], $data['external_reference']);
    $stmt->execute();
}

header("HTTP/1.1 200 OK");
?>