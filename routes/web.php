
<?php

use Illuminate\Support\Facades\Route;
Route::get('/login', function () {
    return view('admin.login');
})->middleware('already_admin_login');

use App\Http\Controllers\AdminLoginController;
Route::post('/login', [AdminLoginController::class, 'login']);

use App\Http\Controllers\LogoutController;
Route::get('/logout', [LogoutController::class, 'logout'])->middleware('admin_login');

Route::get('/', function () {
    return view('index');
})->middleware('admin_login');

use App\Http\Controllers\UpdateController;
Route::post('{any}/update', [UpdateController::class, 'save'])->middleware('admin_login');

use App\Http\Controllers\AdminUsers\AdminUsersListController;
use App\Http\Controllers\AdminUsers\AdminUsersFormController;
Route::get('/admin_users', [AdminUsersListController::class, 'index'])->middleware('admin_login');
Route::get('/admin_users/{id}', [AdminUsersFormController::class, 'index'])->middleware('admin_login');

use App\Http\Controllers\Profile\ProfileListController;
use App\Http\Controllers\Profile\ProfileFormController;
Route::get('/profile', [ProfileListController::class, 'index'])->middleware('admin_login');
Route::get('/profile/{id}', [ProfileFormController::class, 'index'])->middleware('admin_login');

use App\Http\Controllers\Users\UsersListController;
use App\Http\Controllers\Users\UsersFormController;
Route::get('/users', [UsersListController::class, 'index'])->middleware('admin_login');
Route::get('/users/{id}', [UsersFormController::class, 'index'])->middleware('admin_login');
