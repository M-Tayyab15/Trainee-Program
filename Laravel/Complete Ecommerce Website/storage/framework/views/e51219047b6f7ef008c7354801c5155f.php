


<?php $__env->startSection('content'); ?>

<div class="w3-main row justify-content-center mt-5" style="margin-top: 100px;">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Admin Dashboard</div>
            <div class="card-body">
                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success" style="color: green;">
                        <?php echo e($message); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-success">
                        You are logged in!
                    </div>       
                <?php endif; ?>                
            </div>
        </div>
    </div>    
</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/admin/admindashboard.blade.php ENDPATH**/ ?>