<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Monthly Report Table -->
    <h3>Report for Year: <?php echo e($yearQuery); ?></h3>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(\Carbon\Carbon::create()->month($month)->format('F')); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $structuredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $months): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category); ?></td>
                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($value); ?></td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Total Report Table -->
    <h4 class="text-center mt-5">Total for All Categories</h4>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $structuredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $months): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category); ?></td>
                    <td>
                        <?php
                            $total = 0;
                            // Sum the values across all 12 months
                            foreach ($months as $month => $value) {
                                $total += $value;
                            }
                        ?>
                        <?php echo e($total); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>

</html>
<?php /**PATH F:\tayyab\example-app\resources\views/admin/pdf_report.blade.php ENDPATH**/ ?>