<?php
session_start();
if (isset($_SESSION['username1'])) {
    header('Location: Users/index_User.php');
    exit;
}
if (!isset($_SESSION['username'])) {
    header('Location: login2.php');
    exit;
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login2.php');
    exit;
}

include 'connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $categoryId = (int)$_POST['category_id'];
    $description = trim($_POST['description']);
    $createdOn = time(); // Using time() function for created_on
    $status = 1;
    $errors = [];

    // Validate required fields
    if (empty($productName)) {
        $errors[] = "Product name is required.";
    }
    if (empty($price) || !is_numeric($price)) {
        $errors[] = "Valid price is required.";
    }
    if (empty($categoryId)) {
        $errors[] = "Category is required.";
    }

    // If no errors, proceed to insert the product
    if (empty($errors)) {
        // Insert the product into tbl_product
        $stmt = $conn->prepare("INSERT INTO tbl_product (name, price, description, cat_id, created_on, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssii", $productName, $price, $description, $categoryId, $createdOn, $status);
        if ($stmt->execute()) {
            $productId = $stmt->insert_id; // Get the newly created product ID

            // Create a folder for product images
            $targetDir = "uploads/products/" . $productId . "/";
            mkdir($targetDir, 0755, true);

            // Handle image uploads
            $imageCount = 0;
            foreach ($_FILES['images']['name'] as $key => $name) {
                if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$key];
                    $fileName = basename($name);
                    $targetFilePath = $targetDir . $fileName;

                    // Validate file type: Only allow images (jpeg, png, gif)
                    $fileType = mime_content_type($tmpName);
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    if (!in_array($fileType, $allowedTypes)) {
                        $errors[] = "File '$fileName' is not a valid image. Please upload a JPEG, PNG, or GIF file.";
                        continue; // Skip this file
                    }

                    // Check if there are already 5 images uploaded
                    if ($imageCount < 5) {
                        if (move_uploaded_file($tmpName, $targetFilePath)) {
                            // Insert image details into tbl_product_images
                            $stmtImage = $conn->prepare("INSERT INTO tbl_product_images (filename, folder, pro_id, created_on) VALUES (?, ?, ?, ?)");
                            $stmtImage->bind_param("ssii", $fileName, $targetDir, $productId, $createdOn);
                            if (!$stmtImage->execute()) {
                                $errors[] = "Failed to insert image details: " . $stmtImage->error;
                            }
                            $imageCount++;
                        }
                    }
                }
            }

            // If there are no errors, redirect to the product page
            if (empty($errors)) {
                $_SESSION['message'] = "Product added successfully!";
                header('Location: product.php');
                exit;
            }
        } else {
            $errors[] = "Failed to add product.";
        }
    }
}

// Fetch categories from the database
$categoryResult = $conn->query("SELECT cat_id, name FROM tbl_category WHERE status = 1");

// Debugging: Check if the query is successful and if categories are returned
if ($categoryResult === false) {
    die("Database query failed: " . $conn->error);
} elseif ($categoryResult->num_rows == 0) {
    die("No categories found in the database.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<?php
include 'layout/header.php';
include 'layout/sidebar.php';
?>
<body>
    <div class="container mt-5 w3-main" style="padding: 100px;">
        <h2>Add Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while ($category = $categoryResult->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($category['cat_id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="images">Upload Images (max 5)</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div> -->
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="product.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
<?php include 'layout/footer.php'; ?>

</html>
