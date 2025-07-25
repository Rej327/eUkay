<?php



use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayMongoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreItems;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('clear', function() {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    return 'Cache is cleared';
});

Route::get('/', function () {
    if(Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('home');


Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('address', AddressController::class);
    
    Route::get('/manage-products', [ProductController::class, 'index'])->name('manage-products.index');
    // Route::get('/manage-products/create', [ProductController::class, 'create'])->name('manage-products.create');
    Route::post('/manage-products', [ProductController::class, 'store'])->name('manage-products.store');
    Route::get('/manage-products/{product}/edit', [ProductController::class, 'edit'])->name('manage-products.edit');
    Route::put('/manage-products/{product}', [ProductController::class, 'update'])->name('manage-products.update');
    Route::delete('/manage-products/{product}', [ProductController::class, 'destroy'])->name('manage-products.destroy');

    // Route::get('/address/{address}/edit', [AddressController::class, 'edit'])->name('address.edit');

    // Route::get('/product', [StoreItems::class, 'show'])->name('product.show');
    Route::get('/product/{product}', [StoreItems::class, 'show'])->name('product.show');

    Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', action: [WishlistController::class, 'destroy'])->name('wishlist.remove');
    // Route::post('/wishlist/add-all-to-cart', [WishlistController::class, 'addAllToCart'])->name('wishlist.addAllToCart');
    Route::delete('/wishlist', [WishlistController::class, 'clear'])->name('wishlist.clear');

    Route::post('/checkout', [PayMongoController::class, 'checkout'])->name('checkout');
    Route::get('/payment/success', [PayMongoController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PayMongoController::class, 'failed'])->name('payment.failed');
    Route::post('/webhook/paymongo', [PayMongoController::class, 'handleWebhook']);





        
});

require __DIR__.'/auth.php';
