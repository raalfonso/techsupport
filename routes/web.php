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
    ProjectController,
    AttendanceLogController,
    EmployeeMasterlistController,
    SignatoryController,
    ItSurveyController,
    ItSurveyIssueController
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
    Route::post('/test-upload', function () {
        return 'OK';
    })->name('test-upload');
    Route::get('/vcard', [QrCodeController::class, 'vcardform'])->name('vcard');
    Route::post('/generate-qrcode', [QrCodeController::class, 'generateVCard'])->name('generate.qr');
    Route::get('/qrcode', [QRCodeController::class, 'show'])->name('qr.show');
    Route::post('/qrcode/generateshow', [QRCodeController::class, 'generateshow'])->name('qr.generateshow');
    
    Route::resource('issues', IssuesController::class);
    Route::resource('auth', AuthItemController::class);
    Route::resource('auth-child', AuthItemChildController::class);
    Route::resource('auth-assignment', AuthAssignmentController::class);

    Route::resource('category', CategoryController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('devwatch', DevWatchController::class);
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/projects/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::resource('employee-masterlist', EmployeeMasterlistController::class);
    Route::resource('signatory', SignatoryController::class);
    Route::resource('it-survey-issues', ItSurveyIssueController::class);
    Route::get('/signatory-employees/search', [SignatoryController::class, 'searchEmployees'])->name('signatory.employees.search');
    Route::get('/employee-masterlist/import/form', [EmployeeMasterlistController::class, 'importForm'])->name('employee-masterlist.import-form');
    Route::post('/employee-masterlist/import', [EmployeeMasterlistController::class, 'import'])->name('employee-masterlist.import');
    
    // Employee List Routes (Read-only for attendance module)
    Route::get('/employee-list', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employee-list.index');
    Route::get('/employee-list/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employee-list.create');
    Route::post('/employee-list', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee-list.store');
    Route::get('/employee-list/{employee}', [\App\Http\Controllers\EmployeeController::class, 'show'])->name('employee-list.show');
    Route::get('/employee-list/{employee}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee-list.edit');
    Route::put('/employee-list/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee-list.update');
    Route::delete('/employee-list/{employee}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee-list.destroy');
    
    Route::get('/attendance', [AttendanceLogController::class, 'dashboard'])->name('attendance.dashboard');
    Route::get('/attendance/search', [AttendanceLogController::class, 'search'])->name('attendance.search');
    Route::get('/attendance/export-csv', [AttendanceLogController::class, 'exportCSV'])->name('attendance.export-csv');
    Route::get('/attendance/print-accomplishments', [AttendanceLogController::class, 'printAccomplishments'])->name('attendance.print-accomplishments');
    Route::get('/attendance/employees', [AttendanceLogController::class, 'getEmployees'])->name('attendance.employees');
    Route::get('/attendance/departments', [AttendanceLogController::class, 'getDepartments'])->name('attendance.departments');
    Route::get('/attendance/present-today', [AttendanceLogController::class, 'presentToday'])->name('attendance.present-today');
    Route::get('/attendance/reports/export-pdf', [AttendanceLogController::class, 'exportWFHPdf'])->name('attendance.reports.export-pdf');
    Route::get('/attendance/print-pdf', [AttendanceLogController::class, 'printAttendancePdf'])->name('attendance.print-pdf');
    Route::get('/attendance/reports', [AttendanceLogController::class, 'reports'])->name('attendance.reports');
    Route::get('/attendance/statistics', [AttendanceLogController::class, 'statistics'])->name('attendance.statistics');
    Route::post('/attendance/clock-in', [AttendanceLogController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceLogController::class, 'clockOut'])->name('attendance.clock-out');
    Route::post('/accomplishment/store', [AttendanceLogController::class, 'storeAccomplishment'])->name('accomplishment.store');
    Route::resource('attendance-logs', AttendanceLogController::class);
    Route::resource('main', MainController::class);
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
    Route::post('/report/emergency', [ReportController::class, 'emergency'])->name('report.emergency');
   
    Route::resource('report', ReportController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('level:IT_user,Administrator');
    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
    Route::get('/report/resolve/{id}', [ReportController::class, 'resolve'])->name('report.resolve');
    Route::get('/report/escalate/{id}', [ReportController::class, 'escalate'])->name('report.escalate');
    Route::get('/report/endorse/{id}', [ReportController::class, 'endorse'])->name('report.endorse');
    Route::post('/report/validate',[ReportController::class, 'validateReport'])->name('report.validate');
    Route::post('/report/confirm-validate',[ReportController::class, 'confirmValidate'])->name('report.confirmValidate');
    Route::post('/report/change-issue',[ReportController::class, 'changeIssue'])->name('report.changeIssue');
   
    Route::get('/home', [HomeController::class, 'login'])->name('home');

    Route::get('/reports', [ReportController::class, 'getReports']);
    Route::get('/getstotal', [ReportController::class, 'getTotalReports']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    Route::resource('users', UserController::class);

    // Key Board Routes (Meeting Notes)
    Route::get('/keyboard', [App\Http\Controllers\KeyBoardController::class, 'index'])->name('keyboard.index');
    Route::get('/keyboard/calendar', [App\Http\Controllers\KeyBoardController::class, 'calendar'])->name('keyboard.calendar');
    Route::get('/keyboard/archive', [App\Http\Controllers\KeyBoardController::class, 'archive'])->name('keyboard.archive');
    Route::get('/keyboard/settings', [App\Http\Controllers\KeyBoardController::class, 'settings'])->name('keyboard.settings');
    Route::post('/keyboard/types', [App\Http\Controllers\KeyBoardController::class, 'storeType'])->name('keyboard.types.store');
    Route::put('/keyboard/types/{type}', [App\Http\Controllers\KeyBoardController::class, 'updateType'])->name('keyboard.types.update');
    Route::delete('/keyboard/types/{type}', [App\Http\Controllers\KeyBoardController::class, 'destroyType'])->name('keyboard.types.destroy');
    Route::post('/keyboard/agendas/{agenda}/status', [App\Http\Controllers\KeyBoardController::class, 'updateAgendaStatus']);
    Route::post('/keyboard/tasks/{task}/status', [App\Http\Controllers\KeyBoardController::class, 'updateTaskStatus']);
    Route::get('/meetings/{meetingDetail}/follow-up', [App\Http\Controllers\MeetingDetailController::class, 'createFollowUp'])->name('meetings.follow-up');
    Route::get('/meetings/{meetingDetail}/present', [App\Http\Controllers\MeetingDetailController::class, 'present'])->name('meetings.present');
    Route::resource('meetings', App\Http\Controllers\MeetingDetailController::class);
    Route::post('/meetings/{meetingDetail}/agendas', [App\Http\Controllers\MeetingDetailController::class, 'storeAgenda'])->name('meetings.agendas.store');
    Route::put('/agendas/{agenda}', [App\Http\Controllers\MeetingDetailController::class, 'updateAgenda'])->name('agendas.update');
    Route::delete('/agendas/{agenda}', [App\Http\Controllers\MeetingDetailController::class, 'destroyAgenda'])->name('agendas.destroy');
    Route::post('/meetings/{meetingDetail}/tasks', [App\Http\Controllers\MeetingDetailController::class, 'storeTask'])->name('meetings.tasks.store');
    Route::put('/tasks/{task}', [App\Http\Controllers\MeetingDetailController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [App\Http\Controllers\MeetingDetailController::class, 'destroyTask'])->name('tasks.destroy');
  
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

    Route::get('/', [SurveyController::class, 'checkLogin'])->name('survey.checkLogin');
    Route::get('/google/login', [GoogleSurveyController::class, 'redirect'])->name('survey.google.login');
    Route::get('/google/callback', [GoogleSurveyController::class, 'callback'])->name('survey.google.callback');
    
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

    Route::get('/register', [SurveyController::class, 'register'])->name('survey.register');
    Route::post('/register', [SurveyController::class, 'registerStore'])->name('survey.register.store');
    Route::get('/form', [SurveyController::class, 'form'])->name('survey.form');
    Route::post('/submit', [SurveyController::class, 'submit'])->name('survey.submit');
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('survey.thank-you');
    Route::post('/user-survey/login', [UserSurveyAuthController::class, 'login'])->name('userSurvey.login');
    Route::get('/qrcode/{departmentCode}', [QrCodeController::class, 'generate'])->name('qrcode');
    Route::view('/thankyou', 'survey.thankyou')->name('survey.thankyou');   
    Route::get('/reports/loghistory/{id}', [ReportController::class, 'logHistory'])->name('report.loghistory');
});

/*
|--------------------------------------------------------------------------
| IT Survey Routes
|--------------------------------------------------------------------------
*/
Route::prefix('it-survey')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ItSurveyController::class, 'index'])->name('it-survey.dashboard')->middleware('level:IT_user,Administrator');
        Route::get('/export-results', [ItSurveyController::class, 'exportResults'])->name('it-survey.exportResults')->middleware('level:IT_user,Administrator');
    });

    Route::get('/form', [ItSurveyController::class, 'form'])->name('it-survey.form');
    Route::post('/submit', [ItSurveyController::class, 'submit'])->name('it-survey.submit');
    Route::get('/thank-you', [ItSurveyController::class, 'thankYou'])->name('it-survey.thank-you');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Public Access)
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('google.redirect');
})->name('home.root');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/report/complete/{id}', [ReportController::class, 'complete'])->name('report.complete');
Route::get('/issues-reported', [ReportController::class, 'publicReports'])->name('report.public');

Route::prefix('api')->group(function () {
    Route::post('/reports', [\App\Http\Controllers\Api\ReportController::class, 'store']);
    Route::get('/test', function() { return response()->json(['message' => 'API working']); });
});

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [GoogleController::class, 'redirect'])->name('login');
    
    Route::get('/login-client', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/ticket', [ClientAuthController::class, 'login'])->name('client.login.submit');

    Route::get('/search-suggestions', [ClientsController::class, 'suggestions']);
    Route::get('/search-department', [ClientsController::class, 'departments']);
    Route::get('/thank-you', [SurveyController::class, 'thankYou'])->name('thank-you');
});
