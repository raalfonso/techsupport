<?php

namespace App\Http\Controllers;

use App\Models\Resolve;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\UserSurvey;
use App\Models\SurveyEmployees;
use App\Models\SurveyReport;
use App\Models\Clients;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('survey.index')->with('error', 'You must be logged in to access the survey dashboard.');
        }

        // echo auth()->user()->department->title;
  
        // Fetch necessary data for the dashboard
        $employees = SurveyEmployees::where('department_id', auth()->user()->department_id)->paginate(10);
        $survey = SurveyReport::where('department_id', auth()->user()->department_id)->orderBy('id','desc')->paginate(10);

        $total = SurveyReport::where('department_id', auth()->user()->department_id)->count();

        $superLikeAccuracy = SurveyReport::where('accuracy_of_service', 2)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $superLikeResponse = SurveyReport::where('response_time', 2)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        
        if($superLikeAccuracy > 0)
        {
            $superLikeA = $superLikeAccuracy / $total * 0.5;
        }
        else
        {
             $superLikeA = 0;
        }

        if($superLikeResponse > 0)
        {     
            $superLikeR = $superLikeResponse / $total * 0.5;
        }
        else
        {
            $superLikeR = 0;
        }

      
        $superLike = $superLikeA + $superLikeR;
        // Calculate the percentage of "Super Like"
        $percentageSuperLike = round($superLike * 100, 2);


        // Calculate the percentage of "Like"
        $likeAccuracy = SurveyReport::where('accuracy_of_service', 1)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $likeResponse = SurveyReport::where('response_time', 1)     
            ->where('department_id', auth()->user()->department_id)
            ->count();
        
        if($likeAccuracy > 0)
        {
            $likeA = $likeAccuracy / $total * 0.5;
        }
        else
        {
            $likeA = 0;
        }

         if($likeResponse > 0)
        {
            $likeR = $likeResponse / $total * 0.5;
        }
        else
        {
            $likeR = 0;
        }
        
      
        $like = $likeA + $likeR;
        $percentageLike = round($like * 100, 2);        

        // Calculate the percentage of "Dislike"
        $dislikeAccuracy = SurveyReport::where('accuracy_of_service', 0)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $dislikeResponse = SurveyReport::where('response_time', 0)
            ->where('department_id', auth()->user()->department_id)
            ->count();


        if($dislikeAccuracy > 0){
             $dislikeA = $dislikeAccuracy / $total * 0.5;
        }
        else
        {
            $dislikeA = 0;
        }

        if($dislikeResponse > 0){
             $dislikeR = $dislikeResponse / $total * 0.5;
        }
        else
        {
            $dislikeR = 0;
        }
       
      
        $dislike = $dislikeA + $dislikeR;
        $percentageDislike = round($dislike * 100, 2);



    //this is for graph
        $employeess = SurveyEmployees::where('department_id', auth()->user()->department_id)
            ->orderBy('name', 'asc')
            ->get()->toArray();
        $superLikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, survey_employees_id')
            ->where('accuracy_of_service', 2)
            ->groupBy('survey_employees_id')
            ->orderBy('survey_employees_id','asc')
            ->get()
            ->toArray();
        $likeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, survey_employees_id')
            ->where('accuracy_of_service', 1)
            ->groupBy('survey_employees_id')
            ->get()->toArray();
         $dislikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, survey_employees_id')
            ->where('accuracy_of_service', 0)
            ->groupBy('survey_employees_id')
            ->get();

    // Re-index arrays for quick access
        $superLikeMap = collect($superLikeAccuracy)->keyBy('survey_employees_id');
        $likeMap = collect($likeAccuracy)->keyBy('survey_employees_id');
        $dislikeMap = collect($dislikeAccuracy)->keyBy('survey_employees_id');

        $superData = [];
            foreach ($employeess as $employee) {
                $id = $employee['id'];

                $superData[] = [
                    'employee_name' => $employee['name'],
                    'super_like'    => $superLikeMap[$id]['total_responses'] ?? 0,
                    'like'          => $likeMap[$id]['total_responses'] ?? 0,
                    'dislike'       => $dislikeMap[$id]['total_responses'] ?? 0,
                ];
            }
       
       
    
         $superLikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, survey_employees_id')
        ->where('response_time', 2)
        ->groupBy('survey_employees_id')
        ->get();

         $likeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, survey_employees_id')
        ->where('response_time', 1)
        ->groupBy('survey_employees_id')
        ->get();

         $dislikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, survey_employees_id')
        ->where('response_time', 0)
        ->groupBy('survey_employees_id')
        ->get();   

   // Re-index arrays for quick access
        $superLikeMapR = collect($superLikeResponseTime)->keyBy('survey_employees_id');
        $likeMapR = collect($likeResponseTime)->keyBy('survey_employees_id');
        $dislikeMapR = collect($dislikeResponseTime)->keyBy('survey_employees_id');

        $superDataR = [];
            foreach ($employeess as $employee) {
                $id = $employee['id'];

                $superDataR[] = [
                    'employee_name' => $employee['name'],
                    'super_like'    => $superLikeMapR[$id]['total_responses'] ?? 0,
                    'like'          => $likeMapR[$id]['total_responses'] ?? 0,
                    'dislike'       => $dislikeMapR[$id]['total_responses'] ?? 0,
                ];
            }

        // print_r($superDataR);
        //  die();



        return view('survey.dashboard', [
            'employees' => $employees,
            'surveys' => $survey,
            'total' => $total,
            'percentageSuperLike' => $percentageSuperLike,
            'percentageLike' => $percentageLike,
            'percentageDislike' => $percentageDislike,
            'superData' => $superData,
            'superDataR' => $superDataR,
        ] );
    
    }

    public function management()
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('survey.index')->with('error', 'You must be logged in to access the survey management.');
        }

        $users = UserSurvey::where('status','active')->paginate(10);
        $clients = Clients::all();
        $departments = Department::all();
        $employees = SurveyEmployees::where('status','active')->paginate(10);
        $survey = SurveyReport::all();

        return view('survey.management', [
            'clients' => $clients,
            'departments' => $departments,
            'employees' => $employees,
            'surveys' => $survey,
            'users' => $users,
        ] );
    }
    public function account()
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('survey.index')->with('error', 'You must be logged in to access the survey management.');
        }

        $userInfo = UserSurvey::where('id', auth()->user()->id)->first();

        return view('survey.account', [
            
            'userInfo' => $userInfo,
        ] );
    }
    public function changePasswordForm()
    {
        return view('survey.formpassword');
    }

    public function changeFirstLogin(Request $request)
    {   
        // Validate the request
         $request->validate([
            'password' => 'required|min:3|confirmed',
        ]);
        $user = auth()->user();
      
        // Update the password
        $user->password = Hash::make($request->password);
        $user = auth()->user();
        $user->first_login = false;
        $user->save();

        return redirect()->route('survey.dashboard')->with('success', 'Password changed successfully. Welcome to the survey dashboard!');
    }

    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:3|confirmed',
        ]);

        $user = auth()->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }   

    public function loginSurvey(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }

        return redirect()->back()->withErrors(['failed' => 'Invalid credentials']);
    }
    
    public function register(Request $request) {
        // regisration form 
        $departments = Department::all();
        return view('survey.register', compact('departments'));
    }

    public function registerStore(Request $request)
    {
        //validate
      $fields = $request->validate([
            'name' => ['required', 'max:150'],
            'email' => ['required', 'max:50', 'email', 'unique:user_survey,email'],
            'password' => ['required', 'min:3', 'confirmed'],
            'role' => ['required'],
            'department_id' => ['required'],
        ]);
    
        $fields['password'] = Hash::make($fields['password']); // ✅ hash the password

        UserSurvey::create($fields);

    // Optionally log the user in
        Auth::guard('userSurvey')->login(UserSurvey::where('email', $fields['email'])->first());

        return redirect()->route('survey.dashboard')->with('success', 'Registration successful. Welcome to the survey hub!');

    }

    /**
     * Logout the user from the survey.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logoutSurvey()
    {
        auth()->logout();
        return redirect()->route('survey.index')->with('success', 'Logged out successfully');
    }




    public function form(Request $request)
    {
        $departmentCode = $request->query('dept');

       $employees = SurveyEmployees::where(['department_id' => $departmentCode])
        ->get()
        ->map(function($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
            ];
        });
        $department = Department::where('id', $departmentCode)->first();

        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }

        return view('survey.form', [
            'department' => $department,
            'employees' => $employees,
        ]);

    }

    public function submit(Request $request)
    {
        $fields = $request->validate([
            'survey_employees_id' => 'required|exists:survey_employees,id',
            'department_id' => 'required|exists:departments,id',
            'accuracy_of_service' => 'required',
            'response_time' => 'required',
            'comments' => 'nullable|string|max:500',
            'client_name' => 'nullable|string|max:100',
           
        ]);

        $fields['survey_date'] = now()->toDateString();
        // Create a new survey report
        SurveyReport::create($fields);
        

        return redirect()->route('survey.thank-you')->with('success', 'Thank you for your feedback!');
    }

    public function thankyou()
    {
        return view('survey.thankyou')->with('customMessage', 'We appreciate your feedback!');
    }

    public function uploadEmployees(Request $request)
    {

    
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

       

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Assuming the first row contains headers
        $header = array_map('strtolower', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
            
            // Validate required fields
            if (isset($rowData['name'], $rowData['email'], $rowData['department_id'])) {
                // Check if the department exists
                $department = Department::find($rowData['department_id']);
                if ($department) {
                    // Create or update the employee
                    SurveyEmployees::updateOrCreate(
                        ['email' => $rowData['email']], // Unique field to check for existing records
                        [
                            'name' => $rowData['name'],
                            'department_id' => $rowData['department_id'],
                            'user_survey_id' => auth()->user()->id,
                        ]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Employees uploaded successfully.');
    }
}
