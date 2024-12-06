<?php
include 'connection.php';

if (isset($_GET['product_id'])) {
    $product_id = (int) $_GET['product_id'];

    // Fetch product details
    $sql = "
        SELECT p.pro_id, p.name, p.price, p.description, c.name AS category_name,
               pi.filename, pi.folder
        FROM tbl_product p
        JOIN tbl_category c ON p.cat_id = c.cat_id
        LEFT JOIN tbl_product_images pi ON p.pro_id = pi.pro_id
        WHERE p.pro_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = null;
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Fetch all images for the product
        $sql_images = "
            SELECT pi.filename, pi.folder
            FROM tbl_product_images pi
            WHERE pi.pro_id = ?
        ";
        $stmt_images = $conn->prepare($sql_images);
        $stmt_images->bind_param('i', $product_id);
        $stmt_images->execute();
        $result_images = $stmt_images->get_result();
        
        $images = [];
        while ($row = $result_images->fetch_assoc()) {
            $images[] = $row['folder'] . '/' . $row['filename'];
        }

        $product['images'] = $images;
    }

    echo json_encode($product);
} else {
    echo json_encode(['error' => 'Product ID is missing']);
}
?>
