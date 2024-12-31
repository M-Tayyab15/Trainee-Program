<!-- resources/views/orders/index.blade.php -->



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

        .table td {
            background-color: white;
            text-align: center;
        }

        .choti-width {
            width: 50px;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal-dialog {
            max-width: 80%;
            margin: 30px auto;
        }

        .modal-content {
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }

        .modal-body {
            padding: 15px;
        }


        .modal-body img {
            max-width: 100%;
            height: auto;
        }


        .table {
            margin-bottom: 0;

            width: 100%;
            table-layout: fixed;

        }

        .modal-body .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .modal-body .card img {
            border-radius: 8px;
            max-height: 100px;
            object-fit: cover;
        }


        .modal-body .card-body {
            padding: 15px;
        }

        .modal-body .card-title {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <div class="w3-main" style="margin-top: 100px;">
        <?php if(session('message')): ?>
        <div id="message" class="alert alert-success">
            <?php echo e(session('message')); ?>

        </div>
        <?php elseif(session('error')): ?>
        <div id="message" class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-body">
                <form action="<?php echo e(url('admin/orders')); ?>" method="get" class="d-flex">
                    <input type="text" name="id" value="<?php echo e(old('id', $idQuery)); ?>" placeholder="Order ID" class="form-control me-2">
                    <input type="text" name="email" value="<?php echo e(old('email', $emailQuery)); ?>" placeholder="Email" class="form-control me-2">

                    <input type="number" name="min_price" value="<?php echo e(old('min_price', $minPrice)); ?>" placeholder="Min Price" class="form-control me-2">
                    <input type="number" name="max_price" value="<?php echo e(old('max_price', $maxPrice)); ?>" placeholder="Max Price" class="form-control me-2">

                    <button type="submit" class="btn btn-primary">Search</button>
                    <button class="btn btn-outline-secondary ms-2" style="margin-left: 5px;">
                        <a href="<?php echo e(url('admin/orders')); ?>" class="text-decoration-none text-reset">Reset</a>
                    </button>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Payment Mode</th>
                    <th>Created On</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($order->cart_id); ?></td>
                    <td><?php echo e($order->user->email); ?></td>
                    <td>
                        <?php switch($order->status):
                        case (1): ?>
                        <?php case (null): ?>
                        <span class="badge badge-warning">Pending</span>
                        <?php break; ?>
                        <?php case (2): ?>
                        <span class="badge badge-primary">In Progress</span>
                        <?php break; ?>
                        <?php case (3): ?>
                        <span class="badge badge-success">Completed</span>
                        <?php break; ?>
                        <?php default: ?>
                        <span class="badge badge-warning">Pending</span>
                        <?php endswitch; ?>
                    </td>
                    <td><?php echo e(number_format($order->total_amount, 2)); ?></td>
                    <td><?php echo e($order->payment_mode); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($order->created_on)->setTimezone('Asia/Karachi')->format('d-m-Y h:i A')); ?></td>
                    <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo e($order->cart_id); ?>">Details</button></td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="detailsModal<?php echo e($order->cart_id); ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?php echo e($order->cart_id); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel<?php echo e($order->cart_id); ?>">Order Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modalContent<?php echo e($order->cart_id); ?>">
                                <p><strong>Order ID:</strong> <?php echo e($order->cart_id); ?></p>
                                <p><strong>Total Amount:</strong> <?php echo e(number_format($order->total_amount, 2)); ?></p>
                                <p><strong>Payment Mode:</strong> <?php echo e($order->payment_mode); ?></p>
                                <p><strong>Status:</strong> <?php echo e($order->status == 1 ? 'Pending' : ($order->status == 2 ? 'In Progress' : 'Completed')); ?></p>
                                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($order->updated_on)->format('d-m-Y')); ?></p>

                                <p><strong>Products:</strong></p>
                                <div class="row">
                                    <?php $__currentLoopData = $order->cartProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo e($cartProduct->product->name); ?></h5>
                                                <p><strong>Price:</strong> <?php echo e(number_format($cartProduct->product->price, 2)); ?></p>
                                                <p><strong>Quantity:</strong> <?php echo e($cartProduct->quantity); ?></p>
                                                <p><strong>Total:</strong> <?php echo e(number_format($cartProduct->product->price * $cartProduct->quantity, 2)); ?></p>
                                                <?php
                                                $image = $cartProduct->product->images->where('priority', 'H')->first();
                                                ?>

                                                <?php if($image): ?>
                                                <img src="<?php echo e(url($image->folder . '/' . $image->filename)); ?>" class="img-fluid" alt="<?php echo e($cartProduct->product->name); ?>" width="100">
                                                <?php else: ?>
                                                <p>No image available</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">No Orders Found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo e($orders->onFirstPage() ? 'disabled' : ''); ?>">
                    <a class="page-link" href="<?php echo e($orders->previousPageUrl()); ?>&id=<?php echo e($idQuery); ?>&email=<?php echo e($emailQuery); ?>&min_price=<?php echo e($minPrice); ?>&max_price=<?php echo e($maxPrice); ?>" aria-label="Previous">Previous</a>
                </li>
                <?php for($i = 1; $i <= $orders->lastPage(); $i++): ?>
                    <li class="page-item <?php echo e($i == $orders->currentPage() ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e(url('admin/orders')); ?>?page=<?php echo e($i); ?>&id=<?php echo e($idQuery); ?>&email=<?php echo e($emailQuery); ?>&min_price=<?php echo e($minPrice); ?>&max_price=<?php echo e($maxPrice); ?>"><?php echo e($i); ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($orders->hasMorePages() ? '' : 'disabled'); ?>">
                        <a class="page-link" href="<?php echo e($orders->nextPageUrl()); ?>&id=<?php echo e($idQuery); ?>&email=<?php echo e($emailQuery); ?>&min_price=<?php echo e($minPrice); ?>&max_price=<?php echo e($maxPrice); ?>" aria-label="Next">Next</a>
                    </li>
            </ul>
        </nav>
    </div>
</body>
<script>
    // Function to load order details into the modal using AJAX
    function loadOrderDetails(cart_id) {
        let modalContent = document.getElementById('modalContent' + cart_id);

        // Make an AJAX request to fetch the order details
        fetch('/order_details?cart_id=' + cart_id)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
            })
            .catch(error => {
                modalContent.innerHTML = '<p>Error loading details.</p>';
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/admin/orders.blade.php ENDPATH**/ ?>