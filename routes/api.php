<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCartController;
use App\Http\Controllers\Api\ApiCheckoutController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiBuyerController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ApiProductController::class, 'getProducts'])->name('api.products');
Route::post('/product/create', [ApiProductController::class, 'store'])->name('api.product.store');
Route::get('/product/show/{id}', [ApiProductController::class, 'show'])->name('api.product.show');
Route::get('/product/edit/{id}', [ApiProductController::class, 'edit'])->name('api.product.edit');
Route::post('/product/update/{id}', [ApiProductController::class, 'update'])->name('api.product.update');
Route::post('/product/delete/{id}', [ApiProductController::class, 'delete'])->name('api.product.delete');
Route::get('/products/trash', [ApiProductController::class, 'trash'])->name('api.products.trash');
Route::post('/product/restore/{id}', [ApiProductController::class, 'restore'])->name('api.product.restore');
Route::post('/product/remove/{id}', [ApiProductController::class, 'remove'])->name('api.product.remove');
Route::get('/product/export', [ApiProductController::class, 'export'])->name('api.product.export');
Route::post('/product/import', [ApiProductController::class, 'import'])->name('api.product.import');

Route::get('/orders', [ApiOrderController::class, 'orders'])->name('api.orders');
Route::get('/order/show/{id}', [ApiOrderController::class, 'show'])->name('api.order.show');
Route::post('/order/delete/{id}', [ApiOrderController::class, 'delete'])->name('api.order.delete');
Route::get('/orders/trash', [ApiOrderController::class, 'trash'])->name('api.orders.trash');
Route::post('/order/restore/{id}', [ApiOrderController::class, 'restore'])->name('api.order.restore');
Route::post('/order/remove/{id}', [ApiOrderController::class, 'remove'])->name('api.order.remove');
Route::get('/order/export', [ApiOrderController::class, 'export'])->name('api.order.export');

Route::get('/buyers', [ApiBuyerController::class, 'buyers'])->name('api.buyers');
Route::post('/buyer/delete/{id}', [ApiBuyerController::class, 'delete'])->name('api.buyer.delete');
Route::get('/buyers/trash', [ApiBuyerController::class, 'trash'])->name('api.buyers.trash');
Route::post('/buyer/restore/{id}', [ApiBuyerController::class, 'restore'])->name('api.buyer.restore');
Route::post('/buyer/remove/{id}', [ApiBuyerController::class, 'remove'])->name('api.buyer.remove');
Route::get('/buyer/export', [ApiBuyerController::class, 'export'])->name('api.buyer.export');

Route::get('/carts', [ApiCartController::class, 'cart'])->name('api.cart');
Route::post('/add-to-cart', [ApiCartController::class, 'addToCart'])->name('api.cart.add');
Route::post('/cart/delete/{id}', [ApiCartController::class, 'delete'])->name('api.cart.delete');
Route::post('/place-order', [ApiCheckoutController::class, 'placeOrder'])->name('api.place-order');
Route::get('/order-history', [ApiOrderController::class, 'orderHistory'])->name('api.order-history');

