
<?php $__env->startSection('content'); ?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.paypal.com/sdk/js?client-id=AQ136heDRFOoF6v-6-NjxMEmr6FrH9KlfW9aRfJAEdqN1S9ssucLaGzCUIhoJKe5d1XpjHe62QOfdCLS&currency=USD"></script>
</head>

<body>

    <div class="container mt-5">
        <h1>Payment Page</h1>

        <!-- Check if totalAmount is 0.00 and redirect to home page -->
        <?php if(number_format($totalAmount, 2) == '0.00'): ?>
            <script>
                // Redirect to home page if totalAmount is 0.00
                window.location.href = '/';
            </script>
            <p>The total amount is zero. Redirecting...</p>
        <?php else: ?>
            <p>Congratulations, <strong><?php echo e(ucwords(Auth::user()->name)); ?></strong>! Your details were successfully updated, and now you're on the payment page.</p>

            <p><strong>Total Amount: $<?php echo e(number_format($totalAmount, 2)); ?></strong></p> <!-- Display total amount -->

            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Select Payment Method</label><br>
                <input type="radio" name="paymentMethod" value="cash_on_delivery" id="cashOnDeliveryRadio" class="form-check-input">
                <label class="form-check-label" for="cashOnDeliveryRadio">Cash on Delivery</label><br>

                <input type="radio" name="paymentMethod" value="paypal" id="paypalRadio" class="form-check-input">
                <label class="form-check-label" for="paypalRadio">PayPal</label>
            </div>

            <!-- Modal for Cash on Delivery Confirmation -->
            <div class="modal fade" id="cashOnDeliveryModal" tabindex="-1" aria-labelledby="cashOnDeliveryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cashOnDeliveryModalLabel">Cash on Delivery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to select Cash on Delivery as your payment method?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmCashOnDelivery">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Placeholder for PayPal Buttons -->
            <div id="paypalButtons" style="display: none;">
                <h4>PayPal Payment</h4>
                <div id="paypal-button-container"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize Bootstrap modal
        const cashOnDeliveryModal = new bootstrap.Modal(document.getElementById('cashOnDeliveryModal'));

        // Handle the change of payment method (Radio Buttons)
        document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedPaymentMethod = this.value;
                const paypalButtons = document.getElementById('paypalButtons');
                const paypalButtonContainer = document.getElementById('paypal-button-container');

                
                paypalButtons.style.display = 'none';
                cashOnDeliveryModal.hide(); // Close any open modal
                paypalButtonContainer.innerHTML = ''; // Clear the PayPal button container

                if (selectedPaymentMethod === 'cash_on_delivery') {
                    // Show modal for Cash on Delivery
                    cashOnDeliveryModal.show();
                } else if (selectedPaymentMethod === 'paypal') {
                    // Show PayPal button when PayPal is selected
                    paypalButtons.style.display = 'block';

                    // Render PayPal button with sandbox configuration
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '<?php echo e($totalAmount); ?>' // Dynamically use the total amount
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                // Transaction completed, prepare transaction data
                                const transactionData = {
                                    orderID: data.orderID,
                                    payer: details.payer,
                                    amount: details.purchase_units[0].amount.value
                                };

                                // Send a POST request to confirm PayPal payment
                                fetch('/confirm-paypal-payment', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Include CSRF token
                                        },
                                        body: JSON.stringify({
                                            orderID: data.orderID,
                                            payer: details.payer,
                                            amount: details.purchase_units[0].amount.value
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log('PayPal response:', data);
                                        if (data.status === 'success') {
                                            // Redirect to success page if payment confirmation is successful
                                            window.location.href = '<?php echo e(route("success")); ?>';
                                        } else {
                                            // Handle error if the confirmation fails
                                            alert('Payment confirmation failed. Please try again.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error confirming PayPal payment:', error);
                                        alert('An error occurred while confirming the payment. Please try again.');
                                    });
                            });
                        },
                        onError: function(err) {
                            console.error('PayPal payment error:', err);
                            alert('An error occurred during the payment process. Please try again.');
                        }
                    }).render('#paypal-button-container');
                }
            });
        });

        //Cash on Delivery
        document.getElementById('confirmCashOnDelivery').addEventListener('click', function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/confirm-cash-on-delivery';
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '<?php echo e(csrf_token()); ?>';
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/payment.blade.php ENDPATH**/ ?>