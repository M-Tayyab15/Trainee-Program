<?php
include 'connection.php';

// Fetch categories and image paths
$sql_categories = "SELECT cat_id, name, img_path FROM tbl_category WHERE status = 1";
$result_categories = $conn->query($sql_categories);

$categories = [];
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    echo "No categories found";
}

// Fetch product images with product names
$sql_images = "
    SELECT pi.filename, pi.folder, p.cat_id, p.pro_id, p.name AS product_name, p.price, p.description, c.name AS category_name
    FROM tbl_product_images pi
    JOIN tbl_product p ON pi.pro_id = p.pro_id
    JOIN tbl_category c ON p.cat_id = c.cat_id
    WHERE p.status = 1 AND p.cat_id IN (1, 2, 3, 4, 5)
    AND pi.priority = 'H';
";
$result_images = $conn->query($sql_images);

$product_images = [];
if ($result_images->num_rows > 0) {
    while ($row = $result_images->fetch_assoc()) {
        $product_images[] = $row;
    }
} else {
    echo "No product images found";
}

// Fetch hot products (popularity = 1)
$sql_hot_products = "
    SELECT pi.filename, pi.folder, p.pro_id, p.name AS product_name, p.price, p.description, p.popularity
    FROM tbl_product_images pi
    JOIN tbl_product p ON pi.pro_id = p.pro_id
    WHERE p.status = 1 AND p.popularity = 1 AND pi.priority = 'H';
";
$result_hot_products = $conn->query($sql_hot_products);

$hot_products = [];
if ($result_hot_products->num_rows > 0) {
    while ($row = $result_hot_products->fetch_assoc()) {
        $hot_products[] = $row;
    }
} else {
    echo "No hot products found";
}

$conn->close();
include 'Eheader.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Image Carousel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f8ff;
            /* Alice Blue */
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .carousel-inner {
            display: flex;
            align-items: center;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }

        .carousel-control-prev {
            margin-left: 10px;
        }

        .carousel-control-next {
            margin-right: 10px;
        }

        .carousel {
            margin-bottom: 40px;
        }

        .carousel-container {
            display: flex;
            flex-direction: column;
            /* Stack carousels vertically */
            gap: 20px;
            /* Space between carousels */
            margin-top: 30px;
            /* Adjust top margin */
        }

        .carousel-item-small {
            width: 100%;
            /* Ensure each small carousel takes full width */
        }

        .carousel-name {
            /* text-align: center; */
            font-size: 1.6rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .carousel-small {
            width: 100%;
            /* Ensure the carousel takes full width */
        }

        .carousel-small img {
            height: 150px;
            /* Set a fixed height for images */
            object-fit: cover;
            /* Keep aspect ratio */
        }

        .carousel-item-small .d-flex {
            display: flex;
            /* Use flexbox for horizontal layout */
            justify-content: space-between;
            /* Space out images evenly */
        }

        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: fill;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .btn-show-details {
            margin-top: 10px;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Optional: For better styling of anchor links */
        a {
            text-decoration: none;
        }

        /* Styling for category buttons */
        .btn-category {
            font-size: 1rem;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            border: 2px solid #007bff;
            transition: background-color 0.3s, transform 0.3s ease;
            text-decoration: none;
        }

        .btn-category:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .btn-category:focus {
            outline: none;
        }

        .btn-category:active {
            transform: translateY(2px);
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            /* Increased height for better visibility */
            transition: transform 0.5s ease-in-out;
            /* Smooth transition for zoom effect */
        }


        /* Fade-in effect for captions */
        .carousel-item.active .carousel-caption {
            opacity: 1;
        }



        /* Additional padding for carousel */
        .carousel-inner {
            padding: 10px 0;
        }

        /* Ensure category buttons look like navbar links */
        .navbar-btn {
            font-size: 1rem;
            font-weight: bold;
            background-color: transparent;
            color: white;
            border: none;
            padding: 8px 20px;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.3s ease;
            border-radius: 25px;
            text-decoration: none;
        }

        .navbar-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Light hover effect */
            transform: translateY(-3px);
        }

        .navbar-btn:focus {
            outline: none;
        }

        .navbar-btn:active {
            transform: translateY(2px);
            /* Slight button press effect */
        }

        /* Make the main carousel full width */
        .carousel {
            width: 100%;
            max-width: 100%;
            margin-bottom: 40px;
        }

        /* Carousel Control buttons (Prev/Next) */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #333;
            /* Dark color for the icons */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            transition: background-color 0.3s ease;
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: #555;

        }

        /* Pagination Dots */
        .carousel-indicators button {
            background-color: #333;
            /* Dark color for the pagination dots */
            border-radius: 50%;
            width: 20px;
            height: 2px;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .carousel-indicators .active {
            background-color: #555;
            /* Lighter shade when the dot is active */
        }

        .carousel-indicators button:hover {
            background-color: #555;
            /* Hover effect for pagination dots */
        }

        .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px;
    height: 100%;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin: 0;
}

.card-price {
    font-size: 1.1rem;
    font-weight: bold;
    color: #007bff;
    margin-left: 10px;
}

.card-text {
    font-size: 0.9rem;
    color: #555;
    margin-top: 10px;
}

.btn-show-details {
    margin-top: auto;
    margin-top: 15px;
    font-weight: bold;
}

    </style>
</head>

<body>

    <div class="container-fluid">
        <!-- Main carousel -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $activeClass = "active";
                foreach ($categories as $category) {
                    $imagePath = $category['img_path'];
                    // Check if the category has a valid img_path before displaying
                    if (!empty($imagePath)) {
                        $categoryName = htmlspecialchars($category['name']);
                        $categoryId = $category['cat_id']; // Store the category ID

                        echo '<div class="carousel-item ' . ($activeClass ? 'active' : '') . '">';
                        echo '<a href="#category-' . $categoryId . '">';
                        echo '<img src="' . $imagePath . '" class="d-block w-100" alt="' . $categoryName . '" style="height:550px">';
                        echo '</a>';
                        echo '</div>';

                        $activeClass = "";
                    }
                }
                ?>
            </div>
            <!-- Pagination dots -->
            <div class="carousel-indicators">
                <?php
                $i = 0;
                foreach ($categories as $category) {
                    if (!empty($category['img_path'])) { // Check if img_path exists
                        echo '<button type="button" data-bs-target="#carouselExample" data-bs-slide-to="' . $i . '" class="' . ($i == 0 ? 'active' : '') . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                        $i++;
                    }
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>



        <!-- <div class="d-flex justify-content-center mt-4">
            Category buttons
            <?php foreach ($categories as $category): ?>
                <a href="#category-<?php echo $category['cat_id']; ?>" class="btn btn-category mx-2">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div> -->


        <!-- Hot Products Carousel -->
<!-- Hot Products Carousel -->
<div class="text-center my-4">
    <h2 style="color: red;"><i class="bi bi-fire"></i> Hot Products</h2>
</div>
<div id="hotProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $activeClass = "active";
                $hotProductCount = count($hot_products);
                for ($i = 0; $i < $hotProductCount; $i += 3): ?>
                    <div class="carousel-item <?php echo ($activeClass ? 'active' : ''); ?>">
                        <div class="d-flex justify-content-between">
                            <?php
                            for ($j = 0; $j < 3; $j++) {
                                if (isset($hot_products[$i + $j])) {
                                    $product = $hot_products[$i + $j];
                                    $productName = $product['product_name'];
                                    $productId = $product['pro_id'];
                                    $imagePath = $product['folder'] . '/' . $product['filename'];
                                    $price = $product['price'];
                                    $description = $product['description'];
                                    $shortDescription = strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
                                    ?>
                                    <div class="card" style="width: 30%; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo $productName; ?>" style="height: 400px;">
                                        <div class="card-body" style="flex-grow: 1;">
                                            <h5 class="card-title"><?php echo $productName; ?></h5>
                                            <p class="card-price"><strong><?php echo $price; ?>$</strong></p>
                                            <p class="card-text"><?php echo $shortDescription; ?></p>
                                            <a href="product-details.php?product_id=<?php echo $productId; ?>" class="btn btn-primary btn-show-details">Show Details</a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                    $activeClass = "";
                endfor;
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#hotProductsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hotProductsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Small carousels displayed vertically -->
        <div class="carousel-container">
            <?php
            // Loop through categories for small carousels
            $category_ids = [1, 2, 3, 4, 5]; // assuming these are the category IDs
            foreach ($category_ids as $cat_id):
                $category_name = ""; // Initialize category name
                switch ($cat_id) {
                    case 1:
                        $category_name = "Football";
                        break;
                    case 2:
                        $category_name = "Cricket";
                        break;
                    case 3:
                        $category_name = "Tennis";
                        break;
                    case 4:
                        $category_name = "Hockey";
                        break;
                    case 5:
                        $category_name = "Badminton";
                        break;
                }
            ?>

                <div id="category-<?php echo $cat_id; ?>" class="carousel-item-small">
                    <div class="carousel-name"><?php echo $category_name; ?></div>
                    <div id="carouselExampleSmall<?php echo $cat_id; ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner carousel-small">
                            <?php
                            // Fetch images and product names for the specific category
                            $activeClass = "active";
                            $imagesToShow = []; // Array to hold images for this category
                            foreach ($product_images as $image) {
                                if ($image['cat_id'] == $cat_id) {
                                    $imagePath = $image['folder'] . '/' . $image['filename'];
                                    $imagesToShow[] = $image; // Store the image path
                                }
                            }


                            for ($i = 0; $i < count($imagesToShow); $i += 3):
                            ?>
                                <div class="carousel-item <?php echo ($activeClass ? 'active' : ''); ?>">
                                    <div class="d-flex justify-content-between"> <!-- Flexbox to align images horizontally -->
                                        <?php for ($j = 0; $j < 3; $j++): ?>
                                            <?php if (isset($imagesToShow[$i + $j])): ?>
                                                <?php
                                                $productName = $imagesToShow[$i + $j]['product_name'];
                                                $productId = $imagesToShow[$i + $j]['pro_id'];
                                                $imagePath = $imagesToShow[$i + $j]['folder'] . '/' . $imagesToShow[$i + $j]['filename'];
                                                $price = $imagesToShow[$i + $j]['price']; // Get the product price
                                                $description = $imagesToShow[$i + $j]['description']; // Get the product description
                                                $shortDescription = strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description; // Truncate description
                                                ?>
                                                <div class="card" style="width: 30%; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                                                    <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo $productName; ?>" style="height: 400px;">
                                                    <div class="card-body" style="flex-grow: 1;">
                                                        <div class="d-flex align-items-baseline" style="justify-content: space-around;">
                                                            <h5 class="card-title"><?php echo $productName; ?></h5>
                                                            <p class="card-price"><strong><?php echo $price; ?>$</strong></p>
                                                        </div>
                                                        <p class="card-text"><?php echo $shortDescription; ?></p> <!-- Show brief description -->
                                                        <a href="product-details.php?product_id=<?php echo $productId; ?>" class="btn btn-primary btn-show-details">Show Details</a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>


                            <?php
                                $activeClass = "";
                            endfor;
                            ?>
                        </div> <!-- Close carousel-inner -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSmall<?php echo $cat_id; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSmall<?php echo $cat_id; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div> <!-- Close carousel -->
                </div> <!-- Close category carousel-item-small -->

            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
<?php include 'Efooter.php'; ?>

</html>