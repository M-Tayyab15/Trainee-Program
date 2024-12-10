<?php
session_start();


$maxFileSize = 2 * 1024 * 1024;
$errorMsgFilename = '';
$errorMsgFile = '';
date_default_timezone_set("Asia/Karachi");

if (isset($_FILES['fileupload'])) {
    $file = $_FILES['fileupload'];
    $filename = $_POST['filename'];


    if (empty($filename)) {
        $errorMsgFilename = "Error: Filename cannot be empty.";
    } 

  
    if ($file['size'] > $maxFileSize) {
        $errorMsgFile = "Error: File size exceeds 2MB.";
    } elseif ($file['type'] != 'application/pdf') {
        $errorMsgFile = "Error: Only PDF files are allowed.";
    } 

  
    if (empty($errorMsgFilename) && empty($errorMsgFile)) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . $filename . '.pdf';

        if (file_exists($uploadFile)) {
            $timestamp = time();
            $newFilename = $timestamp . '_' . $filename . '.pdf';
            $uploadFile = $uploadDir . $newFilename;
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $_SESSION['errorMsg'] = "<p>Success: File uploaded successfully.<p>";
        } else {
            $errorMsgFile = "Error: Unable to upload file.";
        }
    }

    $_SESSION['errorMsgFilename'] = $errorMsgFilename;
    $_SESSION['errorMsgFile'] = $errorMsgFile;
    
} else {
    $_SESSION['errorMsgFile'] = "Error: File not uploaded.";
}

echo $_SESSION['errorMsg'];
header('Location: fileUpload.php');
exit;
?>