<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesController;
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
    Route::resource('/sale', SalesController::class);

    // sale Routes
    Route::get('/sale', [SalesController::class, 'index'])->name('sale.index');
    Route::post('/sale', [SalesController::class, 'store'])->name('sale.store');

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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
