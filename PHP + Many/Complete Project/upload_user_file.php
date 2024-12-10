<?php
session_start();
include 'connection.php';

$time = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && isset($_POST['user_id']) && isset($_POST['filename'])) {
    $userId = (int)$_POST['user_id'];
    $file = $_FILES['file'];
    $customFileName = trim($_POST['filename']);
    $uploadDir = 'uploadsfile/' . $userId . '/';


    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validate file type
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['error'] = 'Invalid file type. Only PDF and Word documents are allowed.';
        header('Location: users.php'); 
        exit;
    }

    // Check if a file already exists in the directory
    $existingFiles = glob($uploadDir . '*'); // Get all files in the directory
    if (!empty($existingFiles)) {
        foreach ($existingFiles as $existingFile) {
           
            $existingFileName = basename($existingFile);
            
            
            $updateSql = "UPDATE tbl_file SET status = 0, modified_by = 1,filename = '$time" . "_" . $existingFileName . "' WHERE user_id = $userId AND status = 1";
            $conn->query($updateSql);

            
            $newOldFilePath = $uploadDir . $time . '_' . $existingFileName;
            rename($existingFile, $newOldFilePath);
        }
    }

    // Generate the new file path
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = preg_replace('/\s+/', '_', $customFileName);
    $filePath = $uploadDir . $fileName . '.' . $extension;

    // Move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $fileSize = $file['size'];
        $folder = $uploadDir;
        $status = 1; 
        $createdOn = time();
        $fileType = $file['type']; 
        $createdBy = 1;
        $ip = 192;

        $sql = "INSERT INTO tbl_file (user_id, filename, size, folder, created_on, status, filetype, created_by, ip_address) 
                VALUES ($userId, '$fileName', $fileSize, '$folder', $createdOn, $status, '$fileType', $createdBy, $ip)";
        $conn->query($sql);

        $_SESSION['message'] = 'File uploaded successfully!';
    } else {
        $_SESSION['error'] = 'File upload failed!';
    }

    header('Location: users.php'); 
    exit;
}
