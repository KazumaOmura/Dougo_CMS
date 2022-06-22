
<?php

use Illuminate\Support\Facades\Route;
Route::get('/login', function () {
    return view('admin.login');
})->middleware('already_admin_login');

use App\Http\Controllers\Default\AdminLoginController;
Route::post('/login', [AdminLoginController::class, 'login']);

use App\Http\Controllers\Default\LogoutController;
Route::get('/logout', [LogoutController::class, 'logout'])->middleware('admin_login');

Route::get('/', function () {
    return view('index');
})->middleware('admin_login');

use App\Http\Controllers\Default\UpdateController;
Route::post('{any}/update', [UpdateController::class, 'save'])->middleware('admin_login');

use App\Http\Controllers\Generated\AdminUsers\AdminUsersListController;
use App\Http\Controllers\Generated\AdminUsers\AdminUsersFormController;
Route::get('/admin_users', [AdminUsersListController::class, 'index'])->middleware('admin_login');
Route::get('/admin_users/{id}', [AdminUsersFormController::class, 'index'])->middleware('admin_login');

use App\Http\Controllers\Generated\Profile\ProfileListController;
use App\Http\Controllers\Generated\Profile\ProfileFormController;
Route::get('/profile', [ProfileListController::class, 'index'])->middleware('admin_login');
Route::get('/profile/{id}', [ProfileFormController::class, 'index'])->middleware('admin_login');

use App\Http\Controllers\Generated\Users\UsersListController;
use App\Http\Controllers\Generated\Users\UsersFormController;
Route::get('/users', [UsersListController::class, 'index'])->middleware('admin_login');
Route::get('/users/{id}', [UsersFormController::class, 'index'])->middleware('admin_login');
