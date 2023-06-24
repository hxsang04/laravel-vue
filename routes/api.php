<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCartController;
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

Route::get('/carts', [ApiCartController::class, 'cart'])->name('api.cart');
Route::post('/add-to-cart', [ApiCartController::class, 'addToCart'])->name('api.cart.add');