
<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('index');
});

use App\Http\Controllers\UpdateController;
Route::post('{any}/update', [UpdateController::class, 'save']);

use App\Http\Controllers\AdminUsersListController;
use App\Http\Controllers\AdminUsersFormController;
Route::get('/admin_users', [AdminUsersListController::class, 'index']);
Route::get('/admin_users/{id}', [AdminUsersFormController::class, 'index']);

use App\Http\Controllers\ProfileListController;
use App\Http\Controllers\ProfileFormController;
Route::get('/profile', [ProfileListController::class, 'index']);
Route::get('/profile/{id}', [ProfileFormController::class, 'index']);

use App\Http\Controllers\UsersListController;
use App\Http\Controllers\UsersFormController;
Route::get('/users', [UsersListController::class, 'index']);
Route::get('/users/{id}', [UsersFormController::class, 'index']);
