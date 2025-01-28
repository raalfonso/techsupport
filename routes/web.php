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
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientAuthController;




Route::middleware('auth')->group(function() {

    Route::resource('issues',IssuesController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('category',CategoryController::class);
    Route::resource('department',DepartmentController::class);
    Route::resource('main',ReportController::class);
    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
    Route::get('/report/resolve/{id}', [ReportController::class, 'resolve'])->name('report.resolve');
    Route::get('/report/escalate/{id}', [ReportController::class, 'escalate'])->name('report.escalate');
    Route::resource('report',ReportController::class);
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/reports', [ReportController::class, 'getReports']);
    Route::get('/getstotal', [ReportController::class, 'getTotalReports']);
    
    // Route::resource('feedback',FeedbackController::class);

});


Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class,'login'])->name('home');
    Route::get('/home.index/{id}', [HomeController::class,'index'])->name('home.index');
    Route::get('/home.cancel/{id}', [HomeController::class,'cancel'])->name('home.cancel');

    Route::get('/search-suggestions', [ClientsController::class, 'suggestions']);
    Route::get('/search-department', [ClientsController::class, 'departments']);


    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
 
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/ticket', [ClientAuthController::class, 'login'])->name('client.login.submit');

    Route::view('/login', 'auth.login')->name('login');
    Route::view('/track', 'home.track')->name('track');
    Route::get('/home/add/{id}/{client_id}', [HomeController::class, 'add'])->name('home.add');
    Route::get('/home/add/{id}/{client_id}', [HomeController::class, 'add'])->name('home.add');

    Route::get('/view/{id}', [HomeController::class, 'view'])->name('home.view');
    Route::get('/viewstatus/{id}', [HomeController::class, 'viewStatus'])->name('home.status');
    Route::get('/feedback/{id}', [HomeController::class, 'feedback'])->name('home.feedback');
   
    Route::post('/save-data', [HomeController::class, 'saveData'])->name('home.data');
    Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::post('/track-view', [HomeController::class, 'trackView'])->name('home.track-view');


   
    Route::get('/login-client', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    
    // Route::get('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    

    

});

// Client Login Routes

