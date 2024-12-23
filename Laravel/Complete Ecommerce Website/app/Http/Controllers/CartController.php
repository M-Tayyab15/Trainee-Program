<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->whereIn('status', [1, 2])
            ->first();
        // If an active cart exists, fetch its cart items
        if ($cart) {
            $cartItems = CartProduct::with('product.images')
                ->where('cart_id', $cart->cart_id)
                ->get();

            // Calculate the total price for the items in the cart
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        } else {
            $cartItems = collect();
            $totalPrice = 0;
        }

        return view('cart', compact('cartItems', 'totalPrice', 'cart'));
    }



    public function add($productId)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check for an active cart, or one with status 1 or 2
            $cart = Cart::where('user_id', $user->id)
                ->whereIn('status', [1, 2])
                ->first();

            if (!$cart) {
                // Create a new cart if none exists
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'status' => 1, // Start with status 1 (active)
                    'ip_address' => $this->getIpAddress(),
                    'created_on' => time(),
                    'updated_on' => time(),
                ]);
            } else {
                if ($cart->status == 2) {
                    $cart->status = 1;
                    $cart->updated_on = time();
                    $cart->save();
                }
            }

            // Check if the product exists in the product table
            $product = Product::findOrFail($productId);

            // Check if the product is already in the cart
            $cartProduct = CartProduct::where('cart_id', $cart->cart_id)
                ->where('pro_id', $productId)
                ->first();

            if ($cartProduct) {
                // Update the quantity and total price if product exists in cart
                $cartProduct->quantity += 1;
                $cartProduct->total_price = $cartProduct->quantity * $cartProduct->product_price; // Recalculate total price
                $cartProduct->save();
            } else {
                // Add product to cart
                CartProduct::create([
                    'cart_id' => $cart->cart_id,
                    'user_id' => $user->id,
                    'pro_id' => $product->pro_id,
                    'quantity' => 1,
                    'product_price' => $product->price,
                    'total_price' => $product->price
                ]);
            }

            // Recalculate total amount of the cart
            $cart->total_amount = $cart->cartProducts->sum('total_price');
            $cart->save();

            // Get the total number of products in the cart
            $cartCount = CartProduct::where('cart_id', $cart->cart_id)->count();

            return response()->json([
                'cartCount' => $cartCount
            ]);
        } else {
            // Redirect to login if not authenticated
            session(['redirect_after_login' => route('product.show', ['productId' => $productId])]);
            return redirect()->route('login');
        }
    }

    private function getIpAddress()
    {
        $ip = request()->ip();

        // Handle the case where the IP is the local IPv6 address (::1), convert it to 127.0.0.1
        if ($ip === '::1') {
            return '127.0.0.1';
        }

        // Check if the IP is in IPv6 format and is an IPv4-mapped IPv6 address (e.g., ::ffff:192.168.0.1)
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            // Check if it's an IPv4-mapped IPv6 address (e.g., ::ffff:192.168.0.1)
            if (strpos($ip, '::ffff:') === 0) {
                // Extract the IPv4 part from the IPv6 address
                return substr($ip, 7); // Remove the "::ffff:" prefix
            }
        }

        // If it's not an IPv6 or IPv4-mapped IPv6 address, return the IP as is
        return $ip;
    }



    public function updateCart(Request $request)
    {
        $cartProductId = $request->cartProductId;
        $quantity = $request->quantity;

        // Update the cart item in the database
        $cartItem = CartProduct::find($cartProductId);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->total_price = $cartItem->quantity * $cartItem->product_price; // Recalculate total price
            $cartItem->save();
        }

        // Recalculate total cart amount
        $cart = Cart::find($cartItem->cart_id);
        $cart->total_amount = $cart->cartProducts->sum('total_price');
        $cart->save();

        return response()->json(['status' => 'success']);
    }

    public function removeFromCart(Request $request)
    {
        $cartProductId = $request->cartProductId;

        // Remove the cart item
        $cartItem = CartProduct::find($cartProductId);
        if ($cartItem) {
            $cartItem->delete();
        }

        // Recalculate total cart amount after item removal
        $cart = Cart::find($cartItem->cart_id);
        $cart->total_amount = $cart->cartProducts->sum('total_price');
        $cart->save();

        return response()->json(['status' => 'success']);
    }
    public function updateCartStatus(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->where('status', 1)->first();
        if ($cart) {
            $cart->status = $request->status;
            $cart->save();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failure']);
    }
    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();

        // Validate input data
        $validated = $request->validate([
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $profile = $user->profile;

        if (!$profile) {

            $profile = Profile::create([
                'user_id' => $user->id, // Set the user_id
            ]);
        }

        // Update profile data
        $profile->update([
            'phone' => $validated['phone'] ?? $profile->phone,
            'address' => $validated['address'] ?? $profile->address,
        ]);

        // Redirect the user to the payment page
        return redirect()->route('payment.page'); // Adjust 'payment.page' to your route name
    }

    // public function confirmCashOnDelivery()
    // {
    //     // Get the current user's cart
    //     $cart = Cart::where('user_id', auth()->id())->orderBy('cart_id', 'desc')->first();
    //     //dd($cart);
    //     if ($cart) {
    //         $cart->payment_mode = 'COD';
    //         $cart->status = 3;
    //         $cart->save();
    //     }

    //     // Redirect to the success page
    //     return redirect()->route('success');
    // }

    // public function confirmPaypalPayment(Request $request)
    // {
    //     // Log the incoming request to see its contents
    //     Log::info('PayPal response received: ', $request->all());

    //     // Ensure the cart exists for the user
    //     $cart = Cart::where('user_id', auth()->id())->orderBy('cart_id', 'desc')->first();

    //     if ($cart) {
    //         try {
    //             // Get transaction data from PayPal response
    //             $transactionDetails = json_encode($request->all());

    //             // Update the cart with payment information
    //             $cart->payment_mode = 'Paypal';
    //             $cart->status = 3; 
    //             $cart->transaction_details = $transactionDetails;
    //             $cart->save();

    //             Log::info('Cart updated successfully', ['cart_id' => $cart->cart_id]);
    //             return response()->json(['status' => 'success']);
    //         } catch (\Exception $e) {
    //             // Log the error if anything goes wrong
    //             Log::error('Error processing PayPal payment: ' . $e->getMessage());

    //             // Return a failure response
    //             return response()->json(['status' => 'failure', 'message' => 'Payment confirmation failed']);
    //         }
    //     } else {
    //         Log::warning('No cart found for user', ['user_id' => auth()->id()]);
    //         return response()->json(['status' => 'failure', 'message' => 'No cart found']);
    //     }
    // }
    // public function success()
    // {
    //     return view('success');
    // }

    // public function showSuccessPage($cartId)
    // {

    //     $cart = Cart::with('cartProducts')->findOrFail($cartId);

    //     if ($cart->user_id != auth()->id()) {
    //         return redirect()->route('home')->with('error', 'Unauthorized access to this cart.');
    //     }

    //     if ($cart->status != '3') {
    //         return redirect()->route('home')->with('error', 'Invalid cart status.');
    //     }
    //     return view('success', compact('cart'));
    // }

    // public function showPaymentPage()
    // {
    //     $cart = Cart::where('user_id', auth()->id())
    //         ->whereIn('status', [1, 2])
    //         ->first();
    //     $totalAmount = 0;
    //     if ($cart) {

    //         $totalAmount = $cart->cartProducts->sum(function ($cartProduct) {
    //             return $cartProduct->quantity * $cartProduct->product->price;
    //         });
    //     }
    //     return view('payment', compact('totalAmount')); 
    // }
    /////////////////////////////////////////////
    public function showPaymentPage()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->whereIn('status', [1, 2])
            ->first();
        $totalAmount = 0;

        if ($cart) {
            // Calculate the total amount of the cart
            $totalAmount = $cart->cartProducts->sum(function ($cartProduct) {
                return $cartProduct->quantity * $cartProduct->product->price;
            });
        }

        // Passing totalAmount to the view
        return view('payment', compact('totalAmount'));
    }

    public function createPaypalOrder(Request $request)
    {
        // Fetch cart and calculate the total amount
        $cart = Cart::where('user_id', auth()->id())
            ->whereIn('status', [1, 2])
            ->first();

        $totalAmount = 0;

        if ($cart) {
            $totalAmount = $cart->cartProducts->sum(function ($cartProduct) {
                return $cartProduct->quantity * $cartProduct->product->price;
            });
        }

        // Create PayPal order
        $paypalOrder = [
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => number_format($totalAmount, 2),
                        'currency_code' => 'USD',
                    ]
                ]
            ]
        ];

        // Send response back with PayPal order details
        return response()->json([
            'status' => 'success',
            'order' => $paypalOrder
        ]);
    }

    public function confirmPaypalPayment(Request $request)
    {
        Log::info('PayPal response received: ', $request->all());

        // Retrieve the current cart for the user
        $cart = Cart::where('user_id', auth()->id())->orderBy('cart_id', 'desc')->first();

        if ($cart) {
            try {
                $transactionDetails = json_encode($request->all());

                // Update cart with payment info
                $cart->payment_mode = 'Paypal';
                $cart->status = 3;
                $cart->updated_on = time();
                $cart->transaction_details = $transactionDetails;
                $cart->save();

                $this->sendOrderConfirmationEmail($cart);

                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {
                Log::error('Error processing PayPal payment: ' . $e->getMessage());
                return response()->json(['status' => 'failure', 'message' => 'Payment confirmation failed']);
            }
        }

        Log::warning('No cart found for user', ['user_id' => auth()->id()]);
        return response()->json(['status' => 'failure', 'message' => 'No cart found']);
    }

    public function confirmCashOnDelivery()
    {
        $cart = Cart::where('user_id', auth()->id())->orderBy('cart_id', 'desc')->first();

        if ($cart) {
            $cart->payment_mode = 'COD';
            $cart->status = 3;
            $cart->updated_on = time();
            $cart->save();
            $this->sendOrderConfirmationEmail($cart);
        }

        return redirect()->route('success');
    }

    public function success()
    {
        $cart = Cart::with('cartProducts.product')
            ->where('user_id', auth()->id())
            ->where('status', 3)
            ->orderBy('created_on', 'desc')
            ->first();

        // If no cart is found, handle it gracefully (e.g., redirect or show an error)
        if (!$cart) {
            return redirect()->route('home')->with('error', 'Cart not found.');
        }

        // Pass the cart to the success page view
        return view('success', compact('cart'));
    }


    public function showSuccessPage($cartId)
    {
        // Fetch the cart along with its cartProducts and associated product details
        $cart = Cart::with('cartProducts.product')->find($cartId);

        dd($cart);

        // Check if the cart exists, and if not, return an error
        if (!$cart) {
            return redirect()->route('home')->with('error', 'Cart not found.');
        }

        // Ensure the cart belongs to the authenticated user
        if ($cart->user_id != auth()->id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to this cart.');
        }

        // Check the cart status to make sure it's completed (status 3)
        if ($cart->status != 3) {
            return redirect()->route('home')->with('error', 'Invalid cart status.');
        }

        // Pass the cart to the view
        return view('success', compact('cart'));
    }


    protected function sendOrderConfirmationEmail($cart)
    {
        $user = $cart->user;

        // Define your parameters
        $params = [
            'sender' => [
                'email' => env('MAIL_FROM_ADDRESS', 'default_email@example.com'),
                'password' => env('MAIL_PASSWORD', 'default_password'),
                'name' => env('MAIL_SENDER_NAME', 'Arsenal Store'),
            ],
            'recipient' => [
                'email' => $user->email,
                'name' => $user->name
            ],
            'cc' => [
                [
                    'email' => 'tayyab_avatar@hotmail.com', // Set CC email here
                    'name' => 'Tayyab' 
                ]
            ],
            'subject' => 'Order Confirmation',
            'body' => view('emails.order_confirmation', compact('cart'))->render(),
        ];

        // Send the email
        sendEmail($params);
    }
}
