<?php

use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EcommerceController;
use App\Models\Cart;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CartButtonRedirect;
use App\Http\Controllers\ReportController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Register routes for the application.
*/



// Regular user routes
Route::get('/', [EcommerceController::class, 'index'])->name('ecommerce.index');

Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.show');

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});





// Admin routes
Route::controller(AdminLoginController::class)->group(function () {
    Route::get('adminlogin', 'adminlogin')->middleware('redirect.custom')->name('adminlogin');
    Route::post('admin/authenticate', 'authenticateAdmin')->name('adminauthenticate');
    Route::get('admindashboard',  'admindashboard')->name('admindashboard');
    Route::post('admin/logout', 'logout')->name('adminlogout');
});


Route::middleware('cart.redirect')->get('/cart', [CartController::class, 'showCart'])->name('cart');
// Cart routes
// Route::middleware('auth')->group(function () {
//     Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
//     Route::post('/cart/update', [CartController::class, 'updateCart'])->name('update.cart');
//     Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('remove.cart');
//     Route::post('/update-cart-status', [CartController::class, 'updateCartStatus'])->name('update.cart.status');
//     Route::post('/update-user-profile', [CartController::class, 'updateUserProfile'])->name('update.user.profile');
//     Route::get('/payment', [CartController::class, 'showPaymentPage'])->name('payment.page');

//     Route::post('/confirm-cash-on-delivery', [CartController::class, 'confirmCashOnDelivery'])->name('confirmCashOnDelivery');  // Confirmation for Cash on Delivery
//     // Add this route for handling PayPal payment confirmation
//     Route::post('/confirm-paypal-payment', [CartController::class, 'confirmPaypalPayment'])->name('paypal.confirm');


//     Route::get('/success', [CartController::class, 'success'])->name('success');  // Success page
// });

Route::middleware(['auth', CartButtonRedirect::class])->group(function () {
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('update.cart');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('remove.cart');
    Route::post('/update-cart-status', [CartController::class, 'updateCartStatus'])->name('update.cart.status');
    Route::post('/update-user-profile', [CartController::class, 'updateUserProfile'])->name('update.user.profile');
    Route::get('/payment', [CartController::class, 'showPaymentPage'])->name('payment.page');

    Route::post('/confirm-cash-on-delivery', [CartController::class, 'confirmCashOnDelivery'])->name('confirmCashOnDelivery');
    Route::post('/confirm-paypal-payment', [CartController::class, 'confirmPaypalPayment'])->name('paypal.confirm');

    Route::get('/success', [CartController::class, 'success'])->name('success');
});









Route::middleware('auth', 'admin')->group(function () {
    Route::get('admin/manage-users', [UserManagementController::class, 'index'])->name('manageusers');
    Route::get('admin/deactivate-user/{id}', [UserManagementController::class, 'deactivate'])->name('deactivateuser');

    Route::get('admin/add-user', [UserManagementController::class, 'create'])->name('adduser');
    Route::post('admin/store-user', [UserManagementController::class, 'store'])->name('storeuser');


    Route::get('/admin/edit/{encrypted_id}', [UserManagementController::class, 'edit'])->name('edituser');
    Route::patch('/admin/update/{id}', [UserManagementController::class, 'update'])->name('updateuser');


    Route::post('admin/upload-file', [UserManagementController::class, 'uploadFile'])->name('uploadFile');

    Route::get('download/{userId}/{fileName}', [UserManagementController::class, 'downloadFile'])->name('file.download');

    Route::resource('products', ProductController::class);
    Route::post('products/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('products.uploadImages');

    Route::get('admin/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('order_details', [OrderController::class, 'orderDetails'])->name('orders.details');

    Route::get('admin/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/admin/reports/pdf', [ReportController::class, 'generatePdf'])->name('reports.pdf');
});
