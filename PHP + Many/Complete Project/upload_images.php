<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login2.php');
    exit;
}

include 'connection.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if the product exists
$productQuery = $conn->prepare("SELECT * FROM tbl_product WHERE pro_id = ?");
$productQuery->bind_param("i", $productId);
$productQuery->execute();
$productResult = $productQuery->get_result();

if ($productResult->num_rows === 0) {
    die("Product not found.");
}

// Create a folder for product images if it doesn't exist
$targetDir = "uploads/products/" . $productId . "/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Count existing images in the folder
$existingImages = count(glob($targetDir . "*.*"));
$maxImages = 5;

// Handle image uploads
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($existingImages >= $maxImages) {
        echo json_encode(['error' => "Folder already contains 5 images. Please remove some images before uploading more."]);
    } else {
        // Handle image uploads
        $imageCount = 0;
        foreach ($_FILES['images']['name'] as $key => $name) {
            if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                $tmpName = $_FILES['images']['tmp_name'][$key];
                $fileName = basename($name);
                $targetFilePath = $targetDir . $fileName;

                if ($imageCount < ($maxImages - $existingImages)) {
                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        // Insert image details into tbl_product_images
                        $stmtImage = $conn->prepare("INSERT INTO tbl_product_images (filename, folder, pro_id) VALUES (?, ?, ?)");
                        $stmtImage->bind_param("ssi", $fileName, $targetDir, $productId);
                        if ($stmtImage->execute()) {
                            $imageCount++;
                        } else {
                            echo json_encode(['error' => "Failed to insert image details: " . $stmtImage->error]);
                        }
                    }
                }
            }
        }

        if ($imageCount > 0) {
            echo json_encode(['success' => "Images uploaded successfully!"]);
        } else {
            echo json_encode(['error' => "No images were uploaded."]);
        }
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload More Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload More Images for Product ID: <?php echo htmlspecialchars($productId); ?></h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="upload_images.php?id=<?php echo $productId; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="images">Upload Images (max <?php echo $maxImages - $existingImages; ?> more)</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Upload Images</button>
            <a href="product.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>