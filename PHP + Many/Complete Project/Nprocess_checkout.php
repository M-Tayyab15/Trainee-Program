<?php
session_start();
include 'connection.php'; // Include your database connection

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Step 1: Set the cart status to '2' (indicating checkout is in progress)
    $stmt = $conn->prepare("UPDATE tbl_cart SET status = 2, updated_on = NOW() WHERE user_id = ? AND status = 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Step 2: Fetch user profile details
    $stmt = $conn->prepare("SELECT * FROM tbl_profile WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $profile = $stmt->get_result()->fetch_assoc();

    // Step 3: Create a new order record (if you have a tbl_orders table)
    $order_total = 0; // Initialize order total
    $stmt = $conn->prepare("SELECT total_price FROM tbl_cart_products WHERE cart_id IN (SELECT cart_id FROM tbl_cart WHERE user_id = ? AND status = 2)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $order_total += $row['total_price']; // Calculate the total order amount
    }

    // Insert a new order (assuming you have a `tbl_orders` table)
    $stmt = $conn->prepare("INSERT INTO tbl_orders (user_id, total_amount, status, created_on) VALUES (?, ?, 1, NOW())");
    $stmt->bind_param("id", $user_id, $order_total);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the newly created order ID

    // Step 4: Update the order items (link to tbl_cart_products)
    $stmt = $conn->prepare("UPDATE tbl_cart_products SET order_id = ? WHERE cart_id IN (SELECT cart_id FROM tbl_cart WHERE user_id = ? AND status = 2)");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();

    // Step 5: Optionally, clear the cart (if you want to empty the cart after checkout)
    $stmt = $conn->prepare("DELETE FROM tbl_cart_products WHERE cart_id IN (SELECT cart_id FROM tbl_cart WHERE user_id = ? AND status = 2)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo "Checkout successful!";
} else {
    echo "User not logged in.";
}

$conn->close();
?>
