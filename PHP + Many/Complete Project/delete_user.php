<?php
session_start();
include 'connection.php';

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id']; 

    $sql = "UPDATE tbl_user_info SET status = 0 WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user: " . $conn->error;
    }
}

header('Location: users.php');
exit;
?>
