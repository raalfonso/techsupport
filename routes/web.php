<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;

Route::view('/', 'home.index')->name('home');



Route::middleware('auth')->group(function() {

    // Route::get('/issues', [IssuesController::class,'index'])->name('issues');
    Route::resource('issues',IssuesController::class);

    Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
    
    Route::resource('category',CategoryController::class);
    
    Route::resource('department',DepartmentController::class);

    Route::resource('report',ReportController::class);







    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    


});


Route::middleware('guest')->group(function () {

    
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

