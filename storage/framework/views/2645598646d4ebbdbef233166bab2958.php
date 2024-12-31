

<?php $__env->startSection('content'); ?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <script src="<?php echo e(asset('assets/plugins/chartjs/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/chartjs/dashboard.js')); ?>"></script>
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
</head>

<body>

    <div class="w3-main">
        <div class="table-container">
            <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="d-flex">

                                <select name="category_name" class="form-control me-2">
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->name); ?>" <?php echo e(request('category_name') == $category->name ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>


                                <input type="text" name="product_name" value="<?php echo e(request('product_name')); ?>" placeholder="Product Name" class="form-control me-2">


                                <input type="text" name="price" value="<?php echo e(request('price')); ?>" placeholder="Price" class="form-control me-2">

                                <button type="submit" class="btn btn-primary">Search</button>
                                <button class="btn btn-outline-secondary ms-2">
                                    <a href="<?php echo e(route('products.index')); ?>" class="text-decoration-none text-reset">Reset</a>
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">Add Product</a>
                        </div>
                    </div>
                </div>
            </div>


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
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->pro_id); ?></td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category->name ?? 'No Category'); ?></td>
                        <td><?php echo e($product->price); ?></td>
                        <td><?php echo e($product->images_count); ?> image(s)</td>
                        <td>
                            <a href="<?php echo e(route('products.edit', $product->pro_id)); ?>" class="btn btn-warning">Edit</a>
                            
                            <button class="btn btn-info" data-toggle="modal" data-target="#uploadImagesModal"
                                data-id="<?php echo e($product->pro_id); ?>"
                                data-existing-images="<?php echo e($product->images_count); ?>"
                                data-max-images="<?php echo e(5 - $product->images_count); ?>">
                                Upload Images
                            </button>


                            <form id="blockForm" action="" method="POST" style="display: inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-danger block-btn" data-toggle="modal" data-target="#confirmationModal" data-action="<?php echo e(route('products.destroy', $product->pro_id)); ?>">
                                    Block
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5">No products found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>


            <div class="d-flex justify-content-between">
                <?php echo e($products->links('pagination::bootstrap-4')); ?>

            </div>
        </div>
    </div>

    <!-- Upload Images Modal -->
    <div class="modal fade" id="uploadImagesModal" tabindex="-1" aria-labelledby="uploadImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadImagesModalLabel">Upload Product Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('products.uploadImages', $product->pro_id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <input type="file" name="images[]" multiple>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to block this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="confirmationForm" method="POST" style="display: inline-block;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Yes, Block</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // jQuery to open the modal with the correct remaining images info
        $('#uploadImagesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // The button that triggered the modal
            var productId = button.data('id'); // Extract product ID
            var existingImages = button.data('existing-images'); // Existing images count
            var maxImages = button.data('max-images'); // Remaining images count

            // Set the product ID and the max number of images
            $('#product_id').val(productId);
            $('#max_images').val(maxImages);
            $('#remaining_images').text(maxImages);

            // Disable the file input if no images can be uploaded
            if (maxImages <= 0) {
                $('#images').prop('disabled', true);
                $('#upload_button').prop('disabled', true);
                alert('No more images can be uploaded for this product.');
            } else {
                $('#images').prop('disabled', false);
                $('#upload_button').prop('disabled', false);
            }
        });
    </script>

    <script>
        // jQuery to open the modal and set the correct form action dynamically
        $('.block-btn').on('click', function() {
            var actionUrl = $(this).data('action'); // Get the action URL for the product
            $('#confirmationForm').attr('action', actionUrl); // Set the form's action to the correct URL
        });
    </script>



</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/products/index.blade.php ENDPATH**/ ?>