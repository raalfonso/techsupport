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




Route::middleware('auth')->group(function() {

    // Route::get('/issues', [IssuesController::class,'index'])->name('issues');
    Route::resource('issues',IssuesController::class);

    Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
    
    Route::resource('category',CategoryController::class);
    
    Route::resource('department',DepartmentController::class);



    Route::resource('main',ReportController::class);


    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
    Route::get('/report/resolve/{id}', [ReportController::class, 'resolve'])->name('report.resolve');

    Route::resource('report',ReportController::class);


    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    


});


Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
  

   
    // Route::get('/report/index', [reportController::class,'index'])->name('report.index');

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/track', 'home.track')->name('track');
    Route::get('/home.add/{id}', [HomeController::class, 'add'])->name('home.add');
    Route::get('/home.view/{id}', [HomeController::class, 'view'])->name('home.view');
    // Route::match(['get', 'post'], '/save-data', [HomeController::class, 'saveData'])->name('save.data');
    Route::post('/save-data', [HomeController::class, 'saveData'])->name('home.data');
    Route::post('/track-view', [HomeController::class, 'trackView'])->name('home.track-view');


});

