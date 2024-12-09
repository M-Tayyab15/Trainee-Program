<?php
// Check if the download button was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Path to the file in the www directory
    $filePath = 'missing tables.pdf'; // Update this path accordingly

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Clear output buffer
        ob_clean();
        flush();

        // Read the file and send it to the output
        readfile($filePath);
        exit;
    } else {
        echo "File does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download File</title>
</head>
<body>
    <h1>Download File</h1>
    <form action="" method="post">
        <button type="submit">Download File</button>
    </form>
</body>
</html>
