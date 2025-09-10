<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
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
    SurveyEmployeeController
};

/*
|--------------------------------------------------------------------------
| Authenticated Routes (IT Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('issues', IssuesController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('main', ReportController::class);
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
    Route::resource('report', ReportController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
    Route::get('/report/resolve/{id}', [ReportController::class, 'resolve'])->name('report.resolve');
    Route::get('/report/escalate/{id}', [ReportController::class, 'escalate'])->name('report.escalate');
    Route::get('/report/endorse/{id}', [ReportController::class, 'endorse'])->name('report.endorse');
    

    Route::get('/reports', [ReportController::class, 'getReports']);
    Route::get('/getstotal', [ReportController::class, 'getTotalReports']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Survey Routes (Employee Users)
|--------------------------------------------------------------------------
*/
Route::prefix('survey')->group(function () {
    Route::view('/', 'survey.index')->name('survey.index');

    // Authenticated employee routes
    Route::middleware('auth:userSurvey')->group(function () {
        Route::get('/dashboard', [SurveyController::class, 'index'])->name('survey.dashboard');
        Route::post('/user-survey/logout', [UserSurveyAuthController::class, 'logout'])->name('userSurvey.logout');
        Route::post('/survey/register', [SurveyEmployeeController::class, 'store'])->name('survey.employee.store');
        Route::get('/management',[SurveyController::class, 'management'])->name('survey.management');
        Route::get('/account',[SurveyController::class, 'account'])->name('survey.account');
        Route::post('/upload-employees', [SurveyController::class, 'uploadEmployees'])->name('survey.uploadEmployees');
        Route::post('/change-password', [SurveyController::class, 'changePassword'])->name('survey.changePassword');
        Route::post('/chane-password-first-login', [SurveyController::class, 'changeFirstLogin'])->name('survey.changePasswordFirstLogin');
        Route::get('/changePasswordForm', [SurveyController::class, 'changePasswordForm'])->name('survey.changePasswordForm');
    });

    // Public employee survey routes
 
    Route::get('/register', [SurveyController::class, 'register'])->name('survey.register');
    Route::post('/register', [SurveyController::class, 'registerStore'])->name('survey.register.store');
    Route::get('/form', [SurveyController::class, 'form'])->name('survey.form');
    Route::post('/submit', [SurveyController::class, 'submit'])->name('survey.submit');
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('survey.thank-you');
    Route::post('/user-survey/login', [UserSurveyAuthController::class, 'login'])->name('userSurvey.login');
    Route::view('/', 'survey.index')->name('survey.index');
    Route::get('/qrcode/{departmentCode}', [QrCodeController::class, 'generate'])->name('qrcode');
    Route::view('/thankyou', 'survey.thankyou')->name('survey.thankyou');   
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Public Access)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'login'])->name('home');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/track', 'home.track')->name('track');
    Route::get('/home.index/{id}', [HomeController::class, 'index'])->name('home.index');
    Route::get('/home.cancel/{id}', [HomeController::class, 'cancel'])->name('home.cancel');
    Route::get('/home/add/{id}/{client_id}', [HomeController::class, 'add'])->name('home.add');

    Route::get('/view/{id}', [HomeController::class, 'view'])->name('home.view');
    Route::get('/viewstatus/{id}', [HomeController::class, 'viewStatus'])->name('home.status');
    Route::get('/feedback/{id}', [HomeController::class, 'feedback'])->name('home.feedback');
    Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::post('/save-data', [HomeController::class, 'saveData'])->name('home.data');
    Route::post('/track-view', [HomeController::class, 'trackView'])->name('home.track-view');

    Route::post('/check-email', [HomeController::class, 'checkEmail'])->name('client.check-email');
    Route::get('/tracking', [HomeController::class, 'employeeReport'])->name('home.employeeReport');

    Route::get('/login-client', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/ticket', [ClientAuthController::class, 'login'])->name('client.login.submit');

    Route::get('/search-suggestions', [ClientsController::class, 'suggestions']);
    Route::get('/search-department', [ClientsController::class, 'departments']);
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('thank-you');
   
    Route::get('/vcard', [QrCodeController::class, 'vcardform'])->name('vcard');
    Route::post('/generate-qrcode', [QrCodeController::class, 'generateVCard'])->name('generate.qr');
   

});
