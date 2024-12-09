<?php
// order_details.php
include 'connection.php';

if (isset($_GET['cart_id'])) {
    $cart_id = (int)$_GET['cart_id'];

    // Fetch the products in the order with images having priority 'H'
    $sql = "SELECT 
                p.name AS product_name,
                p.price AS product_price,
                p.description AS product_description,
                pi.filename AS product_image,
                pi.folder AS product_image_folder,
                cp.total_price AS product_total_price
            FROM 
                tbl_cart_products cp
            JOIN 
                tbl_product p ON cp.product_id = p.pro_id
            LEFT JOIN 
                tbl_product_images pi ON p.pro_id = pi.pro_id
            WHERE 
                cp.cart_id = $cart_id AND pi.priority = 'H'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Table for displaying product details
        echo '<h5>Products in this Order:</h5>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Product</th>';
        echo '<th>Price</th>';
        echo '<th>Description</th>';
        echo '<th>Total Price</th>';
        echo '<th>Image</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($productRow = $result->fetch_assoc()) {
            // Truncate the description to 100 characters or less
            $truncated_description = substr($productRow['product_description'], 0, 25);
            if (strlen($productRow['product_description']) > 25) {
                $truncated_description .= '...'; // Add ellipsis if the description is longer than 100 characters
            }

            echo '<tr>';
            echo '<td>' . htmlspecialchars($productRow['product_name']) . '</td>';
            echo '<td>' . number_format($productRow['product_price'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($truncated_description) . '</td>';
            echo '<td>' . number_format($productRow['product_total_price'], 2) . '</td>';
            echo '<td><img src="' . htmlspecialchars($productRow['product_image_folder'] . '/' . $productRow['product_image']) . '" alt="Product Image" width="100"></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No products found for this order.</p>';
    }
} else {
    echo '<p>No order selected.</p>';
}
?>