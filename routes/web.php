<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'] )->name('home');
Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('addCart')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::get('/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware('auth');
Route::get('/add-quantity/{id}', [CartController::class, 'addQuantity'])->name('cart.addQuantity')->middleware('auth');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::resource('/Orders', OrderController::class)->middleware('auth');

Route::get('paypal/checkout/{orders}', [\App\Http\Controllers\PaypalController::class, 'getExpressCheckout'])->name('paypal.checkout');
Route::get('paypal/success/{orders}', [\App\Http\Controllers\PaypalController::class, 'getExpressCheckoutSuccess'])->name('paypal.success');
Route::get('paypal/failed', [\App\Http\Controllers\PaypalController::class, 'cancelPage'])->name('paypal.cancel');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
