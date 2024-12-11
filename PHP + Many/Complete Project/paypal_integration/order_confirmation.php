<?php
include '../connection.php';

// Retrieve the order details from the database
$order_id = $_GET['order_id'];

// Query the database to get the order details
$stmt = $conn->prepare("SELECT * FROM tbl_order WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order_details = $order_result->fetch_assoc();

if (!$order_details) {
    echo "Order not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully placed and paid for.</p>
    <p>Order ID: <?php echo htmlspecialchars($order_details['order_id']); ?></p>
    <p>Cart ID: <?php echo htmlspecialchars($order_details['cart_id']); ?></p>
    <p>Total Amount: Rs. <?php echo htmlspecialchars($order_details['total_amount']); ?></p>
    <p>Payment Mode: <?php echo htmlspecialchars($order_details['payment_mode']); ?></p>
    <p>Order Date: <?php echo date('Y-m-d H:i:s', $order_details['created_on']); ?></p>
    <!-- Show additional order details as needed -->
</body>
</html>

<?php
$conn->close();
?>