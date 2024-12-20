@extends('layouts')

@section('content')
<div class="container mt-5">
    <h1>Success!</h1>
    <p>Your payment method has been confirmed, and your order has been placed successfully.</p>
    <p>Thank you for shopping with us!</p>

    <hr>

    <h3>Details</h3>
    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Phone:</strong> {{ auth()->user()->profile->phone ?? 'Not Provided' }}</p>
    <p><strong>Address:</strong> {{ auth()->user()->profile->address ?? 'Not Provided' }}</p>  

    <hr>

    <h3>Order Receipt</h3>

    @if($cart && $cart->cartProducts->isEmpty())
        <p>No items in your cart.</p>
    @elseif($cart)
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
                @foreach($cart->cartProducts as $cartProduct)
                    <tr>
                        <td>{{ $cartProduct->product->name }}</td>
                        <td>{{ $cartProduct->quantity }}</td>
                        <td>${{ number_format($cartProduct->product->price, 2) }}</td>
                        <td>${{ number_format($cartProduct->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div class="d-flex justify-content-end">
            <h4><strong>Total Amount: ${{ number_format($cart->cartProducts->sum('total_price'), 2) }}</strong></h4>
        </div>
    @endif

    <hr>
    
    <div class="alert alert-success mt-3">
        <strong>Thank you!</strong> Your order has been successfully placed, and we will notify you once it is shipped.
    </div>
</div>
@endsection
