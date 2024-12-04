<?php
include 'connection.php';
include 'Eheader.php';

$cart_items = [];
$total_price = 0;
$cart_id = $_GET['cart_id'] ?? 0;
$checkout_form = true; // Always show checkout form here

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get the cart details
    $stmt = $conn->prepare("SELECT cart_id, status FROM tbl_cart WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
        $cart_status = $cart['status'];

        // Fetch the products in the cart if not checked out
        $sql = "SELECT cp.cart_product_id, p.pro_id, p.name, p.price, cp.quantity, pi.filename, pi.folder
                FROM tbl_cart_products cp
                JOIN tbl_product p ON cp.product_id = p.pro_id
                LEFT JOIN tbl_product_images pi ON pi.pro_id = p.pro_id AND pi.priority = 'H'
                WHERE cp.cart_id = ? AND cp.quantity > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
            $total_price += $row['price'] * $row['quantity'];
        }
    } else {
        echo "You don't have a valid cart.";
    }
} else {
    echo "Please log in to proceed.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            opacity: 0.5;
        }
        .cart-item img {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }
        .cart-item .product-details {
            flex-grow: 1;
        }
        .cart-item .product-name {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .cart-item .product-price {
            font-size: 1.1rem;
            margin-top: 5px;
        }
        .total-price-container {
            display: flex;
            justify-content: flex-end;
            font-size: 1.3rem;
            font-weight: bold;
            margin-top: 20px;
        }
        .form-group input, .form-group select, .form-group textarea {
            background-color: #f5f5f5;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Checkout</h1>

        <!-- Cart Items (Grayed-out) -->
        <div class="list-group">
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <div>
                        <?php if ($item['folder'] && $item['filename']): ?>
                            <img src="<?php echo $item['folder'] . $item['filename']; ?>" alt="Product Image">
                        <?php else: ?>
                            <img src="placeholder.jpg" alt="No Image">
                        <?php endif; ?>
                    </div>
                    <div class="product-details">
                        <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="product-price">Rs. <?php echo number_format($item['price'], 2); ?></div>
                        <div>Quantity: <?php echo $item['quantity']; ?></div>
                        <div class="total-price">Total: Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Total Price -->
        <div class="total-price-container">
            <h3>Total: Rs. <?php echo number_format($total_price, 2); ?></h3>
        </div>

        <!-- Checkout Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($profile['firstname'] . ' ' . $profile['lastname']); ?>" readonly />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_info['email']); ?>" readonly />
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-control" required>
                    <option value="cod">Cash on Delivery</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Complete Checkout</button>
        </form>
    </div>
</body>
</html>
