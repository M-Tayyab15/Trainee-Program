<?php
session_start();
include 'connection.php'; // Include your database connection

// Check if the user is logged in
if (isset($_SESSION['user_id']) && isset($_POST['cart_product_id']) && isset($_POST['quantity'])) {
    $user_id = $_SESSION['user_id']; // Get the user_id from the session
    $cart_product_id = $_POST['cart_product_id'];
    $quantity = $_POST['quantity'];

    // Validate quantity
    if ($quantity < 1) {
        echo "Invalid quantity.";
        exit;
    }

    // Step 1: Fetch the product price for the cart item
    $stmt = $conn->prepare("SELECT product_price FROM tbl_cart_products WHERE cart_product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_product_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_price = $row['product_price'];

        // Step 2: Calculate the new total price for the item
        $total_price = $product_price * $quantity;

        // Step 3: Update the cart product quantity and total price
        $stmt = $conn->prepare("UPDATE tbl_cart_products SET quantity = ?, total_price = ? WHERE cart_product_id = ? AND user_id = ?");
        $stmt->bind_param("idii", $quantity, $total_price, $cart_product_id, $user_id);
        if ($stmt->execute()) {
            echo "Quantity updated successfully!";
        } else {
            echo "Error updating the quantity.";
        }
    } else {
        echo "Cart product not found.";
    }
} else {
    echo "User not logged in or invalid request.";
}

$conn->close();
?>
