

<?php $__env->startSection('content'); ?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="w3-main" style="margin-top: 100px;">
        <div class="container mt-5">
            <h2>Edit Product</h2>

            <!-- Display error messages if validation fails -->
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Display success message if product is updated successfully -->
            <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <form action="<?php echo e(route('products.update', $product->pro_id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="<?php echo e(old('product_name', $product->name)); ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="<?php echo e(old('price', $product->price)); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->cat_id); ?>" <?php echo e($category->cat_id == old('category_id', $product->cat_id) ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description (optional)</label>
                    <textarea name="description" class="form-control"><?php echo e(old('description', $product->description)); ?></textarea>
                </div>

                <!-- Popularity Field -->
                <div class="form-group form-check">
                    <input type="checkbox" name="popularity" class="form-check-input" value="1" <?php echo e(old('popularity', $product->popularity) == 1 ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="popularity">Set as Popular</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/products/edit.blade.php ENDPATH**/ ?>