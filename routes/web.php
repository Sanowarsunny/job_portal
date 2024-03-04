<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');



//Guest Route
Route::group(['middleware'=> 'guest'],function(){

    Route::get('/registerPage', [AccountController::class,'registerPage'])->name('registerPage');
    Route::post('/register', [AccountController::class,'register'])->name('register');
    Route::get('/loginPage', [AccountController::class,'loginPage'])->name('login');
    Route::post('/loginCheck', [AccountController::class,'loginCheck'])->name('loginCheck');


});

//auth Route
Route::group(['middleware'=> 'auth'],function(){

    Route::get('/logout', [AccountController::class,'logout'])->name('logout');
    //profile
    Route::get('/profilePage', [AccountController::class,'profilePage'])->name('profilePage');
    
});