<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Sales;
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

Route::get('/', function () {
    return view('/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/layout', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['isAdmin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('user/{userId}/delete', [UserController::class, 'destroy'])->name('user.delete');

    // Roles
    Route::resource('role', App\Http\Controllers\RoleController::class);
    Route::get('role/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);

    Route::get('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'updatePermissionToRole']);

    // Permissions
    Route::resource('permission', App\Http\Controllers\PermissionController::class);
    Route::get('permission/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    // POS routes
    Route::resource('/category', CategoryController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/product', ProductController::class);
    // Route::resource('/sale', SalesController::class);

    // Customer All Routes
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
    // Route::get('customer/{id}/view', [CustomerController::class, 'show'])->name('customer.view');
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    // Route::get('customer/{id}/invoice', [CustomerController::class, 'show'])->name('customer.invoice');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    // Suppliers All Routes
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('supplier', [SupplierController::class, 'store'])->name('supplier.store');
    // Route::get('customer/{id}/view', [SupplierController::class, 'show'])->name('customer.view');
    Route::get('/supplier/{id}', [SupplierController::class, 'show']);
    // Route::get('customer/{id}/invoice', [SupplierController::class, 'show'])->name('customer.invoice');
    Route::get('supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('duereport', [SupplierController::class, 'dueReport'])->name('supplier.due_report');
    // In your routes/web.php file
    Route::get('suppliers/duereport', [SupplierController::class, 'dueReport'])->name('suppliers.dueReport');

    // Route::get('/suppliers', [SearchController::class, 'index'])->name('suppliers.index');

    // purchase All Routes
    Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('purchase/{id}/show', [PurchaseController::class, 'show'])->name('purchase.show');
    // Route::get('/purchase/{id}', [PurchaseController::class, 'show']);
    Route::get('purchase/invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');
    Route::get('purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('purchase/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

    // Sales All Routes
    Route::get('sales', [saleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [saleController::class, 'create'])->name('sales.create');
    Route::post('sales', [saleController::class, 'store'])->name('sales.store');
    Route::get('sales/{id}/show', [saleController::class, 'show'])->name('sales.show');
    // Route::get('/purchase/{id}', [saleController::class, 'show']);
    Route::get('sales/invoice/{id}', [saleController::class, 'invoice'])->name('sales.invoice');
    Route::get('sales/{id}/edit', [saleController::class, 'edit'])->name('sales.edit');
    Route::put('sales/{id}', [saleController::class, 'update'])->name('sales.update');
    Route::delete('sales/{id}', [saleController::class, 'destroy'])->name('sales.destroy');

    // cart all routes
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/purchase/from-cart', [PurchaseController::class, 'purchaseFromCart'])->name('purchase.fromCart');
    Route::post('/sales/from-cart', [SaleController::class, 'salesFromCart'])->name('sales.fromCart');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
