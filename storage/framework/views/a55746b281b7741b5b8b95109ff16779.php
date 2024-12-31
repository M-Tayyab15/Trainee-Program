

<?php $__env->startSection('content'); ?>

<!-- Bootstrap and custom styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .cart-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .cart-item img {
        width: 300px;
        height: auto;
        margin-right: 20px;
    }

    .cart-item .product-details {
        flex-grow: 1;
    }

    .cart-item .product-name {
        font-size: 1.6rem;
        font-weight: bold;
    }

    .cart-item .product-price {
        font-size: 1.3rem;
        margin-top: 5px;
        color: green;
        font-weight: bolder;
    }

    .cart-item .quantity-container {
        display: flex;
        flex-direction: column-reverse;
        align-items: flex-end;
        margin-top: 10px;
    }

    .cart-item .quantity-container input {
        width: 60px;
        margin-right: 10px;
    }

    .cart-item .total-price {
        font-weight: bold;
        font-size: 1.1rem;
        margin-top: 5px;
    }

    .total-price-container {
        display: flex;
        justify-content: flex-end;
        font-size: 1.3rem;
        font-weight: bold;
        margin-top: 20px;
    }

    /* Styles for user details form */
    #user-details-form {
        display: none;
        margin-top: 30px;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }

    .blurred {
        filter: blur(5px);
    }
    .product-details {
    margin: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.product-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
    max-width: 50%; 
}

.product-name {
    font-size: 1.2em;
    font-weight: bold;
}

.product-price {
    font-size: 1.1em;
    color: #333;
}

.product-description {
    font-size: 0.9em;
    color: #777;
    white-space: normal; 
    line-height: 1.4; 
    margin-top: 10px; 
    word-wrap: break-word; 
}

.quantity-container {
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: center;
}

.quantity-decrease,
.quantity-increase {
    padding: 5px 10px;
    font-size: 1.2em;
    border: 1px solid #ccc;
    cursor: pointer;
}

.quantity-value {
    font-size: 1.2em;
    margin: 0 10px;
}

.total-price {
    font-size: 1.1em;
    font-weight: bold;
    margin-left: 10px;
    color: #333;
}

.btn-loading {
        position: relative;
        display: flex;
        align-items: center;
    }

    .cart-item {
    position: relative;  /* Make cart-item a relative container */
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.loader {
    display: none;  
    position: absolute;  
    top: 50%;  /* Vertically center */
    left: 50%;  /* Horizontally center */
    transform: translate(-50%, -50%);  /* Perfect centering */
    border: 4px solid #f3f3f3;  /* Light gray background */
    border-top: 4px solid #007bff;  /* Blue spinner */
    border-radius: 50%;
    width: 30px;  /* Size of the loader */
    height: 30px; /* Size of the loader */
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.btn-danger
{
    display: none;
}


</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.quantity-increase', function() {
            let cartProductId = $(this).data('cart-id');
            let row = $(this).closest('.cart-item');
            let quantityElem = row.find('.quantity-value');
            let quantity = parseInt(quantityElem.text()) + 1;
            quantityElem.text(quantity);
            updateCart(cartProductId, quantity, row);
        });

        $(document).on('click', '.quantity-decrease', function() {
            let cartProductId = $(this).data('cart-id');
            let row = $(this).closest('.cart-item');
            let quantityElem = row.find('.quantity-value');
            let quantity = parseInt(quantityElem.text()) - 1;

            if (quantity <= 0) {
                removeFromCart(cartProductId, row);
            } else {
                quantityElem.text(quantity);
                updateCart(cartProductId, quantity, row);
            }
        });

        function updateCart(cartProductId, quantity, row) {
            var price = row.find('.product-price').data('price');
            var total = price * quantity;
            row.find('.product-total').text(total.toFixed(2) + '$');

            var overallTotal = 0;
            $('.product-total').each(function() {
                overallTotal += parseFloat($(this).text().replace('$', ''));
            });
            $('#total-price').text( overallTotal.toFixed(2) + '$');

            $.ajax({
                url: '<?php echo e(route('update.cart')); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    cartProductId: cartProductId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log("Cart updated successfully");
                    } else {
                        alert("Failed to update the cart.");
                    }
                },
                error: function() {
                    alert("An error occurred while processing your cart update.");
                }
            });
        }

        function removeFromCart(cartProductId, row) {
    var removeButton = row.find('.remove-from-cart'); 
    var loader = row.find('.loader'); 
 
    loader.show();
    removeButton.prop("disabled", true);  

    // Show the loader for 0.5 seconds
    setTimeout(function() {
        $.ajax({
            url: '<?php echo e(route('remove.cart')); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                cartProductId: cartProductId
            },
            success: function(response) {
                row.remove(); // Remove the row from the cart

                // Recalculate the total price
                var overallTotal = 0;
                $('.product-total').each(function() {
                    overallTotal += parseFloat($(this).text().replace('$', ''));
                });
                $('#total-price').text(overallTotal.toFixed(2) + '$');

                loader.hide();
                removeButton.prop("disabled", false);
            },
            error: function() {
                alert("An error occurred while removing the item from the cart.");

                loader.hide();
                removeButton.prop("disabled", false);
            }
        });
    }, 500);  
}

    $(document).on('click', '.remove-from-cart', function() {
        var cartProductId = $(this).data('cart-id');
        var row = $(this).closest('.cart-item');
        removeFromCart(cartProductId, row);
    });

        $(document).ready(function() {

    var cartStatus = $('#cart-status').val();

   
    if (cartStatus == 2) {
     
        $('#cart-container').addClass('blurred');
        $('#cart-form').addClass('disabled');
        // Show the user details form
        $('#user-details-form').show();
    } else {
  
        $('#checkout-btn').click(function() {        
            $('#cart-container').addClass('blurred');
            $('#cart-form').addClass('disabled');
            updateCartStatusTo2();
            $('#user-details-form').show();
        });
    }

    // Function to update the cart status to 2
    function updateCartStatusTo2() {
        $.ajax({
            url: '<?php echo e(route('update.cart.status')); ?>', // You'll need to create this route in your web.php
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                status: 2
            },
            success: function(response) {
                if (response.status === 'success') {
                    console.log("Cart status updated to 2");
                } else {
                    alert("Failed to update cart status.");
                }
            },
            error: function() {
                alert("An error occurred while updating the cart status.");
            }
        });
    }
});



        $('#proceed').click(function(e) {
    e.preventDefault(); // Prevent the default form submission behavior

    // Collect user details (phone and address)
    var userDetails = {
        phone: $('#phone').val(),
        address: $('#address').val()
    };

    // Send request to update user profile (phone and address)
    updateUserProfile(userDetails);
});

function updateUserProfile(userDetails) {
    $.ajax({
        url: '<?php echo e(route('update.user.profile')); ?>', // Route to update user profile (phone and address)
        method: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            phone: userDetails.phone,
            address: userDetails.address
        },
        success: function(response) {
            if (response.status === 'success') {
                console.log("User profile updated successfully");

                // Optionally, you can proceed to the payment page or next step here
                window.location.href = '<?php echo e(route('payment.page')); ?>'; // Redirect to the payment page
            } else {
                alert("Failed to update user profile.");
            }
        },
        error: function() {
            alert("An error occurred while updating user profile.");
        }
    });
}

    });
</script>

<div class="container mt-5 mb-5" id="cart-container">
    <h1>Your Cart</h1>
    <input type="hidden" id="cart-status" value="<?php echo e($cart->status ?? 0); ?>">


    <?php if($cartItems->count() > 0): ?>
    <form method="POST" action="" id="cart-form">
        <div class="list-group">
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="cart-item">
                <div>
                    <?php
                    // Get the first "H" priority image for the product
                    $image = $item->product->images->firstWhere('priority', 'H');
                    ?>
                    <img src="<?php echo e(url($image->folder . '/' . $image->filename)); ?>" alt="Product Image">
                </div>
                <div class="product-details">
    <div class="product-card">
        <div class="product-info">
            <div class="product-name"><?php echo e($item->product->name); ?></div>
            <div class="product-price" data-price="<?php echo e($item->product->price); ?>">
                $<?php echo e(number_format($item->product->price, 2)); ?>

            </div>
            <div class="product-description"><?php echo e($item->product->description); ?></div>
        </div>
        <div class="quantity-container">
            <button type="button" class="btn btn-secondary quantity-decrease" data-cart-id="<?php echo e($item->cart_product_id); ?>">-</button>
            <span class="quantity-value"><?php echo e($item->quantity); ?></span>
            <button type="button" class="btn btn-secondary quantity-increase" data-cart-id="<?php echo e($item->cart_product_id); ?>">+</button>
            <div class="total-price product-total">$<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?></div>
        </div>
    </div>
    <button type="button" class="btn btn-danger remove-from-cart" data-cart-id="<?php echo e($item->cart_product_id); ?>">
        <span>X</span> 
    </button>
    <div class="loader" ></div> 

</div>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="total-price-container">
            <h3>Total: <span id="total-price">$<?php echo e(number_format($totalPrice, 2)); ?></span></h3>
        </div>
        <button type="button" id="checkout-btn" class="btn btn-primary mt-3">Proceed to Checkout</button>
    </form>
    <?php else: ?>
    <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<!-- User Details Form -->
<div id="user-details-form" class="container mb-5">
    <h2>Enter Your Details</h2>
    <form method="POST"  action="<?php echo e(route('update.user.profile')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(Auth::user()->name); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(Auth::user()->profile->phone ?? ''); ?>" required>
        </div>
        <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <td><textarea name="address" class="form-control"><?php echo e(old('address', Auth::user()->profile->address ?? '')); ?></textarea></td>
</div>
        <button id="#proceed" type="submit" class="btn btn-success">Proceed to Payment</button>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/cart.blade.php ENDPATH**/ ?>