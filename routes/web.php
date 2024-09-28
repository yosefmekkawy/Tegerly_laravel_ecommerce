<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllerResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryControllerResource;
use App\Http\Controllers\ProductControllerResource;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactMessagesController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReviewsController;

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

//nav bar routes

Route::get('/', function () {
    return view('index');
});


/*----------start of auth routes ---------------------*/

Route::middleware(['guest'])->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class,'login'])->name('login.post');

    Route::get('/register', [UserControllerResource::class,'showRegisterForm'])->name('register');

    Route::post('/register', [UserControllerResource::class,'store'])->name('register.store');
});

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*----------end of auth routes ---------------------*/


/*----------start of lang routes ---------------------*/

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('switch-language');

/*----------end of lang routes ---------------------*/

Route::any('/delete-item', [DeleteController::class,'delete'])->name('delete-item');



//start of dashboard routes

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [ProductControllerResource::class,'index'])->name('dashboard');

    Route::resources([
        'categories' => CategoryControllerResource::class,
        'products' => ProductControllerResource::class,
        'users' => UserControllerResource::class,
    ]);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.dashboard.index');
    Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});

    //end of dashboard routes

Route::get('/profile/{id}', [UserControllerResource::class,'edit'])->name('profile');

/*----------start of cart routes ---------------------*/

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout',[OrderController::class,'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/order-success/{id}', [OrderController::class, 'success'])->name('order.success');

});

Route::get('/products',[ProductControllerResource::class,'index'])->name('products.main.index');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');


/*----------end of cart routes ---------------------*/

// Contact Us routes
Route::get('/contact_us', [ContactMessagesController::class, 'create'])->name('contact_us.create');
Route::post('/contact_us', [ContactMessagesController::class, 'store'])->name('contact_us.store');

// Admin view for contact messages


//Route::post('/reviews',[ReviewsController::class,'store'])->name('reviews.store');

Route::post('/reviews', [ReviewsController::class, 'store'])
    ->middleware('auth', 'order.completed')
    ->name('reviews.store');
Route::get('/contact_messages', [ContactMessagesController::class, 'index'])->middleware(['admin'])->name('contact_messages.index');
