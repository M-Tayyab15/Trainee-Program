<?php
include 'connection.php'; // Ensure this file contains correct database connection code
include 'Eheader.php';

// Ensure that product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to fetch product details based on product_id
    $sql = "
        SELECT p.pro_id, p.name, p.price, p.description, c.name AS category_name, pi.filename, pi.folder, pi.priority
        FROM tbl_product p
        JOIN tbl_category c ON p.cat_id = c.cat_id
        LEFT JOIN tbl_product_images pi ON p.pro_id = pi.pro_id
        WHERE p.pro_id = ? AND p.status = 1
    ";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $product_id);  // Bind the product_id parameter
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch product details
        if ($result->num_rows > 0) {
            $product = [];
            $images = [];
            while ($row = $result->fetch_assoc()) {
                $product['pro_id'] = $row['pro_id'];
                $product['name'] = $row['name'];
                $product['price'] = $row['price'];
                $product['description'] = $row['description'];
                $product['category_name'] = $row['category_name'];

                // Collect images and check priority
                if ($row['priority'] == 'H') {
                    $product['main_image'] = $row['folder'] . '/' . $row['filename'];
                } else {
                    $images[] = $row['folder'] . '/' . $row['filename'];
                }
            }
        } else {
            echo "Product not found.";
            exit;
        }

        $stmt->close(); // Close the statement after execution
    } else {
        // If preparing the query failed, output the error
        echo "Error preparing query: " . $conn->error;
        exit;
    }
} else {
    echo "Product ID not provided.";
    exit;
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles for the page */
        .product-gallery {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: 500px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .product-gallery img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .product-gallery img.selected {
            border: 3px solid #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .small-image {
            width: 90px;
            height: auto;
            object-fit: cover;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .small-image.selected {
            border: 2px solid #007bff;
            transform: scale(1.1);
        }

        .product-card {
            border: 1px solid #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }

        /* Button Hover Effect */
        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.1);
        }

        .btn-primary,
        .btn-secondary {
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .small-images-container {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 10px 0;
        }

        .small-images-container::-webkit-scrollbar {
            height: 5px;
        }

        .small-images-container::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="row">
            <!-- Product Main Image -->
            <div class="col-md-6 d-flex justify-content-center mb-4 mb-md-0">
                <div class="product-gallery">
                    <img id="main-image" src="<?php echo $product['main_image']; ?>" class="main-image" alt="Product Image">
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-md-6">
                <div class="product-card">
                    <h3 class="price"><?php echo number_format($product['price'], 2); ?>$</h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <!-- <a href="carousel.php" class="btn btn-secondary">Go Back</a> -->
                </div>

                <div class="mt-4">
                    <h5>Other Images</h5>
                    <div class="small-images-container">
                        <!-- Add the main image as a clickable thumbnail -->
                        <img src="<?php echo $product['main_image']; ?>" class="small-image selected" alt="Main Image Thumbnail" data-full-size="<?php echo $product['main_image']; ?>">

                        <?php if (!empty($images)): ?>
                            <?php foreach ($images as $image): ?>
                                <img src="<?php echo $image; ?>" class="small-image" alt="Product Thumbnail" data-full-size="<?php echo $image; ?>">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No additional images available.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Enhanced Add to Cart Button -->
                <a href="add_to_cart.php?product_id=<?php echo $product['pro_id']; ?>" class="btn btn-success mb-2 col-md-6 d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                </a>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Set the main image and add click event for all small images (thumbnails)
            $(".small-image").on("click", function() {
                // Get the full-size image URL from the clicked thumbnail's data attribute
                var newImageSrc = $(this).data("full-size");

                // Update the main image with the new source
                $("#main-image").attr("src", newImageSrc);

                // Remove the 'selected' class from all small images
                $(".small-image").removeClass("selected");

                // Add the 'selected' class to the clicked small image
                $(this).addClass("selected");
            });

            // Make the first thumbnail (the main image) selected by default
            $(".small-image").first().addClass("selected");
        });
    </script>

    <div style="margin-top:50px">
        <?php include 'Efooter.php'; ?>
    </div>
</body>

</html>
