<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product:slug}',[ShopController::class,'show'])->name('shop.show');

Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart',[CartController::class,'store'])->name('cart.store');
Route::patch('/cart/{product}',[CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{product}',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}',[CartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');


Route::delete('/saveForLater/{product}',[SaveForLaterController::class,'destroy'])->name('saveForLater.destroy');
Route::post('/cart/switchToCart/{product}',[SaveForLaterController::class,'switchToCart'])
    ->name('saveForLater.switchToCart');

Route::post('/coupon',[CouponsController::class,'store'])->name('coupon.store');
Route::delete('/coupon',[CouponsController::class,'destroy'])->name('coupon.destroy');

Route::get('/empty',function (){

        Cart::instance('default')->destroy();
});



Route::get('/checkout',[CheckoutController::class , 'index'])->name('checkout.index');
Route::post('/checkout',[CheckoutController::class , 'store'])->name('checkout.store');

Route::get('/thankyou',[ConfirmationController::class,'index'])->name('confirmation.index');
