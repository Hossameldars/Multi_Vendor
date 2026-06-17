<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatagoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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

Route::get('/', [HomeController::class,'index']);
 
 Route::get('/product/{slug}', [HomeController::class,'showproduct'])->name('showproduct');
 Route::resource('cart',CartController::class);

Route::middleware(['auth','checkUser'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Categories
    Route::get('categories/archive',[CatagoriesController::class,'archive'])
        ->name('categories.archive');

    Route::put('categories/{id}/restore', [CatagoriesController::class, 'restore'])
        ->name('categories.restore');

    Route::delete('categories/{id}/forceDelete',[CatagoriesController::class, 'forceDelete'])
        ->name('categories.forceDelete');

    Route::resource('categories',CatagoriesController::class);

    // Products
    Route::resource('products',ProductController::class);

});
Route::delete('/cart', [CartController::class, 'empty'])->name('cart.empty');
Route::get('/cart/total', [CartController::class, 'total'])->name('cart.total');
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::resource('roles',RoleController::class);
Route::resource('admin',AdminController::class);
Route::post('/lang/switch', function () {
    
  $locale    = request('locale', 'en');

    
        session(['locale' => $locale]);
  

    return redirect()->back();
})->name('lang.switch');
require __DIR__.'/auth.php';
