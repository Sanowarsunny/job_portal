<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\FindJobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobAppliedSaveController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/findJobPage', [FindJobController::class,'findJobPage'])->name('findJobPage');
    Route::get('/detailJobPage/{id}', [FindJobController::class,'detailJobPage'])->name('detailJobPage');
    Route::post('/apply-job',[FindJobController::class,'applyJob'])->name('applyJob');
    Route::post('/save-job',[FindJobController::class,'saveJob'])->name('saveJob');




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
    Route::post('/updateProfile', [AccountController::class,'updateProfile'])->name('updateProfile');
    Route::post('/profileImage', [AccountController::class,'profileImage'])->name('profileImage');
    Route::post('/updatePassword', [AccountController::class,'updatePassword'])->name('updatePassword');

    //backend create job
    Route::get('/createJobPage', [JobController::class,'createJobPage'])->name('createJobPage');
    Route::post('/createJob', [JobController::class,'createJob'])->name('createJob');

    Route::get('/myJobPage', [JobController::class,'myJobPage'])->name('myJobPage');
    Route::get('/editJobPage/{id}', [JobController::class,'editJobPage'])->name('editJobPage');
    Route::post('/updatedJob/{id}', [JobController::class,'updatedJob'])->name('updatedJob');
    Route::get('/deleteJob/{id}', [JobController::class,'deleteJob'])->name('deleteJob');

    //job apply and removeAppliedJobs
    Route::get('/jobApplyPage', [JobAppliedSaveController::class,'jobApplyPage'])->name('jobApplyPage');
    Route::post('/removeAppliedJobs', [JobAppliedSaveController::class,'removeAppliedJobs'])->name('removeAppliedJobs');

    //save and removeSavedJob Backend
    Route::get('/saveJobPage', [JobAppliedSaveController::class,'saveJobPage'])->name('saveJobPage');
    Route::post('/removeSavedJob', [JobAppliedSaveController::class,'removeSavedJob'])->name('removeSavedJob');


    
});