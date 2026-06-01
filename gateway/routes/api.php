<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register'])->name("register");
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::post('/refresh', [AuthController::class, 'refreshToken'])->name("refresh");


Route::group(['middleware' => ['auth:api']], function () {
    
    Route::get('/users', [UserController::class, 'index'])->name("users.index");
    Route::get('/users/{id}', [UserController::class, 'show'])->name("users.show");
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

});