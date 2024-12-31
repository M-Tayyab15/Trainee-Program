

<?php $__env->startSection('content'); ?>

<head>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

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
            padding: 15px;
        }

        .modal-footer .btn {
            margin: 0 5px;
        }

        .modal-body {
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 0.5rem;
            background-color: #f9f9f9;
        }

        .modal-body div {
            margin-bottom: 15px;
        }

        .modal-body strong {
            color: #007bff;
        }

        .modal-body img {
            border-radius: 8px;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .modal-dialog {
            max-width: 800px;
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

        .choti-width {
            width: 50px;
        }

        .modal-body .col-md-6 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .modal-body .col-md-4 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .modal-body img {
            border-radius: 8px;
            width: 250px;
            height: 200px;
            object-fit: cover;
            display: flex;
        }
    </style>
</head>

<body>

    <div class="w3-main" style="margin-top: 100px;">
        <div class="table-container">
            <?php if(session('message')): ?>
            <div id="message" class="alert alert-success"><?php echo e(session('message')); ?></div>
            <?php elseif(session('error')): ?>
            <div id="message" class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="<?php echo e(route('manageusers')); ?>" method="get" class="d-flex">
                                <input type="text" name="name" value="<?php echo e(old('name', $nameQuery)); ?>" placeholder="Name" class="form-control me-2">
                                <input type="text" name="email" value="<?php echo e(old('email', $emailQuery)); ?>" placeholder="Email" class="form-control me-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn btn-outline-secondary ms-2"><a href="<?php echo e(route('manageusers')); ?>" class="text-decoration-none text-reset">Reset</a></button>
                            </form>
                        </div>
                        <div>
                            <a href="<?php echo e(url('admin/add-user')); ?>" class="btn btn-primary">Add User</a>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Country</th>
                        <!-- <th>Details</th> -->
                        <th>Action</th>
                        <th>Attachments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($user->id); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e(optional($user->profile)->phone ?? 'N/A'); ?></td>
                        <td><?php echo e($user->profile->country ?? 'N/A'); ?></td>
                        <!-- <td> -->
                        <!-- Details Button Triggering Modal -->
                        <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#userDetailsModal<?php echo e($user->id); ?>">Details</button>
                        </td> -->
                        <td>
                            <a href="<?php echo e(route('edituser', ['encrypted_id' => $user->encrypted_id])); ?>" class="btn btn-warning">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="confirmDeactivate(<?php echo e($user->id); ?>)">Delete</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal" onclick="setUserId(<?php echo e($user->id); ?>)">
                                Upload File
                            </button>

                        </td>
                        <td>
                            <?php if($user->status == 1 && $user->fileExists): ?>
                            <a href="<?php echo e(route('file.download', ['userId' => $user->id, 'fileName' => $user->fileName])); ?>" class="btn btn-success" download>Download</a>
                            <?php elseif($user->status != 1): ?>
                            <span>Status is not active</span>
                            <?php else: ?>
                            <span>No attachments found</span>
                            <?php endif; ?>
                        </td>
                    </tr>


                    <!-- Modal for User Details
                    <div class="modal fade" id="userDetailsModal<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel<?php echo e($user->id); ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userDetailsModalLabel<?php echo e($user->id); ?>">User Details - <?php echo e($user->name); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Name:</strong> <?php echo e($user->name); ?></div>
                                        <div class="col-md-6"><strong>ID:</strong> <?php echo e($user->id); ?></div>
                                        <div class="col-md-6"><strong>Email:</strong> <?php echo e($user->email); ?></div>
                                        <div class="col-md-6"><strong>Country:</strong> <?php echo e($user->profile->country ?? 'N/A'); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><strong>State:</strong> <?php echo e($user->profile->state ?? 'N/A'); ?></div>
                                        <div class="col-md-6"><strong>Address:</strong> <?php echo e($user->profile->address ?? 'N/A'); ?></div>
                                        <div class="col-md-6"><strong>Phone Number:</strong> <?php echo e($user->profile->phone ?? 'N/A'); ?></div>
                                        <div class="col-md-6"><strong>IP Address:</strong> <?php echo e($user->profile->ip_address ?? 'N/A'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"><strong>Profile Picture:</strong>
                                            <?php if($user->pic): ?>
                                            <img src="<?php echo e(Storage::url($user->pic->path)); ?>" alt="User Picture">
                                            <?php else: ?>
                                            N/A
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <!-- Modal for Deletion Confirmation -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <!-- Updated button here with correct onclick handler -->
                                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for file upload -->
                    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="fileUploadForm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('uploadFile')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="file" name="file" id="fileInput" class="form-control" accept=".pdf,.docx,.doc">
                                        <input type="hidden" id="user_id" name="user_id">
                                    </form>
                                    <div id="uploadError" class="text-danger"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" form="fileUploadForm">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <ul class="pagination pagination-sm">
                    <?php echo e($users->links('pagination::bootstrap-4')); ?>

                </ul>
            </div>
        </div>
    </div>

    <script>
        function confirmDeactivate(userId) {
            // Attach the correct delete URL to the button
            const deleteButton = document.getElementById('confirmDeleteButton');
            deleteButton.onclick = function() {

                window.location.href = "/admin/deactivate-user/" + userId;
            };

            // Show the confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        function setUserId(userId) {
            document.getElementById('user_id').value = userId;
        }
    </script>

    <script src="<?php echo e(asset('assets/plugins/chartjs/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/chartjs/dashboard.js')); ?>"></script>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/admin/manage-users.blade.php ENDPATH**/ ?>