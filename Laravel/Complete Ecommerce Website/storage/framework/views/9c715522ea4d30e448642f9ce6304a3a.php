

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Success!</h1>
    <p>Your payment method has been confirmed, and your order has been placed successfully.</p>
    <p>Thank you for shopping with us!</p>

    <hr>

    <h3>Details</h3>
    <p><strong>Name:</strong> <?php echo e(auth()->user()->name); ?></p>
    <p><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
    <p><strong>Phone:</strong> <?php echo e(auth()->user()->profile->phone ?? 'Not Provided'); ?></p>
    <p><strong>Address:</strong> <?php echo e(auth()->user()->profile->address ?? 'Not Provided'); ?></p>  

    <hr>

    <h3>Order Receipt</h3>

    <?php if($cart && $cart->cartProducts->isEmpty()): ?>
        <p>No items in your cart.</p>
    <?php elseif($cart): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cart->cartProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($cartProduct->product->name); ?></td>
                        <td><?php echo e($cartProduct->quantity); ?></td>
                        <td>$<?php echo e(number_format($cartProduct->product->price, 2)); ?></td>
                        <td>$<?php echo e(number_format($cartProduct->total_price, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>


        <div class="d-flex justify-content-end">
            <h4><strong>Total Amount: $<?php echo e(number_format($cart->cartProducts->sum('total_price'), 2)); ?></strong></h4>
        </div>
    <?php endif; ?>

    <hr>
    
    <div class="alert alert-success mt-3">
        <strong>Thank you!</strong> Your order has been successfully placed, and we will notify you once it is shipped.
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/success.blade.php ENDPATH**/ ?>