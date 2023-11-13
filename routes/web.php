<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueControler;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\Order_DetailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/403', function () {return view('403');})->name('403');
Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'register']);
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'login']);
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/category/{id}', [HomepageController::class, 'searchByCategory'])->name('searchByCategory');
Route::get('/product/{id}', [HomepageController::class, 'show'])->name('product.show');
Route::get('/get-product-price/{color}/{version}', [HomepageController::class, 'getProductPrice'])->name('getProductPrice');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('customer')->middleware('customer.auth:sanctum')->group(function () {
        Route::get('/homepage', [HomepageController::class, 'index'])->name('customer.homepage');
        Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
        Route::get('/cart/store', [CartController::class, 'saveCart'])->name('customer.store');
        Route::get('/cart/data', [CartController::class, 'cartData'])->name('customer.data');
        Route::get('/cart/{product_id}', [CartController::class, 'addToCart'])->name('customer.addtoCart');
        Route::get('/cart/delete/{id}', [CartController::class, 'delete'])->name('customer.delete');
        Route::get('/order',[Order_DetailController::class, 'index'])->name('customer.order');
        Route::get('/payment/create/{order_id}', [PaymentController::class, 'createPayment'])->name('payment.create');
        Route::get('/payment/return', [PaymentController::class, 'returnPayment'])->name('payment.return');

    });

    Route::prefix('admin')->middleware('admin.auth:sanctum')->group(function () {
        Route::get('/homepage', [AdminController::class, 'index'])->name('admin.homepage');

        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/update/{id}', [CategoryController::class, 'edit'])->name('category.update');
        Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

        Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/update/{id}', [ProductController::class, 'edit'])->name('product.update');
        Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::get('/attribute/{id}', [AttributeController::class, 'index'])->name('admin.attribute');
        Route::get('/attribute/create/{id}', [AttributeController::class, 'create'])->name('attribute.create');
        Route::get('/attribute_value/create/{id}', [AttributeValueControler::class, 'create'])->name('attribute_value.create');
        Route::post('/attribute_value/store', [AttributeValueControler::class, 'store'])->name('attribute_value.store');
        Route::get('get-attributes/{product_id}', 'AttributeValueControler@getAttributesView');
        Route::post('/attribute/store', [AttributeController::class, 'store'])->name('attribute.store');
        Route::get('admin/attribute/{product_id}/{attribute_id}/edit', [AttributeController::class, 'edit'])->name('attribute.edit');
        Route::put('admin/attribute/{product_id}/{attribute_id}', [AttributeController::class, 'update'])->name('attribute.update');
        Route::delete('/attribute/delete/{product_id}/{attribute_value_id}', [AttributeController::class, 'destroy'])->name('attribute.destroy');

        Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
        Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
        Route::get('/order/update/{id}', [OrderController::class, 'edit'])->name('order.update');
        Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    });

    Route::prefix('manage')->middleware('manage.auth:sanctum')->group(function () {
        Route::get('/homepage', [ManageController::class,'index'])->name('manage.homepage');
    });
});