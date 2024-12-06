<?php
include 'connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to proceed.";
    exit;
}

// Retrieve user info and cart items
$user_id = $_SESSION['user_id'];
$cart_items = [];
$total_price = 0;

// Get the user's latest cart_id
$stmt = $conn->prepare("SELECT * FROM tbl_cart WHERE user_id = ? ORDER BY cart_id DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cart = $result->fetch_assoc();
    $cart_id = $cart['cart_id'];

    // Capture the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    
    if (filter_var($user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
       
        $user_ip = inet_pton($user_ip); // Convert to binary representation
        if (strlen($user_ip) == 16) {
            // Check if the address is IPv4-mapped in the lower 4 bytes of the IPv6 address
            $user_ip = inet_ntop(substr($user_ip, 12, 4)); // Extract IPv4 from mapped IPv6
        }
    }

    // Ensure the IP is in IPv4 format (if possible)
    if (!filter_var($user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        // If it's not a valid IPv4 address, we can default to an empty string or handle the case
        $user_ip = '';
    }

    // Update the cart with the IP address (in IPv4 format)
    $stmt = $conn->prepare("UPDATE tbl_cart SET ip_address = ? WHERE cart_id = ?");
    $stmt->bind_param("si", $user_ip, $cart_id);
    $stmt->execute();

    // Fetch cart items
    $sql = "SELECT cp.cart_product_id, p.pro_id, p.name, p.price, cp.quantity 
            FROM tbl_cart_products cp 
            JOIN tbl_product p ON cp.product_id = p.pro_id 
            WHERE cp.cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }
} else {
    echo "No items found in the cart.";
    exit;
}

// Handle form submission for payment method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];

    // Process payment (COD or PayPal) based on the selected method
    if ($payment_method == 'cod') {
        // Update the cart status for COD
        $stmt = $conn->prepare("UPDATE tbl_cart SET status = 3, payment_mode = 'COD' WHERE cart_id = ?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        header("Location: order_confirmation.php");
        exit;
    } elseif ($payment_method == 'paypal') {
        // Redirect to PayPal payment processing
        header("Location: paypal_process.php?cart_id=" . $cart_id);
        exit;
    }
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AQ136heDRFOoF6v-6-NjxMEmr6FrH9KlfW9aRfJAEdqN1S9ssucLaGzCUIhoJKe5d1XpjHe62QOfdCLS&currency=USD"></script>

<script>
    $(document).ready(function() {
        // Show PayPal form when the PayPal option is selected
        $('input[name="payment_method"]').change(function() {
            var paymentMethod = $(this).val();
            
            // Show or hide the PayPal form based on selected payment method
            if (paymentMethod === 'paypal') {
                $('#paypal-form').fadeIn(); // Fade in PayPal form
            } else {
                $('#paypal-form').fadeOut(); // Fade out PayPal form
            }

            // Handle payment confirmation based on selected method
            if (paymentMethod === 'cod') {
                confirmPayment(paymentMethod); // COD requires confirmation
            } else {
                $('#confirmation-popup').hide(); // Hide confirmation popup for PayPal
            }
        });

        paypal.Buttons({
    createOrder: function(data, actions) {
        var totalAmount = document.getElementById("total_amount").textContent;
        totalAmount = parseFloat(totalAmount);
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: totalAmount.toFixed(2)
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name);

            // Collect transaction details
            var transactionDetails = {
                orderID: data.orderID,  // PayPal order ID
                payerID: data.payerID,  // PayPal payer ID
                transactionID: details.id,  // PayPal transaction ID
                payerName: details.payer.name.given_name,  // Payer's name
                payerEmail: details.payer.email_address  // Payer's email address
            };

            // Send transaction details to the server (PHP)
            $.ajax({
                url: 'paypal_process.php?cart_id=' + <?php echo $cart_id; ?>,  // Pass the cart_id in the URL
                method: 'POST',
                data: {
                    transaction_details: transactionDetails  // Send transaction details as a JSON object
                },
                success: function(response) {
                    window.location.href = "order_confirmation.php"; // Redirect to confirmation page after payment
                },
                error: function() {
                    alert("An error occurred while processing your PayPal payment.");
                }
            });
        });
    },
    onError: function(err) {
        console.error('PayPal Button Error:', err);
    }
}).render('#paypal-button-container'); // Render PayPal button in this container

    });

    // Confirmation function before submitting the form
    function confirmPayment(paymentMethod) {
        var totalAmount = document.getElementById("total_amount").textContent;
        var confirmationMessage = "Are you sure you want to proceed with the payment of " + totalAmount + " USD using " + (paymentMethod === 'paypal' ? 'PayPal' : 'Cash on Delivery') + "?";

        $('#confirmation-popup').fadeIn(); // Show confirmation popup for COD

        // When user clicks confirm in the popup
        $('#confirm-btn').click(function() {
            $('form.payment-form').submit();
        });

        // When user clicks cancel in the popup
        $('#cancel-btn').click(function() {
            $('#confirmation-popup').fadeOut();
        });
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h3, h4 {
            color: #333;
        }

        .payment-option-label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #5bc0de;
            border-color: #5bc0de;
        }

        .btn-primary:hover {
            background-color: #31b0d5;
            border-color: #31b0d5;
        }

        .form-check {
            margin-bottom: 20px;
        }

        .product-item {
            margin-bottom: 10px;
            color: #555;
        }

        #paypal-form {
            display: none;
        }

        #paypal-button-container {
            margin-top: 20px;
        }

        /* Custom Popup Styles */
        #confirmation-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .popup-content button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
        }

        #confirm-btn {
            background-color: #5bc0de;
            border-color: #5bc0de;
        }

        #cancel-btn {
            background-color: #d9534f;
            border-color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <span style="display: none;" id="total_amount"> <?= $cart['total_amount'] ?></span>
        <h1 class="text-center">Payment Options</h1>
        <h3 class="text-center mb-4">Total Amount: <?php echo number_format($total_price, 2); ?>$</h3>
        
        <h4>Selected Products:</h4>
        <ul class="list-unstyled">
            <?php foreach ($cart_items as $item): ?>
                <li class="product-item">
                    <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                    Price: <?php echo number_format($item['price'], 2); ?>$ x <?php echo $item['quantity']; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <form method="POST" action="" class="payment-form">
            <div class="form-group">
                <label class="payment-option-label">Payment Method</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="cod" name="payment_method" value="cod">
                    <label class="form-check-label" for="cod">Cash on Delivery</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="paypal" name="payment_method" value="paypal">
                    <label class="form-check-label" for="paypal">PayPal</label>
                </div>
            </div>

            <div id="paypal-form">
                <label>PayPal Payment</label>
                <div id="paypal-button-container"></div>
            </div>
        </form>
    </div>

    <!-- Confirmation Popup -->
    <div id="confirmation-popup">
        <div class="popup-content">
            <h3>Are you sure you want to proceed with Cash on Delivery?</h3>
            <button id="confirm-btn" class="btn btn-primary">Confirm</button>
            <button id="cancel-btn" class="btn btn-danger">Cancel</button>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
