<?php
session_start();
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get user ID from session
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

    if ($product_id) {
        // Step 1: Get the user's cart_id from tbl_cart
        $stmt = $conn->prepare("SELECT cart_id FROM tbl_cart WHERE user_id = ? AND status IS NULL"); // Only get active carts
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cart_id = $result->fetch_assoc()['cart_id'];

            // Step 2: Remove the product from the cart in tbl_cart_products
            $stmt = $conn->prepare("DELETE FROM tbl_cart_products WHERE cart_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $cart_id, $product_id);
            $stmt->execute();

            // Step 3: Update the total_amount in tbl_cart
            $stmt = $conn->prepare("SELECT SUM(p.price * cp.quantity) AS total_amount FROM tbl_cart_products cp JOIN tbl_product p ON cp.product_id = p.pro_id WHERE cp.cart_id = ?");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $total_amount = $result->fetch_assoc()['total_amount'];

            // Update the total_amount in tbl_cart
            $stmt = $conn->prepare("UPDATE tbl_cart SET total_amount = ? WHERE cart_id = ?");
            $stmt->bind_param("di", $total_amount, $cart_id);
            $stmt->execute();

            // Redirect to the cart page
            header('Location: cart.php');
            exit;
        } else {
            echo "No cart found for this user.";
        }
    } else {
        echo "No product ID specified.";
    }
} else {
    // If the user is not logged in, redirect to login page
    header('Location: Users/login_User.php');
    exit;
}
?>
