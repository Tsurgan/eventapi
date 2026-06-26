<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::post('/register', [AuthController::class, 'register'])->name("register");
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::post('/refresh', [AuthController::class, 'refreshToken'])->name("refresh");


Route::group(['middleware' => ['auth:api']], function () {
    
    Route::get('/users', [UserController::class, 'index'])->name("users.index");
    Route::get('/users/{id}', [UserController::class, 'show'])->name("users.show");
    Route::put('/users/{id}', [UserController::class, 'update'])->name("users.update");
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name("users.destroy");

    Route::get('/permissioss', [PermissionController::class, 'index'])->name("permissions.index");
    Route::post('/users/{id}/permissions', [UserController::class, 'addPermissions'])->name("users.addPermissions");
    Route::post('/users/{id}/permission-deletions', [UserController::class, 'removePermissions'])->name("users.removePermissions");   
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get('/roles', [RoleController::class, 'index'])->name("roles.index");
    Route::get('/roles/{id}', [RoleController::class, 'show'])->name("roles.show");
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name("roles.update");
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name("roles.destroy");    
    Route::post('/roles/{id}/permissions', [RoleController::class, 'addPermissions'])->name("roles.addPermissions");
    Route::post('/roles/{id}/permission-deletions', [RoleController::class, 'removePermissions'])->name("roles.removePermissions");   
});