

<?php $__env->startSection('content'); ?>

<div class="w3-main row justify-content-center mt-5" style="margin-top: 100px;">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body" style="color: green;">
                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/dashboard.blade.php ENDPATH**/ ?>