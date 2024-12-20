<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;

Route::get('/', [HomeController::class,'index'])->name('home');



Route::middleware('auth')->group(function() {

    // Route::get('/issues', [IssuesController::class,'index'])->name('issues');
    Route::resource('issues',IssuesController::class);

    Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
    
    Route::resource('category',CategoryController::class);
    
    Route::resource('department',DepartmentController::class);

    Route::resource('report',ReportController::class);
    Route::resource('main',ReportController::class);


    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');




    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    


});


Route::middleware('guest')->group(function () {

    Route::resource('report',ReportController::class);

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

