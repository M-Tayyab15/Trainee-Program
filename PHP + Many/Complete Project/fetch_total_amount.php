<?php
include 'connection.php';

if (isset($_GET['cart_id'])) {
    $cart_id = (int) $_GET['cart_id'];

    // Prepare the query to fetch the total amount from the cart
    $stmt = $conn->prepare("SELECT total_amount FROM tbl_cart WHERE cart_id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
        $total_amount = $cart['total_amount'];

        // Return the total amount in the response
        echo json_encode(['success' => true, 'total_amount' => $total_amount]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cart not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Cart ID not provided.']);
}

$conn->close();
?>
