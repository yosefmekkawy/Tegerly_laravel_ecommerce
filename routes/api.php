<?php
//
//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserControllerResource;
//use App\Http\Controllers\AuthController;
//use App\Http\Controllers\CategoryControllerResource;
//use App\Http\Controllers\ProductControllerResource;
//use App\Http\Controllers\CartController;
//use App\Http\Controllers\OrderController;
//use App\Http\Controllers\ContactMessagesController;
//use App\Http\Controllers\AnalyticsController;
//use App\Http\Controllers\ReviewsController;
//
///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register API routes for your application. These
//| routes are loaded by the RouteServiceProvider and all of them will
//| be assigned to the "api" middleware group. Make something great!
//|
//*/
//
//
///*---------- Auth  ---------------------*/
//
//Route::post('/login', [AuthController::class, 'login'])->name('api.login');
//Route::post('/register', [UserControllerResource::class, 'store'])->name('api.register');
//
//Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('api.logout');
//
//Route::post('/contact_us', [ContactMessagesController::class, 'store'])->name('api.contact_us.store');
//Route::middleware('auth:sanctum')->get('/contact_messages', [ContactMessagesController::class, 'index'])->name('api.contact_messages.index');
//
///*------------------------------- Dashboard  ---------------------*/
//
//Route::middleware(['auth:sanctum', 'role:seller'])->prefix('dashboard')->group(function () {
//    Route::get('/', [ProductControllerResource::class, 'index'])->name('api.dashboard');
//
//    Route::apiResources([
//        'products' => ProductControllerResource::class,
//        'users' => UserControllerResource::class,
//    ]);
//
//    Route::get('/orders', [OrderController::class, 'index'])->name('api.orders.dashboard.index');
//    Route::get('/reviews', [ReviewsController::class, 'index'])->name('api.reviews.index');
//    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('api.analytics.index');
//});
//
//Route::middleware(['auth:sanctum', 'role:admin'])->prefix('dashboard')->group(function () {
//    Route::apiResources([
//        'categories' => CategoryControllerResource::class,
//        'products' => ProductControllerResource::class,
//        'users' => UserControllerResource::class,
//    ]);
//});
//
///*---------- Cart  ---------------------*/
//
//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/cart', [CartController::class, 'index'])->name('api.cart.index');
//    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('api.cart.add');
//    Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('api.cart.update');
//    Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('api.cart.remove');
//    Route::post('/cart/clear', [CartController::class, 'clear'])->name('api.cart.clear');
//    Route::get('/checkout', [OrderController::class, 'checkout'])->name('api.checkout');
//    Route::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');
//    Route::get('/order-success/{id}', [OrderController::class, 'success'])->name('api.order.success');
//});
//
///*---------- Products and Orders  ---------------------*/
//
//Route::get('/products', [ProductControllerResource::class, 'index'])->name('api.products.index');
//Route::get('/orders', [OrderController::class, 'index'])->name('api.orders.index');
//
///*---------- Reviews  ---------------------*/
//Route::middleware(['auth:sanctum', 'order.completed'])->post('/reviews', [ReviewsController::class, 'store'])->name('api.reviews.store');
