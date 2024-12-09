<?php
include 'connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = $_SESSION['cart_id']; 

// Check if cart_id is provided via GET request
if (!isset($cart_id)) {
    echo "<p>Invalid cart ID.</p>";
    exit;
}

// Fetch user profile
$stmt = $conn->prepare("SELECT * FROM tbl_profile WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

// Fetch cart details for the specific cart_id
$stmt = $conn->prepare("SELECT c.cart_id, c.total_amount, c.payment_mode, cp.product_id, cp.quantity, p.name, p.price
FROM tbl_cart c
JOIN tbl_cart_products cp ON c.cart_id = cp.cart_id
JOIN tbl_product p ON cp.product_id = p.pro_id
WHERE c.user_id = ? AND c.cart_id = ? AND c.status = 3"); // Status 3 indicates completed orders
$stmt->bind_param("ii", $user_id, $cart_id);
$stmt->execute();
$order_items = $stmt->get_result();

// Fetch the first row to get the payment mode (since it's the same for the whole order)
$order_info = $order_items->fetch_assoc();

// Check if there are any order items for this cart
if ($order_items->num_rows === 0) {
    echo "<p>No orders found for the specified cart.</p>";
    exit;
}

$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Order Confirmation</h1>
        <h3>Thank you for your purchase, <?php echo htmlspecialchars($profile['firstname']); ?>!</h3>
        <h4>Your Order Details:</h4>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price (Per Item)</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the result pointer back to the first item after fetching the payment mode
                $order_items->data_seek(0); // Reset the result pointer to the first row
                
                while ($item = $order_items->fetch_assoc()):
                    $total_price = $item['price'] * $item['quantity'];  // Calculate total price for the item
                    $total_amount += $total_price;  // Add to the total amount
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price'], 2); ?>$</td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo number_format($total_price, 2); ?>$</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h4>Total Amount: <?php echo number_format($total_amount, 2); ?>$</h4>
        <h4>Payment Method: <?php echo htmlspecialchars($order_info['payment_mode']); ?></h4>

        <h4>Shipping Address:</h4>
        <p>
            <?php echo htmlspecialchars($profile['address']); ?>
            <!-- <?php echo htmlspecialchars($profile['city']) . ', ' . htmlspecialchars($profile['state']) . ', ' . htmlspecialchars($profile['country']); ?><br> -->
            <h5>
                Phone: <?php echo htmlspecialchars($profile['phone_number']); ?>
            </h5>
        </p>

        <a href="carousel.php" class="btn btn-primary" style="position: absolute; top: 55px; right: 250px;">Return to Home</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
