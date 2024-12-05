<!-- Not used -->
<?php
session_start();
include 'connection.php';

if (isset($_GET['user_id'])) {
    $userId = (int)$_GET['user_id'];

    // Query to get the attachment name for the user
    $stmt = $conn->prepare("SELECT filename AS attachment_name,
    folder AS attachment_folder FROM tbl_file WHERE user_id = ? AND status =1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileName = $row['attachment_name'];
        $folder = 'uploadsfile/' . $userId . '/';
        $filePath = $folder . $fileName;

        // Check if the file exists
        if (file_exists($filePath)) {
            // Set headers to download the file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Open the file and output it
            $file = fopen($filePath, 'rb');
            if ($file) {
                fpassthru($file);
                fclose($file);
                exit;
            } else {
                $_SESSION['error'] = 'Could not open file.';
                header('Location: users.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'File not found.';
            header('Location: users.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'No attachment found for this user.';
        header('Location: users.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: users.php');
    exit;
}


 ?>