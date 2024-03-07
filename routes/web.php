<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobAdminController;
use App\Http\Controllers\admin\UserController;
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

    //admin
    Route::group(['prefix' => 'admin','middleware' => 'checkRole'], function(){

        //admin user
        Route::get('/dashboardPage',[DashboardController::class,'dashboardPage'])->name('admin.dashboardPage');
        Route::get('/userListPage',[UserController::class,'userListPage'])->name('admin.userListPage');
        Route::get('/userEditPage/{id}',[UserController::class,'userEditPage'])->name('admin.userEditPage');
        Route::put('/userupdate/{id}',[UserController::class,'userupdate'])->name('admin.userupdate');
        Route::delete('/userDelete',[UserController::class,'userDelete'])->name('admin.userDelete');

        //admin Job 
        Route::get('/jobPage',[JobAdminController::class,'jobPage'])->name('admin.jobPage');
        Route::get('/jobEdit/{id}',[JobAdminController::class,'jobEdit'])->name('admin.jobEdit');
        Route::put('/jobUpdate/{id}',[JobAdminController::class,'jobUpdate'])->name('admin.jobUpdate');
        Route::delete('/jobDelete',[JobAdminController::class,'jobDelete'])->name('admin.jobDelete');
        Route::get('/job-applications-page',[JobAdminController::class,'jobApplicationsPage'])->name('admin.jobApplicationsPage');
        Route::delete('/job-applications-delete',[JobAdminController::class,'jobApplicationsDelete'])->name('admin.jobApplicationsDelete');
    });


    //Guest Route
    Route::group(['middleware'=> 'guest'],function(){

        Route::get('/registerPage', [AccountController::class,'registerPage'])->name('registerPage');
        Route::post('/register', [AccountController::class,'register'])->name('register');
        Route::get('/loginPage', [AccountController::class,'loginPage'])->name('login');
        Route::post('/loginCheck', [AccountController::class,'loginCheck'])->name('loginCheck');
        
        Route::get('/forgetPasswordPage', [AccountController::class,'forgetPasswordPage'])->name('forgetPasswordPage');
        Route::post('/forgetPassword', [AccountController::class,'forgetPassword'])->name('forgetPassword');

        Route::get('/resetPasswordPage/{token}', [AccountController::class,'resetPasswordPage'])->name('resetPasswordPage');
        Route::post('/resetPassword', [AccountController::class,'resetPassword'])->name('resetPassword');

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