<?php
include 'connection.php';
include 'Eheader.php';

$cart_items = [];
$total_price = 0;
$checkout_form = false;
$paypal_total = 0; // Initialize PayPal total

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Step 1: Get the user's latest cart_id and status from tbl_cart
    $stmt = $conn->prepare("SELECT * FROM tbl_cart WHERE user_id = ? ORDER BY cart_id DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
        $cart_id = $cart['cart_id'];
        $_SESSION['cart_id'] = $cart_id; // Store the latest cart_id in session
        $cart_status = $cart['status'];
        $checkout_form = ($cart_status == 2);

        // Step 2: Check if checkout form is active
        if (!$checkout_form) {
            // Query to fetch the cart items
            $sql = "SELECT cp.cart_product_id, p.pro_id, p.name, p.price, cp.quantity, pi.filename, pi.folder
                    FROM tbl_cart_products cp
                    JOIN tbl_product p ON cp.product_id = p.pro_id
                    LEFT JOIN tbl_product_images pi ON pi.pro_id = p.pro_id AND pi.priority = 'H'
                    JOIN tbl_cart c ON cp.cart_id = c.cart_id
                    WHERE (c.status IS NULL OR c.status < 2) AND cp.cart_id = ? AND cp.quantity > 0"; // Ensure positive quantity
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $cart_items[] = $row;
                $total_price += $row['price'] * $row['quantity'];
            }
            $paypal_total = number_format($total_price, 2, '.', '');
        }
    } else {
        echo "You don't have a pending cart.";
    }
} else {
    echo "Please log in to view your cart.";
}

// Handle Cart Updates
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $cart_product_id => $quantity) {
        $stmt = $conn->prepare("SELECT product_id FROM tbl_cart_products WHERE cart_product_id = ?");
        $stmt->bind_param("i", $cart_product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            // If quantity is zero, remove the product from the cart
            if ($quantity == 0) {
                $stmt = $conn->prepare("DELETE FROM tbl_cart_products WHERE cart_product_id = ?");
                $stmt->bind_param("i", $cart_product_id);
                $stmt->execute();
                continue;
            } else {
                $stmt = $conn->prepare("UPDATE tbl_cart_products SET quantity = ? WHERE cart_product_id = ?");
                $stmt->bind_param("ii", $quantity, $cart_product_id);
                $stmt->execute();
            }
        }
    }

    $stmt = $conn->prepare("UPDATE tbl_cart SET total_amount = (SELECT SUM(price * quantity) FROM tbl_cart_products WHERE cart_id = ?) WHERE cart_id = ?");
    $stmt->bind_param("ii", $cart_id, $cart_id);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
    exit;
}

// Handle Proceed to Checkout
if (isset($_POST['proceed_checkout'])) {
    $stmt = $conn->prepare("UPDATE tbl_cart SET status = 2 WHERE cart_id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Checkout Process
// After the checkout form is initialized
if (isset($_POST['checkout']) || $checkout_form) {
    // Recalculate total_price if needed
    if (!$checkout_form) {
        $total_price = 0; // Reset total price
        foreach ($cart_items as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }
    }

    // Fetch user profile and info as before
    $stmt = $conn->prepare("SELECT * FROM tbl_profile WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $profile = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM tbl_user_info WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_info = $stmt->get_result()->fetch_assoc();

    $checkout_form = true;
}



// Handle Profile Update
// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed_to_payment'])) {
    // Get the input values for profile update
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $user_id = $_POST['user_id'] ?? 0; // Ensure user_id is fetched from POST data

    // Check if phone and address are not empty
    if ($phone && $address) {
        // Prepared statement to update profile safely
        $stmt = $conn->prepare("UPDATE tbl_profile SET phone_number = ?, address = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $phone, $address, $user_id);  // "ssi" -> string, string, integer

        if ($stmt->execute()) {
            echo "<p>Your profile has been updated successfully.</p>";
            header("Location: mpayment.php");

        } else {
            echo "<p>Error updating your profile: " . $stmt->error . "</p>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<p>Phone number and address cannot be empty.</p>";
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 300px;
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

        .cart-item .quantity-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .cart-item .quantity-container input {
            width: 60px;
            margin-right: 10px;
        }

        .product-price {
            color: green;
            font-size: medium;
            font-weight: bold;
        }

        .cart-item .total-price {
            font-weight: bold;
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

        .cart-item .quantity-container button {
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin: 0 5px;
        }

        /* Hover effects for the buttons */
        .cart-item .quantity-container button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
            /* Darker border on hover */
            transform: scale(1.1);
            /* Slightly enlarge the button */
        }

        .cart-item .quantity-container button:disabled {
            background-color: #ddd;
            color: #777;
            border: 1px solid #ccc;
            cursor: not-allowed;
        }
    </style>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.quantity-increase', function() {
                let cartProductId = $(this).data('cart-id');
                let row = $(this).closest('.cart-item');
                let quantityElem = row.find('.quantity-value');
                let quantity = parseInt(quantityElem.text()) + 1;
                quantityElem.text(quantity);
                updateCart(cartProductId, quantity, row);
            });

            $(document).on('click', '.quantity-decrease', function() {
                let cartProductId = $(this).data('cart-id');
                let row = $(this).closest('.cart-item');
                let quantityElem = row.find('.quantity-value');
                let quantity = parseInt(quantityElem.text()) - 1;

                if (quantity <= 0) {
                    removeFromCart(cartProductId, row);
                } else {
                    quantityElem.text(quantity);
                    updateCart(cartProductId, quantity, row);
                }
            });

            function updateCart(cartProductId, quantity, row) {
                var price = row.find('.product-price').data('price');
                var total = price * quantity;
                row.find('.product-total').text(total.toFixed(2) + '$');

                var overallTotal = 0;
                $('.product-total').each(function() {
                    overallTotal += parseFloat($(this).text().replace('$', ''));
                });
                $('#total-price').text('Rs. ' + overallTotal.toFixed(2) + '$');

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        update_cart: true,
                        quantity: {
                            [cartProductId]: quantity
                        }
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            console.log("Cart updated successfully");
                        } else {
                            alert("Failed to update the cart.");
                        }
                    },
                    error: function() {
                        alert("An error occurred while processing your cart update.");
                    }
                });
            }

            function removeFromCart(cartProductId, row) {
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        update_cart: true,
                        quantity: {
                            [cartProductId]: 0
                        }
                    },
                    success: function(response) {
                        row.remove();
                        var overallTotal = 0;
                        $('.product-total').each(function() {
                            overallTotal += parseFloat($(this).text().replace('$. ', ''));
                        });
                        $('#total-price').text(overallTotal.toFixed(2) + '$');
                    },
                    error: function() {
                        alert("An error occurred while removing the item from the cart.");
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add validation on form submission
            $('form').on('submit', function(e) {
                // Get values from the form
                var phone = $('#phone').val().trim();
                var address = $('#address').val().trim();
                var isValid = true;
                var errorMessage = '';

                // Validate phone number
                if (phone === '') {
                    errorMessage += 'Phone number cannot be empty.\n';
                    isValid = false;
                } else if (!/^\d+$/.test(phone)) {
                    errorMessage += 'Phone number must contain only numbers.\n';
                    isValid = false;
                } else if (phone.length > 10) {
                    errorMessage += 'Phone number must be less than or equal to 10 digits.\n';
                    isValid = false;
                }

                // Validate address
                if (address === '') {
                    errorMessage += 'Address cannot be empty.\n';
                    isValid = false;
                }

                // If not valid, prevent form submission and show error message
                if (!isValid) {
                    e.preventDefault(); // Prevent form submission
                    alert(errorMessage); // Show error message
                }
            });
        });
    </script>
</head>

<body>
    <div class="container mt-5" id="cart-container">
        <h1>Your Cart</h1>

        <?php if (count($cart_items) > 0): ?>
            <!-- Cart Items Form -->
            <form method="POST" action="">
                <div class="list-group">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item <?php if ($checkout_form) echo 'disabled-item'; ?>">
                            <div>
                                <?php if ($item['folder'] && $item['filename']): ?>
                                    <img src="<?php echo $item['folder'] . $item['filename']; ?>" alt="Product Image">
                                <?php else: ?>
                                    <img src="placeholder.jpg" alt="No Image">
                                <?php endif; ?>
                            </div>
                            <div class="product-details">
                                <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                <div class="product-price" data-price="<?php echo $item['price']; ?>"><?php echo number_format($item['price'], 2); ?>$</div>
                                <div class="quantity-container">
                                    <button type="button" class="btn btn-secondary quantity-decrease" data-cart-id="<?php echo $item['cart_product_id']; ?>" <?php if ($checkout_form) echo 'disabled'; ?>>-</button>
                                    <span class="quantity-value"><?php echo $item['quantity']; ?></span>
                                    <button type="button" class="btn btn-secondary quantity-increase" data-cart-id="<?php echo $item['cart_product_id']; ?>" <?php if ($checkout_form) echo 'disabled'; ?>>+</button>
                                    <div class="total-price product-total"><?php echo number_format($item['price'] * $item['quantity'], 2); ?>$</div>
                                </div>
                                <a style="margin-top: 20px;" href="remove_from_cart.php?product_id=<?php echo $item['pro_id']; ?>" class="btn btn-danger btn-sm" <?php if ($checkout_form) echo 'disabled'; ?>>Remove</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="total-price-container">
                    <h3>Total: <span id="total-price"><?php echo number_format($total_price, 2); ?>$</span></h3>
                </div>

                <?php if (!$checkout_form): ?>
                    <button type="submit" name="proceed_checkout" class="btn btn-primary">Proceed to Checkout</button>
                <?php endif; ?>
            </form>

        <?php elseif ($checkout_form): ?>

            <!-- Checkout Form -->
            <div id="checkout-form">
                <h1>Checkout</h1>
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
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($profile['phone_number']); ?>" required />
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" class="form-control" required><?php echo htmlspecialchars($profile['address']); ?></textarea>
    </div>
    <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($profile['user_id']); ?>" />
    <button type="submit" name="proceed_to_payment" class="btn btn-success">Proceed to Payment</button>
</form>

            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php include 'Efooter.php'; ?>