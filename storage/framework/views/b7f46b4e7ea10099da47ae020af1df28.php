<?php $__currentLoopData = ['football', 'cricket', 'tennis', 'hockey', 'badminton']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="container-fluid" style="background-color: white;">

    <div id="<?php echo e($category); ?>Carousel" class="carousel slide product-carousel" data-bs-ride="carousel">
        <h2 class="carousel-name"><?php echo e(ucfirst($category)); ?> Products</h2>
        <div class="carousel-inner">
            <?php $__currentLoopData = ${$category . 'Products'}->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel-item <?php if($loop->first): ?> active <?php endif; ?>">
                <div class="row">
                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 product-carousel-item">
                        <div class="card bg-light">
                            <?php
                            // Get the first "H" priority image for the product
                            $image = $product->images->firstWhere('priority', 'H');
                            ?>
                            <?php if($image): ?>
                            <img src="<?php echo e(url($image->folder . '/' . $image->filename)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                            <img src="<?php echo e(url('images/default-product.jpg')); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title"><?php echo e($product->name); ?></h5>
                                    <p class="card-price mb-0"><?php echo e($product->price); ?>$</p>
                                </div>
                                <p class="card-text">
                                    <?php echo e(Str::limit($product->description, 60)); ?>

                                </p>
                                <a href="<?php echo e(route('product.show', ['productId' => encrypt($product->pro_id)])); ?>" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo e($category); ?>Carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo e($category); ?>Carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH F:\tayyab\example-app\resources\views/components/othercarousel.blade.php ENDPATH**/ ?>