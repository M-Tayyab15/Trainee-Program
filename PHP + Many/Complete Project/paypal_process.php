<?php
include 'connection.php';

// Get cart_id from URL (passed from the previous page)
if (!isset($_GET['cart_id'])) {
    echo "Invalid request.";
    exit;
}

$cart_id = $_GET['cart_id'];

// Check if transaction details are passed via POST (from the AJAX call in the previous page)
if (isset($_POST['transaction_details'])) {
    $transaction_details = $_POST['transaction_details'];
    
    // Sanitize and prepare the transaction details (ensure it's safe to store in the database)
    $transaction_details = json_encode($transaction_details); // Store as JSON string in the database

    // Update the cart with the transaction details and change the status to 'PayPal'
    $stmt = $conn->prepare("UPDATE tbl_cart SET status = 3, payment_mode = 'PayPal', transaction_details = ? WHERE cart_id = ?");
    $stmt->bind_param("si", $transaction_details, $cart_id);
    $stmt->execute();
    
    // Redirect to order confirmation page after payment is successfully processed
    header("Location: order_confirmation.php");
    exit;
} else {
    echo "No transaction details found.";
    exit;
}
?>
