<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleSurveyController;
use App\Http\Controllers\{
    AuthController,
    AuthItemController,
    AuthItemChildController,
    AuthAssignmentController,
    DashboardController,
    IssuesController,
    CategoryController,
    DepartmentController,
    ReportController,
    HomeController,
    MainController,
    FeedbackController,
    ClientsController,
    ClientAuthController,
    ProfileController,
    SurveyController,
    UserSurveyAuthController,
    QrCodeController,
    SurveyEmployeeController,
    UserController,
    DevWatchController,
    ProjectController
};

/*
|--------------------------------------------------------------------------
| Authenticated Routes (IT Users)
|--------------------------------------------------------------------------
*/






Route::middleware('auth')->group(function () {
    // API Routes
    Route::prefix('api')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\Api\ReportController::class, 'index']);
        Route::get('/reports/{id}', [\App\Http\Controllers\Api\ReportController::class, 'show']);
        Route::put('/reports/{id}', [\App\Http\Controllers\Api\ReportController::class, 'update']);
        Route::delete('/reports/{id}', [\App\Http\Controllers\Api\ReportController::class, 'destroy']);
        Route::get('/reports-stats', [\App\Http\Controllers\Api\ReportController::class, 'stats']);
    });
    
    Route::resource('issues', IssuesController::class);
    Route::resource('auth', AuthItemController::class);
    Route::resource('auth-child', AuthItemChildController::class);
    Route::resource('auth-assignment', AuthAssignmentController::class);

    Route::resource('category', CategoryController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('devwatch', DevWatchController::class);
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/projects/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::resource('main', ReportController::class);
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
    Route::post('/report/emergency', [ReportController::class, 'emergency'])->name('report.emergency');
   
    Route::resource('report', ReportController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
    Route::get('/report/resolve/{id}', [ReportController::class, 'resolve'])->name('report.resolve');
    Route::get('/report/escalate/{id}', [ReportController::class, 'escalate'])->name('report.escalate');
    Route::get('/report/endorse/{id}', [ReportController::class, 'endorse'])->name('report.endorse');
    Route::post('/report/validate',[ReportController::class, 'validateReport'])->name('report.validate');
    Route::post('/report/confirm-validate',[ReportController::class, 'confirmValidate'])->name('report.confirmValidate');
    Route::post('/report/change-issue',[ReportController::class, 'changeIssue'])->name('report.changeIssue');
   
    Route::get('/home', [HomeController::class, 'login'])->name('home');
    // Route::view('/', 'home.home')->name('home');

    Route::get('/reports', [ReportController::class, 'getReports']);
    Route::get('/getstotal', [ReportController::class, 'getTotalReports']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
  
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    //user employee
    Route::view('/track', 'home.track')->name('track');
    Route::post('/check-email', [HomeController::class, 'checkEmail'])->name('client.check-email');
    Route::get('/tracking', [HomeController::class, 'employeeReport'])->name('home.employeeReport');
    Route::get('/home.index/{id}', [HomeController::class, 'index'])->name('home.index');
    Route::get('/home.cancel/{id}', [HomeController::class, 'cancel'])->name('home.cancel');
    Route::get('/home/add/{id}/{survey_employees_id}', [HomeController::class, 'add'])->name('home.add');

    Route::get('/view/{id}', [HomeController::class, 'view'])->name('home.view');
    Route::get('/viewstatus/{id}', [HomeController::class, 'viewStatus'])->name('home.status');
    Route::get('/feedback/{id}', [HomeController::class, 'feedback'])->name('home.feedback');
    Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::post('/save-data', [HomeController::class, 'saveData'])->name('home.data');
    Route::post('/track-view', [HomeController::class, 'trackView'])->name('home.track-view');
});

/*
|--------------------------------------------------------------------------
| Survey Routes (Employee Users)
|--------------------------------------------------------------------------
*/
Route::prefix('survey')->group(function () {
    Route::view('/survey/home', 'survey.index')->name('survey.index');

    //Check if already login using google
    Route::get('/', [SurveyController::class, 'checkLogin'])->name('survey.checkLogin');
    Route::get('/google/login', [GoogleSurveyController::class, 'redirect'])->name('survey.google.login');
    Route::get('/google/callback', [GoogleSurveyController::class, 'callback'])->name('survey.google.callback');
    // Authenticated employee routes
    Route::middleware('auth:userSurvey')->group(function () {
        Route::get('/dashboard', [SurveyController::class, 'index'])->name('survey.dashboard');
        Route::get('/dashboard/filter', [SurveyController::class, 'filter'])->name('survey.dashboard.filter');
        Route::post('/user-survey/logout', [UserSurveyAuthController::class, 'logout'])->name('userSurvey.logout');
        Route::post('/survey/register', [SurveyEmployeeController::class, 'store'])->name('survey.employee.store');
        Route::get('/management',[SurveyController::class, 'management'])->name('survey.management');
        Route::get('/account',[SurveyController::class, 'account'])->name('survey.account');
        Route::post('/upload-employees', [SurveyController::class, 'uploadEmployees'])->name('survey.uploadEmployees');
        Route::post('/change-password', [SurveyController::class, 'changePassword'])->name('survey.changePassword');
        Route::post('/chane-password-first-login', [SurveyController::class, 'changeFirstLogin'])->name('survey.changePasswordFirstLogin');
        Route::get('/changePasswordForm', [SurveyController::class, 'changePasswordForm'])->name('survey.changePasswordForm');
        Route::post('/employee/edit', [SurveyEmployeeController::class, 'edit'])->name('survey.employee.edit');
        Route::get('/export-results', [SurveyController::class, 'exportResults'])->name('survey.exportResults');
        
    });

    // Public employee survey routes
 
    Route::get('/register', [SurveyController::class, 'register'])->name('survey.register');
    Route::post('/register', [SurveyController::class, 'registerStore'])->name('survey.register.store');
    Route::get('/form', [SurveyController::class, 'form'])->name('survey.form');
    Route::post('/submit', [SurveyController::class, 'submit'])->name('survey.submit');
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('survey.thank-you');
    Route::post('/user-survey/login', [UserSurveyAuthController::class, 'login'])->name('userSurvey.login');
    // Route::view('/', 'survey.index')->name('survey.index');
    Route::get('/qrcode/{departmentCode}', [QrCodeController::class, 'generate'])->name('qrcode');
    Route::view('/thankyou', 'survey.thankyou')->name('survey.thankyou');   
    Route::get('/reports/loghistory/{id}', [ReportController::class, 'logHistory'])->name('report.loghistory');

});

/*
|--------------------------------------------------------------------------
| Guest Routes (Public Access)
|--------------------------------------------------------------------------
*/




Route::get('/', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/report/complete/{id}', [ReportController::class, 'complete'])->name('report.complete');

// Public API Routes
Route::prefix('api')->group(function () {
    Route::post('/reports', [\App\Http\Controllers\Api\ReportController::class, 'store']);
    Route::get('/test', function() { return response()->json(['message' => 'API working']); });
});

Route::middleware('guest')->group(function () {
   
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [GoogleController::class, 'redirect'])->name('login');
    // Route::post('/login', [AuthController::class, 'login']);
    
  
    Route::get('/login-client', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/ticket', [ClientAuthController::class, 'login'])->name('client.login.submit');

    Route::get('/search-suggestions', [ClientsController::class, 'suggestions']);
    Route::get('/search-department', [ClientsController::class, 'departments']);
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('thank-you');
   
    Route::get('/vcard', [QrCodeController::class, 'vcardform'])->name('vcard');
    Route::post('/generate-qrcode', [QrCodeController::class, 'generateVCard'])->name('generate.qr');
    Route::get('/qrcode', [QRCodeController::class, 'show'])->name('qr.show');
    Route::post('/qrcode/generateshow', [QRCodeController::class, 'generateshow'])->name('qr.generateshow');

});
