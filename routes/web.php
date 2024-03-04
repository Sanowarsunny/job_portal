<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/registerPage', [AccountController::class,'registerPage'])->name('registerPage');
Route::post('/register', [AccountController::class,'register'])->name('register');

Route::get('/loginPage', [AccountController::class,'loginPage'])->name('login');

