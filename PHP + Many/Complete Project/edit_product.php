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

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$errors = [];

// Fetch product details
$productQuery = $conn->prepare("SELECT p.pro_id, p.name, p.price, p.description, p.cat_id FROM tbl_product p WHERE p.pro_id = ? LIMIT 1");
$productQuery->bind_param("i", $productId);
$productQuery->execute();
$productResult = $productQuery->get_result();

if ($productResult->num_rows === 0) {
    die("Product not found.");
}

$product = $productResult->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $categoryId = (int)$_POST['category_id'];
    $description = trim($_POST['description']);
    
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

    // If no errors, proceed to update the product
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE tbl_product SET name = ?, price = ?, description = ?, cat_id = ? WHERE pro_id = ?");
        $stmt->bind_param("sdssi", $productName, $price, $description, $categoryId, $productId);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Product updated successfully!";
            header('Location: product.php');
            exit;
        } else {
            $errors[] = "Failed to update product.";
        }
    }
}

// Fetch categories from the database
$categoryResult = $conn->query("SELECT cat_id, name FROM tbl_category WHERE status = 1");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php
include 'layout/header.php';
include 'layout/sidebar.php';
?>
<body>
    <div class="container mt-5 w3-main" style="padding: 100px;">
        <h2>Edit Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="edit_product.php?id=<?php echo $productId; ?>" method="post">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while ($category = $categoryResult->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($category['cat_id']); ?>" <?php echo ($category['cat_id'] == $product['cat_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description (optional)</label>
                <textarea name="description" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="product.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
<?php include 'layout/footer.php'; ?>

</html>