<?php

include 'connection.php';

session_start();

$cart_id = $_SESSION['cart_id'] ?? "";

// Check if transaction details are in the GET request
if (isset($_GET['transaction_details'])) {
    $transactionDetails = $_GET['transaction_details'];

    // Sanitize the transaction details
    $transactionDetails = $conn->real_escape_string($transactionDetails);

    // Update the transaction_details column in tbl_cart
    $update_status = "UPDATE tbl_cart SET transaction_details = '$transactionDetails' WHERE cart_id = $cart_id";
} else {
    echo "No transaction details available.";
}

?>