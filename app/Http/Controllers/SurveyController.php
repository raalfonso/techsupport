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
            return redirect()->route('userSurvey.login')->with('error', 'You must be logged in to access the survey dashboard.');
        }

        // echo auth()->user()->department->title;
  
        // Fetch necessary data for the dashboard
        $employees = SurveyEmployees::where('department_id', auth()->user()->department_id)->get();
        $survey = SurveyReport::where('department_id', auth()->user()->department_id)->get();

        $total = SurveyReport::where('department_id', auth()->user()->department_id)->count();

        $superLikeAccuracy = SurveyReport::where('accuracy_of_service', 2)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $superLikeResponse = SurveyReport::where('response_time', 2)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        
        $superLikeA = $superLikeAccuracy / $total * 0.5;
        $superLikeR = $superLikeResponse / $total * 0.5;
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
        $likeA = $likeAccuracy / $total * 0.5;
        $likeR = $likeResponse / $total * 0.5;
        $like = $likeA + $likeR;
        $percentageLike = round($like * 100, 2);        

        // Calculate the percentage of "Dislike"
        $dislikeAccuracy = SurveyReport::where('accuracy_of_service', 0)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $dislikeResponse = SurveyReport::where('response_time', 0)
            ->where('department_id', auth()->user()->department_id)
            ->count();
        $dislikeA = $dislikeAccuracy / $total * 0.5;
        $dislikeR = $dislikeResponse / $total * 0.5;
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



         $dislikeAccuracy = SurveyReport::selectRaw('COUNT(response_time) as total_responses, survey_employees_id')
        ->where('accuracy_of_service', 0)
        ->groupBy('survey_employees_id')
        ->get();

        // print_r($likeAccuracy);
        // exit;
        // Process the data as needed
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

        // Pass the data to the view    
       

       


        // echo "<pre>";
        // print_r($superLikeAccuracy);






        return view('survey.dashboard', [
            'employees' => $employees,
            'surveys' => $survey,
            'total' => $total,
            'percentageSuperLike' => $percentageSuperLike,
            'percentageLike' => $percentageLike,
            'percentageDislike' => $percentageDislike,
            'superData' => $superData,
        ] );
    
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
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }




    public function form(Request $request)
    {
        $departmentCode = $request->query('dept');

        $employees = SurveyEmployees::where(['department_id' => $departmentCode])
            ->get();
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
            'survey_date' => 'required|date',
        ]);
        // Create a new survey report
        SurveyReport::create($fields);
        

        return redirect()->route('survey.thank-you')->with('success', 'Thank you for your feedback!');
    }

    public function thankyou()
    {
        return view('survey.thankyou')->with('customMessage', 'We appreciate your feedback!');
    }

}
