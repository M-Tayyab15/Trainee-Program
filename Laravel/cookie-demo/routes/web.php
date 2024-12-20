<?php
use App\Http\Controllers\CookieController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('set-cookie', [CookieController::class, 'setCookie']);
Route::get('get-cookie', [CookieController::class, 'getCookie']);
Route::get('delete-cookie', [CookieController::class, 'deleteCookie']);
