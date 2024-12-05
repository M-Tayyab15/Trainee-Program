<?php
session_start();
include 'connection.php';

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id']; 

    $sql = "UPDATE tbl_product SET status = 0 WHERE pro_id = $userId";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Product deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user: " . $conn->error;
    }
}

header('Location: product.php');
exit;
?>
