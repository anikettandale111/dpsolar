<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'frontend'])->name('frontend');
// Customer Controller Start// 
Route::middleware('auth:customer')->get('customer/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.dashboard');
Route::middleware('auth:customer')->post('cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
Route::middleware('auth:customer')->get('cart/complete', [App\Http\Controllers\CartController::class, 'orderComplete'])->name('cart.complete');
Route::middleware('auth:customer')->delete('cart/deleteitem/{id?}', [App\Http\Controllers\CartController::class, 'deleteitem'])->name('cart.deleteitem');
Route::middleware('auth:customer')->post('cart/payment', [App\Http\Controllers\CartController::class, 'payment'])->name('cart.payment');
Route::middleware('auth:customer')->get('customer/address', [App\Http\Controllers\CustomerController::class, 'address'])->name('customer.address');
Route::middleware('auth:customer')->post('customer/addressadd', [App\Http\Controllers\CustomerController::class, 'addressadd'])->name('customer.addressadd');
Route::middleware('auth:customer')->get('customer/addresslist', [App\Http\Controllers\CustomerController::class, 'addresslist'])->name('customer.addresslist');
Route::middleware('auth:customer')->get('customer/addressget/{id?}', [App\Http\Controllers\CustomerController::class, 'addressget'])->name('customer.addressget');
Route::middleware('auth:customer')->delete('customer/addressdelete/{id}', [App\Http\Controllers\CustomerController::class, 'addressdelete'])->name('customer.addressdelete');
Route::get('getotp', [App\Http\Controllers\CustomerController::class, 'getotp'])->name('getotp');
Route::get('verifyotp', [App\Http\Controllers\CustomerController::class, 'verifyotp'])->name('verifyotp');
// Route::get('/signin', [App\Http\Controllers\CustomerController::class, 'userSignin'])->name('signin');
// Customer Controller End// 

Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/productlist', [App\Http\Controllers\ProductController::class, 'productlist'])->name('productlist');
Route::get('/categorylist', [App\Http\Controllers\CategoryController::class, 'categorylist'])->name('categorylist');
Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers','middleware' => ['auth', 'permission']], function()
{
    Route::get('/dashboard', [Con\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [Con\HomeController::class, 'profile'])->name('users.profile');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/getsubcat/{categoryId}', [SubcategoryController::class, 'getSubcategories']);
// Cart Controller Start// 
Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('cart/count', [App\Http\Controllers\CartController::class, 'cartCount'])->name('cart.count');
Route::post('cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::post('cart/update', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
Route::delete('cart/remove/{productId}', [App\Http\Controllers\CartController::class, 'deleteFromCart'])->name('cart.remove');
Route::delete('cart/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear');
Route::get('cart/totalcal', [App\Http\Controllers\CartController::class, 'totalcal'])->name('cart.totalcal');
Route::get('order/received', [App\Http\Controllers\OrdersController::class, 'received'])->name('orders.received');
Route::get('order/inprogress', [App\Http\Controllers\OrdersController::class, 'inprogress'])->name('orders.inprogress');
Route::get('order/delivered', [App\Http\Controllers\OrdersController::class, 'delivered'])->name('orders.delivered');
Route::get('order/cancelled', [App\Http\Controllers\OrdersController::class, 'cancelled'])->name('orders.cancelled');
// Cart Controller End// 

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'permissions' => PermissionController::class,
    'products' => ProductController::class,
    'category' => CategoryController::class,
    'subcategory' => SubCategoryController::class,
    'reviews' => ReviewsController::class,
    'orders' => OrdersController::class
]);
