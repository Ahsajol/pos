<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('layout');
// });

Route::get('/layout', function () {
    return view('/layout');
})->middleware(['auth', 'verified'])->name('layout');

Route::middleware('auth')->group(function () {



    Route::resource('user', UserController::class);
    Route::get('user/{userId}/delete', [UserController::class, 'destroy'])->name('user.delete');
    // Route::get('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    // Route::put('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'updatePermissionToRole']);


    // Roles
    Route::resource('role', App\Http\Controllers\RoleController::class);
    Route::get('role/.{roleId}./delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('role/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'updatePermissionToRole']);

    // permissions
    Route::resource('permission', App\Http\Controllers\PermissionController::class);
    Route::get('permission/.{permissionId}./delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    // pos routs
    Route::resource('/category', CategoryController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/product', ProductController::class);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
