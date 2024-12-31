<!-- resources/views/product/details.blade.php -->

 <!-- Assuming you're using a layout file for common HTML structure -->

<?php $__env->startSection('title', $product->name . ' - Product Details'); ?>

<?php $__env->startSection('content'); ?>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        /* Loader Style */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin-left:10px ;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn-loading {
            position: relative;
        }

        .btn-loading .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>

    <div class="container mt-5 mb-5">
        <!-- <h1 class="text-center mb-4"><?php echo e($product->name); ?></h1> -->
        <h1 class="text-center mb-4"> Product Details</h1>
        <div class="row">
            <!-- Product Main Image -->
            <div class="col-md-6 d-flex justify-content-center mb-4 mb-md-0">
                <div class="product-gallery">
                    <img id="main-image" src="<?php echo e(url($mainImage->folder . '/' . $mainImage->filename)); ?>" class="main-image" alt="Product Image">
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-md-6">
                <div class="product-card">
                    <h1 class="text-center mb-4"><?php echo e($product->name); ?></h1>
                    <h3 class="price"><?php echo e(number_format($product->price, 2)); ?>$</h3>
                    <p><strong>Category:</strong> <?php echo e($product->category->name); ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br(e($product->description)); ?></p>
                </div>

                <div class="mt-4">
                    <h5>Other Images</h5>
                    <div class="small-images-container">
                        <!-- Add the main image as a clickable thumbnail -->
                        <img src="<?php echo e(url($mainImage->folder . '/' . $mainImage->filename)); ?>" class="small-image selected" alt="Main Image Thumbnail" data-full-size="<?php echo e(url($mainImage->folder . '/' . $mainImage->filename)); ?>">

                        <?php $__currentLoopData = $otherImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(url($image->folder . '/' . $image->filename)); ?>" class="small-image" alt="Product Thumbnail" data-full-size="<?php echo e(url($image->folder . '/' . $image->filename)); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <form action="<?php echo e(route('cart.add', ['product_id' => $product->pro_id])); ?>" method="POST" id="add-to-cart-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success mt-3" style="display: flex;">
                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                        <div class="loader"></div>
                    </button>
                </form>


            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Set the main image and add click event for all small images (thumbnails)
            $(".small-image").on("click", function() {
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
    <!-- Add this script to handle the AJAX request -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var $submitButton = $(this).find("button[type='submit']");
        var $loader = $submitButton.find(".loader");
        $loader.show();
        $submitButton.prop("disabled", true);

        // AJAX request to add the product to the cart
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#cart-count').text(response.cartCount);

                
                setTimeout(function() {
                    $loader.hide(); 
                    $submitButton.prop("disabled", false); 
                }, 500); 
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    alert('An error occurred while adding the product to the cart.');
                }

                
                setTimeout(function() {
                    $loader.hide(); 
                    $submitButton.prop("disabled", false); 
                }, 500); 
            }
        });
    });
</script>


</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/products/details.blade.php ENDPATH**/ ?>