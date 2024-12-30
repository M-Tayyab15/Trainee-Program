<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            background-color: #f4f4f4;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
            font-size: 18px;
            color: #333;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        li:hover {
            background-color: #e8f5e9;
            transform: translateX(5px);
        }

        li strong {
            color: #4CAF50;
            font-size: 18px;
            display: inline-block;
            width: 200px; /* Give space for product names */
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #e53935;
            padding-top: 15px;
            text-align: center;
            margin-top: 20px;
        }

        .payment-mode {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            text-align: center;
        }

        .order-id {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            text-align: center;
        }

        .footer {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            color: #888;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Thank you for your order, {{ $cart->user->name }}!</h1>
        <p>Your order has been successfully completed. Below are your order details:</p>

        <!-- Order ID Section -->
        <div class="order-id">
            <p><strong>Order ID:</strong> {{ $cart->cart_id }}</p>
            <p><em>Please keep this order ID for your records.</em></p>
        </div>

        <ul>
            @foreach ($cart->cartProducts as $cartProduct)
                <li>
                    <strong>{{ $cartProduct->product->name }}</strong> 
                    <span>Quantity: {{ $cartProduct->quantity }}</span> - 
                    <span>Total: ${{ $cartProduct->total_price }}</span>
                </li>
            @endforeach
        </ul>
        <p class="total-amount">Total Amount: ${{ $cart->total_amount }}</p>
        
        <div class="payment-mode">
            <p><strong>Payment Mode:</strong> {{ $cart->payment_mode }}</p>
        </div>
        
        <p>We will notify you once your order is shipped. Thank you for shopping with us!</p>

        <div class="footer">
            <p>If you have any questions, feel free to <a href="mailto:muhammadtayyabafc@gmail.com">contact our support team</a>.</p>
        </div>
    </div>
</body>
</html>
