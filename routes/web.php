<?php



use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    Route::get('/product', [StoreItems::class, 'show'])->name('product.show');

    Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);

        
});

require __DIR__.'/auth.php';
