<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="w3-light-grey">
    <div id="app">
        <div class="w3-container" style="display: flex;">
        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="w3-container w3-margin-left" style="flex-grow: 1;">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH F:\tayyab\example-app\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>