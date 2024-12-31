<!-- resources/views/product/details.blade.php -->

 <!-- Assuming you're using a layout file for common HTML structure -->

<?php $__env->startSection('title', $product->name . ' - Product Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo e($product->name); ?></h1>
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

            <!-- Enhanced Add to Cart Button -->
            <a href="<?php echo e(route('cart.add', ['product_id' => $product->id])); ?>" class="btn btn-success mb-2 col-md-6 d-flex align-items-center justify-content-center">
                <i class="bi bi-cart-plus me-2"></i> Add to Cart
            </a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/details.blade.php ENDPATH**/ ?>