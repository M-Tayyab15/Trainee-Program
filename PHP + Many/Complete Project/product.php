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

ob_start();

include 'connection.php';
include 'layout/header.php';
include 'layout/sidebar.php';
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    body {
        background-color: #f8f9fa;
    }

    .table-container {
        transition: margin-left 0.3s;
        margin-top: 6%;
        margin-left: 20px;
        margin-right: 20px;
    }

    .table {
        margin: 20px 0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table th {
        background-color: #007bff;
        color: white;
        text-align: center;
    }

    .table td {
        background-color: white;
        text-align: center;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-footer .btn {
        margin: 0 5px;
    }

    .modal-body {
        border: 1px solid #007bff;
        border-radius: 0.5rem;
    }

    .row {
        padding: 10px;
    }

    .border-bottom {
        border-bottom: 1px solid #007bff;
    }

    .border-right {
        border-right: 1px solid #007bff;
    }

    strong {
        color: #007bff;
    }

    .choti-width {
        width: 50px;
    }
</style>

<?php
$categoryQuery = "SELECT * FROM tbl_category";
$categoryResult = $conn->query($categoryQuery);
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 5;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$categoryQuery = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
$productQuery = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$priceQuery = isset($_POST['price']) ? trim($_POST['price']) : '';

$sql = "SELECT 
    COUNT(*) OVER() AS total_records,
    p.pro_id,
    p.name AS product_name,
    p.price,
    c.name AS category_name,
    pi.folder AS product_folder,
    COUNT(pi.pro_id) AS image_count
FROM 
    tbl_product p
JOIN 
    tbl_category c ON p.cat_id = c.cat_id
LEFT JOIN 
    tbl_product_images pi ON p.pro_id = pi.pro_id
WHERE 
    p.status = 1 AND (
        c.name LIKE '%$categoryQuery%' AND 
        p.name LIKE '%$productQuery%' AND 
        p.price LIKE '%$priceQuery%'
    )
GROUP BY p.pro_id, p.name, p.price, c.name, pi.folder
ORDER BY p.pro_id
LIMIT $limit OFFSET $offset;";

$result = $conn->query($sql);

// Get total records from the first row
$totalRecords = $result->num_rows > 0 ? $result->fetch_assoc()['total_records'] : 0;
$totalPages = ceil($totalRecords / $limit);
$result->data_seek(0);
?>

<?php

// Check if the form is submitted and files are uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    // Get the product ID from POST
    $productId = $_POST['productId'];

    // Define the target directory for uploaded images
    $targetDir = "uploads/products/" . $productId . "/";

    // Create the target directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); 
    }

    
    $existingImages = count(glob($targetDir . "*.*"));
    $maxImages = 5; 

    
    $remainingImages = $maxImages - $existingImages;

    // Get the number of images selected for upload
    $selectedImages = count($_FILES['images']['name']);

    // Check if the selected images exceed the remaining space
    if ($selectedImages > $remainingImages) {
        $_SESSION['error'] = "You can only upload " . $remainingImages . " more image(s). Please select fewer images.";
        header("Location: product.php");
        exit;
    }

    $imageCount = 0;
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']; 

    // Process each file in the upload array
    foreach ($_FILES['images']['name'] as $key => $name) {
        if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['images']['tmp_name'][$key];
            $fileName = basename($name);
            $targetFilePath = $targetDir . $fileName;

            
            $imageMimeType = mime_content_type($tmpName); 

            if (!in_array($imageMimeType, $allowedMimeTypes)) {
                $_SESSION['error'] = "Only image files (JPEG, PNG, GIF, WebP) are allowed.";
                header("Location: product.php");
                exit;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                
                $sql = "INSERT INTO tbl_product_images (filename, folder, pro_id) 
                        VALUES ('$fileName', '$targetDir', $productId)";
                
                if ($conn->query($sql)) {
                    $imageCount++;
                }
            }
        } 
        else 
        {
            $_SESSION['error'] = "An error occurred while uploading the file.";
            header("Location: product.php");
            exit;
        }
    }

    // After processing the images
    if ($imageCount > 0) {
        $_SESSION['message'] = "Images uploaded successfully!";
    } else {
        $_SESSION['error'] = "No valid images were uploaded.";
    }

   
    header("Location: product.php");
    exit;
}
?>

<div class="w3-main">
    <div class="table-container">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div id='message' class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        } elseif (isset($_SESSION['error'])) {
            echo "<div id='message' class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="d-flex">
                            <!-- Category Dropdown -->
                            <select name="category_name" class="form-control me-2">
                                <option value="">Select Category</option>
                                <?php while ($category = $categoryResult->fetch_assoc()): ?>
                                    <option value="<?php echo $category['name']; ?>" <?php echo ($categoryQuery == $category['name']) ? 'selected' : ''; ?>>
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>

                            <!-- Product Name Input -->
                            <input type="text" name="product_name" value="<?php echo htmlspecialchars($productQuery); ?>" placeholder="Product Name" class="form-control me-2">

                            <!-- Price Input -->
                            <input type="text" name="price" value="<?php echo htmlspecialchars($priceQuery); ?>" placeholder="Price" class="form-control me-2">

                            <button type="submit" class="btn btn-primary">Search</button>
                            <button class="btn btn-outline-secondary ms-2" style="margin-left: 5px;">
                                <a href="product.php" class="text-decoration-none text-reset">Reset</a>
                            </button>
                        </form>
                    </div>
                    <div>
                        <a href="add_product.php" class="btn btn-primary">Add Product</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price($)</th>
                    <th>Images</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['pro_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <?php echo $row['image_count']; ?> image(s)
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['pro_id']; ?>" class="btn btn-warning">Edit</a>
                                <button class="btn btn-info" data-toggle="modal" data-target="#uploadImagesModal"
                                    data-id="<?php echo $row['pro_id']; ?>"
                                    data-existing-images="<?php echo $row['image_count']; ?>"
                                    data-max-images="<?php echo 5 - $row['image_count']; ?>">
                                    Upload Images
                                </button>

                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $row['pro_id']; ?>)">Block</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="d-flex">
                <input type="hidden" name="category_name" value="<?php echo htmlspecialchars($categoryQuery); ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productQuery); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($priceQuery); ?>">
                <nav aria-label="...">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <button type="submit" name="page" value="<?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </button>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </form>
        </div>
    </div>
</div>

<!-- Upload Image Modal -->
<div class="modal fade" id="uploadImagesModal" tabindex="-1" role="dialog" aria-labelledby="uploadImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImagesModalLabel">Upload More Images for Product ID: <span id="modalProductId"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadImagesForm" action="product.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="images">Upload Images (max <span id="maxImages"></span> more)</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                    <input type="hidden" name="productId" id="hiddenProductId">
                    <button type="submit" class="btn btn-primary">Upload Images</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
                <div id="uploadMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal script for handling image upload
    $(document).ready(function() {
        $('#uploadImagesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var productId = button.data('id'); // Extract product ID
            var existingImages = button.data('existing-images'); // Number of existing images
            var maxImages = button.data('max-images'); // Remaining images that can be uploaded

            // Update the modal's content
            var modal = $(this);
            modal.find('#modalProductId').text(productId); // Show Product ID in the title
            modal.find('#maxImages').text(maxImages); // Show remaining images in the form
            modal.find('#hiddenProductId').val(productId); // Set the hidden input with product ID
        });
    });
    function confirmDelete(productId) {
        if (confirm("Are you sure you want to block this product?")) {
            window.location.href = "delete_product.php?id=" + productId;
        }
    }
</script>

<?php include 'layout/footer.php'; ?>