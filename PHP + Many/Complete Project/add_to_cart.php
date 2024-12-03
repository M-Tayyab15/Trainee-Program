<?php
session_start();
include 'connection.php'; // Include your database connection

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
    $user_id = $_SESSION['user_id']; // Get the user_id from the session

    if ($product_id) {
        // Start transaction for cart creation/update
        $conn->begin_transaction();

        // Step 1: Check if the user already has an active cart in tbl_cart
        $cart_id = null;
        $stmt = $conn->prepare("SELECT cart_id FROM tbl_cart WHERE user_id = ? AND status IS NULL LIMIT 1 FOR UPDATE");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Cart exists for the user, get the cart_id
            $cart_id = $result->fetch_assoc()['cart_id'];
        } else {
            // No active cart exists, create one
            $stmt = $conn->prepare("INSERT INTO tbl_cart (user_id, status) VALUES (?, NULL)");
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                $cart_id = $conn->insert_id;
            } else {
                die('Error creating cart: ' . $stmt->error);
            }
        }

       // Step 2: Check if the product already exists in the cart and update the quantity if so
       $stmt = $conn->prepare("SELECT cart_product_id, quantity, product_price FROM tbl_cart_products WHERE cart_id = ? AND product_id = ?");
       $stmt->bind_param("ii", $cart_id, $product_id);
       $stmt->execute();
       $result = $stmt->get_result();

       if ($result->num_rows > 0) {
           // Product already exists in the cart, update quantity and total_price
           $row = $result->fetch_assoc();
           $new_quantity = $row['quantity'] + 1; // Increment quantity by 1
           $product_price = $row['product_price']; // Get product price
           $new_total_price = $new_quantity * $product_price; // Calculate new total price
           $stmt = $conn->prepare("UPDATE tbl_cart_products SET quantity = ?, total_price = ? WHERE cart_product_id = ?");
           $stmt->bind_param("idi", $new_quantity, $new_total_price, $row['cart_product_id']);
           $stmt->execute();
       } else {
           // Product doesn't exist in the cart, add it
           // First, get the product price from tbl_product
           $stmt = $conn->prepare("SELECT price FROM tbl_product WHERE pro_id = ?");
           $stmt->bind_param("i", $product_id);
           $stmt->execute();
           $result = $stmt->get_result();
           $product = $result->fetch_assoc();
           $product_price = $product['price'];

           // Add product to the cart
           $stmt = $conn->prepare("INSERT INTO tbl_cart_products (user_id, cart_id, product_id, quantity, product_price, total_price) VALUES (?, ?, ?, ?, ?, ?)");
           $quantity = 1; // Initial quantity
           $total_price = $quantity * $product_price;
           $stmt->bind_param("iiiiid", $user_id, $cart_id, $product_id, $quantity, $product_price, $total_price);
           $stmt->execute();
       }

       // Step 3: Update the total amount of the cart
       $stmt = $conn->prepare("SELECT SUM(total_price) AS total_amount FROM tbl_cart_products WHERE cart_id = ?");
       $stmt->bind_param("i", $cart_id);
       $stmt->execute();
       $result = $stmt->get_result();
       $total_amount = $result->fetch_assoc()['total_amount'];

       // Update the total_amount in tbl_cart
       $stmt = $conn->prepare("UPDATE tbl_cart SET total_amount = ? WHERE cart_id = ?");
       $stmt->bind_param("di", $total_amount, $cart_id);
       $stmt->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        // No product_id provided, redirect to the home page or elsewhere
        header('Location: index_User.php');
        exit;
    }
} else {
    // User is not logged in, store the current page URL to redirect back after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    // Redirect to the login page
    header('Location: Users/login_User.php');
    exit;
}

?>
