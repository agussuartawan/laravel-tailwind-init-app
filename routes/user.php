<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)->group(function(){
        Route::get('users/get-permission-list', 'getPermissionList');
        Route::resource('users');
        Route::resource('roles');
        Route::resource('permissions');
    });
});