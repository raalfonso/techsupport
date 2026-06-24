<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Resolve;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\UserSurvey;
use App\Models\SurveyEmployees;
use App\Models\SurveyReport;
use Barryvdh\DomPDF\Facade\Pdf;
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
        if((auth()->user()->role === 'superadmin')||(auth()->user()->role === 'admin')){
            $employeesQuery = SurveyEmployees::where('status', 'active');
            
            if (request('search')) {
                $search = request('search');
                $employeesQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhereHas('department', function($dept) use ($search) {
                          $dept->where('title', 'like', '%' . $search . '%');
                      });
                });
            }
            
            $employees = $employeesQuery->paginate(10)->withQueryString();
            $survey = SurveyReport::orderBy('id','desc')->paginate(10);

            $total = SurveyReport::count();

            $superLikeAccuracy = SurveyReport::where('accuracy_of_service', 2)
                ->count();
            $superLikeResponse = SurveyReport::where('response_time', 2)
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
                ->count();
            $likeResponse = SurveyReport::where('response_time', 1)     
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
                ->count();
            $dislikeResponse = SurveyReport::where('response_time', 0)
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
            $departments = Department::where('active','1')->orderBy('title', 'asc')
                ->get()->toArray();
           
            $superLikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, department_id')
                ->where('accuracy_of_service', 2)
                ->groupBy('department_id')
                ->orderBy('department_id','asc')
                ->get()
                ->toArray();
            $likeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, department_id')
                ->where('accuracy_of_service', 1)
                ->groupBy('department_id')
                ->get()->toArray();
            $dislikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses, department_id')
                ->where('accuracy_of_service', 0)
                ->groupBy('department_id')
                ->get();

            // Re-index arrays for quick access
            $superLikeMap = collect($superLikeAccuracy)->keyBy('department_id');
            $likeMap = collect($likeAccuracy)->keyBy('department_id');
            $dislikeMap = collect($dislikeAccuracy)->keyBy('department_id');

            $superData = [];
                foreach ($departments as $department) {
                    $id = $department['id'];

                    $superData[] = [
                        'employee_name' => $department['acronym'],
                        'super_like'    => $superLikeMap[$id]['total_responses'] ?? 0,
                        'like'          => $likeMap[$id]['total_responses'] ?? 0,
                        'dislike'       => $dislikeMap[$id]['total_responses'] ?? 0,
                    ];
                }

        
            $superLikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, department_id')
            ->where('response_time', 2)
            ->groupBy('department_id')
            ->get();

            $likeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, department_id')
            ->where('response_time', 1)
            ->groupBy('department_id')
            ->get();

            $dislikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses, department_id')
            ->where('response_time', 0)
            ->groupBy('department_id')
            ->get();   

            // Re-index arrays for quick access
            $superLikeMapR = collect($superLikeResponseTime)->keyBy('department_id');
            $likeMapR = collect($likeResponseTime)->keyBy('department_id');
            $dislikeMapR = collect($dislikeResponseTime)->keyBy('department_id');

            $superDataR = [];
                 foreach ($departments as $department) {
                    $id = $department['id'];

                    $superDataR[] = [
                        'employee_name' => $department['acronym'],
                        'super_like'    => $superLikeMapR[$id]['total_responses'] ?? 0,
                        'like'          => $likeMapR[$id]['total_responses'] ?? 0,
                        'dislike'       => $dislikeMapR[$id]['total_responses'] ?? 0,
                    ];
                }

            return view('survey.dashboard-admin', [
                'employees' => $employees,
                'surveys' => $survey,
                'total' => $total,
                'percentageSuperLike' => $percentageSuperLike,
                'percentageLike' => $percentageLike,
                'percentageDislike' => $percentageDislike,
                'superData' => $superData,
                'superDataR' => $superDataR,
                'departments' => Department::where('active','1')->orderBy('title', 'asc')->get(),
            ] );

       
        }else{
            $employeesQuery = SurveyEmployees::where('department_id', auth()->user()->department_id)->where('status', 'active');
            
            if (request('search')) {
                $search = request('search');
                $employeesQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            $employees = $employeesQuery->paginate(10)->withQueryString();
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
                ->where('status', 'active')
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
            }
        
        return view('survey.dashboard', [
            'employees' => $employees,
            'surveys' => $survey,
            'total' => $total,
            'percentageSuperLike' => $percentageSuperLike,
            'percentageLike' => $percentageLike,
            'percentageDislike' => $percentageDislike,
            'superData' => $superData,
            'superDataR' => $superDataR,
            'departments' => Department::where('active','1')->orderBy('title', 'asc')->get(),
        ]);
    
    }
    public function filter(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->endOfDay();
        $user = auth()->user();
        $isUser = $user->role === 'user';
        $departmentId = $request->input('department_id');

        $baseQuery = SurveyReport::query()->whereBetween('created_at', [$startDate, $endDate]);

        if ($isUser) {
            $baseQuery->where('department_id', $user->department_id);
        } elseif ($departmentId) {
            $baseQuery->where('department_id', $departmentId);
        }

        $total = (clone $baseQuery)->count();

        $superLikeAccuracy = (clone $baseQuery)->where('accuracy_of_service', 2)->count();
        $superLikeResponse = (clone $baseQuery)->where('response_time', 2)->count();
        $likeAccuracy = (clone $baseQuery)->where('accuracy_of_service', 1)->count();
        $likeResponse = (clone $baseQuery)->where('response_time', 1)->count();
        $dislikeAccuracy = (clone $baseQuery)->where('accuracy_of_service', 0)->count();
        $dislikeResponse = (clone $baseQuery)->where('response_time', 0)->count();

        $percentageSuperLike = $total > 0
            ? round(((($superLikeAccuracy / $total) * 0.5) + (($superLikeResponse / $total) * 0.5)) * 100, 2)
            : 0;
        $percentageLike = $total > 0
            ? round(((($likeAccuracy / $total) * 0.5) + (($likeResponse / $total) * 0.5)) * 100, 2)
            : 0;
        $percentageDislike = $total > 0
            ? round(((($dislikeAccuracy / $total) * 0.5) + (($dislikeResponse / $total) * 0.5)) * 100, 2)
            : 0;

        $filterDeptId = $isUser ? $user->department_id : $departmentId;

        if ($isUser || $filterDeptId) {
            $entities = SurveyEmployees::where('department_id', $filterDeptId)
                ->where('status', 'active')
                ->orderBy('name', 'asc')->get();
            $groupColumn = 'survey_employees_id';
            $labelColumn = 'name';
        } else {
            $entities = Department::where('active', '1')->orderBy('title', 'asc')->get();
            $groupColumn = 'department_id';
            $labelColumn = 'acronym';
        }

        $superLikeMap = (clone $baseQuery)
            ->where('accuracy_of_service', 2)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $likeMap = (clone $baseQuery)
            ->where('accuracy_of_service', 1)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $dislikeMap = (clone $baseQuery)
            ->where('accuracy_of_service', 0)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $superLikeMapR = (clone $baseQuery)
            ->where('response_time', 2)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $likeMapR = (clone $baseQuery)
            ->where('response_time', 1)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $dislikeMapR = (clone $baseQuery)
            ->where('response_time', 0)
            ->selectRaw("{$groupColumn}, COUNT(*) as total_responses")
            ->groupBy($groupColumn)
            ->pluck('total_responses', $groupColumn);

        $superData = [];
        $superDataR = [];

        foreach ($entities as $entity) {
            $entityId = $entity->id;
            $entityLabel = $entity->{$labelColumn};

            $superData[] = [
                'employee_name' => $entityLabel,
                'super_like' => (int) ($superLikeMap[$entityId] ?? 0),
                'like' => (int) ($likeMap[$entityId] ?? 0),
                'dislike' => (int) ($dislikeMap[$entityId] ?? 0),
            ];

            $superDataR[] = [
                'employee_name' => $entityLabel,
                'super_like' => (int) ($superLikeMapR[$entityId] ?? 0),
                'like' => (int) ($likeMapR[$entityId] ?? 0),
                'dislike' => (int) ($dislikeMapR[$entityId] ?? 0),
            ];
        }

        return response()->json([
            'total' => $total,
            'percentageSuperLike' => $percentageSuperLike.'%',
            'percentageLike' => $percentageLike.'%',
            'percentageDislike' => $percentageDislike.'%',
            'superData' => $superData,
            'superDataR' => $superDataR,
            'comments' => $this->getCommentsHtml($baseQuery),
            'commentsCount' => (clone $baseQuery)->whereNotNull('comments')->where('comments', '!=', '')->count()
        ]);
    }
    
    private function getCommentsHtml($query)
    {
        $comments = (clone $query)->whereNotNull('comments')
            ->where('comments', '!=', '')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $html = '';
        
        if ($comments->isEmpty()) {
            $html = '<div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <i class="material-icons text-gray-400 text-3xl">chat_bubble_outline</i>
                </div>
                <p class="text-gray-500 text-sm">No comments available for selected filters</p>
            </div>';
        } else {
            foreach ($comments as $comment) {
                $initial = substr($comment->client_name ?? 'C', 0, 1);
                $clientName = e($comment->client_name ?? 'Anonymous');
                $timeAgo = $comment->created_at->diffForHumans();
                $employeeName = e($comment->surveyEmployee->name ?? 'Unknown');
                $commentText = e($comment->comments);

                if ($comment->accuracy_of_service == 2) {
                    $accuracyBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                        <i class="material-icons text-sm mr-1">sentiment_very_satisfied</i>
                        Super Like
                    </span>';
                } elseif ($comment->accuracy_of_service == 1) {
                    $accuracyBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                        <i class="material-icons text-sm mr-1">thumb_up</i>
                        Like
                    </span>';
                } else {
                    $accuracyBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                        <i class="material-icons text-sm mr-1">thumb_down</i>
                        Dislike
                    </span>';
                }

                if ($comment->response_time == 2) {
                    $responseLabel = '<span class="text-emerald-600 font-semibold ml-1">Fast</span>';
                } elseif ($comment->response_time == 1) {
                    $responseLabel = '<span class="text-blue-600 font-semibold ml-1">Good</span>';
                } else {
                    $responseLabel = '<span class="text-red-600 font-semibold ml-1">Slow</span>';
                }

                $html .= '<div class="bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg">' . $initial . '</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">' . $clientName . '</p>
                                    <p class="text-xs text-gray-500">' . $timeAgo . '</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    ' . $accuracyBadge . '
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">' . $commentText . '</p>
                            <div class="mt-2 flex items-center space-x-3 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="material-icons text-sm mr-1">person</i>
                                    ' . $employeeName . '
                                </span>
                                <span class="flex items-center">
                                    <i class="material-icons text-sm mr-1">schedule</i>
                                    Response: ' . $responseLabel . '
                                </span>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }

        return $html;
    }
    

public function checkLogin()
{
    // Check if user is authenticated with userSurvey guard
    if (auth('userSurvey')->check()) {
        return redirect()->route('survey.dashboard');
    }
    
    // Check if user is authenticated with regular guard and has survey access
    if (auth()->check()) {
        $user = auth()->user();
        
        // Check if this user exists in UserSurvey table
        $surveyUser = UserSurvey::where('email', '=', $user->email)->first();
        
        if ($surveyUser) {
            // Login with userSurvey guard and redirect
            Auth::guard('userSurvey')->login($surveyUser);
            return redirect()->route('survey.dashboard');
        }
        
        abort(403, 'Access Denied - User not found in survey system.');
    }
    
    // Not authenticated, redirect to survey Google login
    return redirect()->route('survey.google.login');
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
        Auth::guard('userSurvey')->login(UserSurvey::where('email', '=', $fields['email'])->first());

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
       ->where('status', 'active')
        ->get()
        ->map(function($employee) {
            return [
                'id' => $employee->id,
                'name' => e($employee->name),
            ];
        });
        $department = Department::where('id', '=', $departmentCode)->first();

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
            'file' => 'required|file|mimes:csv,txt|mimetypes:text/csv,text/plain|max:2048',
        ]);

       

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Assuming the first row contains headers
        $header = array_map('strtolower', array_shift($data));

        $currentUserId = auth()->id();
        
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
                            'user_survey_id' => $currentUserId,
                        ]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Employees uploaded successfully.');
    }



    public function management()
    {
        $users = \App\Models\UserSurvey::paginate(10);
        return view('survey.management', compact('users'));
    }

    public function exportResults(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $departmentId = $request->input('department_id');
        
       if($startDate && $endDate) {
            $reports = SurveyReport::whereBetween('created_at',[
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay(),
                ])->get();

            if((auth()->user()->role === 'superadmin') || (auth()->user()->role === 'admin')) {
                if ($departmentId) {
                    $reports = $reports->where('department_id', $departmentId);
                    $departmentName = Department::where('id', $departmentId)->value('title');
                
                } else {
                    // $departmentId = "null";
                    $departmentName = 'All Departments';
                }
                //   this is for the superlike 
                $superLikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 2)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->where('department_id','like',"%{$departmentId}%")
                    ->get();

                $likeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 1)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                     ->where('department_id','like',"%{$departmentId}%")
                    ->get();

                $dislikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 0)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->where('department_id','like',"%{$departmentId}%")
                    ->get();

                $total = $superLikeAccuracy->first()->total_responses + $likeAccuracy->first()->total_responses + $dislikeAccuracy->first()->total_responses;   

                $consolidation = [
                    'super_like' => $superLikeAccuracy->first()->total_responses ?? 0,
                    'like' => $likeAccuracy->first()->total_responses ?? 0,
                    'dislike' => $dislikeAccuracy->first()->total_responses ?? 0,
                    'total' => $total,
                ];

                // this is for the response time
                $superLikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 2)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->where('department_id','like',"%{$departmentId}%")
                    ->get();
                $likeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 1)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                     ->where('department_id','like',"%{$departmentId}%")
                    ->get();
                $dislikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 0)     
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->where('department_id','like',"%{$departmentId}%")
                    ->get();
            
                $totalResponseTime = $superLikeResponseTime->first()->total_responses + $likeResponseTime->first()->total_responses + $dislikeResponseTime->first()->total_responses;
                
                $consolidationResponse = [
                    'super_like' => $superLikeResponseTime->first()->total_responses ?? 0,
                    'like' => $likeResponseTime->first()->total_responses ?? 0,
                    'dislike' => $dislikeResponseTime->first()->total_responses ?? 0,
                    'total' => $totalResponseTime,
                ];

                $performance = [
                    'super_like_total' => $consolidation['super_like'] + $consolidationResponse['super_like'],
                    'like_total' => $consolidation['like'] + $consolidationResponse['like'],
                    'dislike_total' => $consolidation['dislike'] + $consolidationResponse['dislike'],
                    'grand_total' => $consolidation['total'] + $consolidationResponse['total'],
                ];

                // print_r($consolidationResponse);

                // percentage calculations 
                $consolidationPercentage = [
                    'super_like' => $consolidation['super_like'] > 0 ? round(($consolidation['super_like'] / $consolidation['total']) * 100, 2) : 0,
                    'like' => $consolidation['like'] > 0 ? round(($consolidation['like'] / $consolidation['total']) * 100, 2) : 0,
                    'dislike' => $consolidation['dislike'] > 0 ? round(($consolidation['dislike'] / $consolidation['total']) * 100, 2) : 0,
                    
                ];

                $responsePercentage = [
                    'super_like' => $consolidationResponse['super_like'] > 0 ? round(($consolidationResponse['super_like'] / $consolidationResponse['total']) * 100, 2) : 0,
                    'like' => $consolidationResponse['like'] > 0 ? round(($consolidationResponse['like'] / $consolidationResponse['total']) * 100, 2) : 0,
                    'dislike' => $consolidationResponse['dislike'] > 0 ? round(($consolidationResponse['dislike'] / $consolidationResponse['total']) * 100, 2) : 0,
                ];

                $performancePercentage = [
                    'super_like_average' => $responsePercentage['super_like'] != 0 ? round(($consolidationPercentage['super_like'] + $responsePercentage['super_like'])/2, 2) : 0,
                    'like_average' => $responsePercentage['like'] != 0 ? round(($consolidationPercentage['like'] + $responsePercentage['like'])/2, 2) : 0,
                    'dislike_average' => $responsePercentage['dislike'] != 0 ? round(($consolidationPercentage['dislike'] + $responsePercentage['dislike'])/2, 2) : 0,
                ];

                // this will return to pdf template 
                return view('survey.export', [
                    'reports' => $reports,
                    'consolidation' => $consolidation,
                    'consolidationResponse' => $consolidationResponse,
                    'performance' => $performance,
                    'consolidationPercentage' => $consolidationPercentage,
                    'responsePercentage' => $responsePercentage,
                    'performancePercentage' => $performancePercentage,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'department' => $departmentName,
                    
                ]);


            }else if(auth()->user()->role == 'user'){
                $reports = SurveyReport::where('department_id', auth()->user()->department_id)->get();
                $departmentName = Department::where('id', auth()->user()->department_id)->value('title');
                //   this is for the superlike 
                $superLikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 2)
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();

                $likeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 1)
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();

                $dislikeAccuracy = SurveyReport::selectRaw('COUNT(accuracy_of_service) as total_responses')
                    ->where('accuracy_of_service', 0)
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();

                $total = $superLikeAccuracy->first()->total_responses + $likeAccuracy->first()->total_responses + $dislikeAccuracy->first()->total_responses;   

                $consolidation = [
                    'super_like' => $superLikeAccuracy->first()->total_responses ?? 0,
                    'like' => $likeAccuracy->first()->total_responses ?? 0,
                    'dislike' => $dislikeAccuracy->first()->total_responses ?? 0,
                    'total' => $total,
                ];

                // this is for the response time
                $superLikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 2)
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();
                $likeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 1)
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();
                $dislikeResponseTime = SurveyReport::selectRaw('COUNT(response_time) as total_responses')
                    ->where('response_time', 0)     
                    ->where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();
            
                $totalResponseTime = $superLikeResponseTime->first()->total_responses + $likeResponseTime->first()->total_responses + $dislikeResponseTime->first()->total_responses;
                
                $consolidationResponse = [
                    'super_like' => $superLikeResponseTime->first()->total_responses ?? 0,
                    'like' => $likeResponseTime->first()->total_responses ?? 0,
                    'dislike' => $dislikeResponseTime->first()->total_responses ?? 0,
                    'total' => $totalResponseTime,
                ];

                $performance = [
                    'super_like_total' => $consolidation['super_like'] + $consolidationResponse['super_like'],
                    'like_total' => $consolidation['like'] + $consolidationResponse['like'],
                    'dislike_total' => $consolidation['dislike'] + $consolidationResponse['dislike'],
                    'grand_total' => $consolidation['total'] + $consolidationResponse['total'],
                ];

                // print_r($consolidationResponse);

                // percentage calculations 
                $consolidationPercentage = [
                    'super_like' => $consolidation['super_like'] > 0 ? round(($consolidation['super_like'] / $consolidation['total']) * 100, 2) : 0,
                    'like' => $consolidation['like'] > 0 ? round(($consolidation['like'] / $consolidation['total']) * 100, 2) : 0,
                    'dislike' => $consolidation['dislike'] > 0 ? round(($consolidation['dislike'] / $consolidation['total']) * 100, 2) : 0,
                    
                ];

                $responsePercentage = [
                    'super_like' => $consolidationResponse['super_like'] > 0 ? round(($consolidationResponse['super_like'] / $consolidationResponse['total']) * 100, 2) : 0,
                    'like' => $consolidationResponse['like'] > 0 ? round(($consolidationResponse['like'] / $consolidationResponse['total']) * 100, 2) : 0,
                    'dislike' => $consolidationResponse['dislike'] > 0 ? round(($consolidationResponse['dislike'] / $consolidationResponse['total']) * 100, 2) : 0,
                ];

                $performancePercentage = [
                    'super_like_average' => $responsePercentage['super_like'] != 0 ? round(($consolidationPercentage['super_like'] + $responsePercentage['super_like'])/2, 2) : 0,
                    'like_average' => $responsePercentage['like'] != 0 ? round(($consolidationPercentage['like'] + $responsePercentage['like'])/2, 2) : 0,
                    'dislike_average' => $responsePercentage['dislike'] != 0 ? round(($consolidationPercentage['dislike'] + $responsePercentage['dislike'])/2, 2) : 0,
                ];

                // this will return to pdf template 
                return view('survey.export', [
                    'reports' => $reports,
                    'consolidation' => $consolidation,
                    'consolidationResponse' => $consolidationResponse,
                    'performance' => $performance,
                    'consolidationPercentage' => $consolidationPercentage,
                    'responsePercentage' => $responsePercentage,
                    'performancePercentage' => $performancePercentage,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ]);
            }else{
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
        } 
     
        
      


  
    }

    public function exportResultsPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $departmentId = $request->input('department_id');

        if ($startDate && $endDate) {

            if((auth()->user()->role === 'superadmin') || (auth()->user()->role === 'admin')) {
        
                if ($departmentId) {
                    $reports = SurveyReport::where('department_id', $departmentId)
                        ->whereBetween('created_at', [
                            Carbon::parse($startDate)->startOfDay(),
                            Carbon::parse($endDate)->endOfDay(),
                        ])->get();
                     $departmentName = Department::where('id', $departmentId)->value('title');
                } else {                     
                    $reports = SurveyReport::whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])->get();
                     $departmentName = "All Departments";
                }
              
            }else{
                $reports = SurveyReport::where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ])
                    ->get();
            }
        

            return view('survey.export-result', [
                'reports' => $reports,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'department' => Department::all(),
                'departmentName' => $departmentName ?? null,
            ]);
        } else {
            return redirect()->back()->with('error', 'Please provide both start and end dates.');
        }
    }

    public function searchSurvey(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->endOfDay();
        $departmentId = $request->input('department_id');

        if((auth()->user()->role === 'superadmin') || (auth()->user()->role === 'admin')){
             $query = SurveyReport::whereBetween('created_at', [
                 Carbon::parse($startDate)->startOfDay(),
                 Carbon::parse($endDate)->endOfDay(),
             ]);
             if ($departmentId) {
                 $query->where('department_id', $departmentId);
             }
             $results = $query->get();
        }else if(auth()->user()->role == 'user'){
             $query = SurveyReport::where('department_id', auth()->user()->department_id)
                    ->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ]);
                    
        }
        else {
             $query = SurveyReport::whereBetween('created_at', [
                 Carbon::parse($startDate)->startOfDay(),
                 Carbon::parse($endDate)->endOfDay(),
             ]);
             if ($departmentId) {
                 $query->where('department_id', $departmentId);
             }
           
        }
          $results = $query->paginate(50);
        foreach($results as $result){
            $data[] = "<tr class='hover:bg-gray-50 transition duration-150'>
                <td class='py-4 px-6 text-sm text-gray-600'>".$result->created_at->format('F j, Y')."</td>
                <td class='py-4 px-6 text-sm text-gray-600 font-medium'>".$result->surveyEmployee->name."</td>
                <td class='py-4 px-6'>".$this->getAccuracyLabel($result->accuracy_of_service)."</td>
                <td class='py-4 px-6'>".$this->getResponseTimeLabel($result->response_time)."</td>
                <td class='py-4 px-6 text-sm text-gray-600'>".e($result->comments)."</td>
                <td class='py-4 px-6 text-sm text-gray-600'>".e($result->client_name)."</td>
            </tr>";
        }
                     
    
            
        return response()->json([
        'success' => true,
        'query' => $validated,
        'data' => $data ?? [],
         'pagination' => $results->links('pagination::tailwind')->render(),
        ]);
    }

    public function getAccuracyLabel($accuracy)
    {
        switch ($accuracy) {
            case 2:
                return '<span class="text-green-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span></span>';
            case 1:
                return '<span class="text-blue-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Like
                                  </span></span>';
            case 0:
                return '<span class="text-red-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.7₀7-9.293a1 1  0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Dislike 
                                  </span></span>';
            default:            
                return '<span class="text-gray-600 font-semibold">Unknown</span>';
        }
    }

    public function getResponseTimeLabel($responseTime)
    {
        switch ($responseTime) {
            case 2:
                return '<span class="text-green-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span></span>';
            case 1:
                return '<span class="text-blue-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Like
                                  </span></span>';
            case 0:
                return '<span class="text-red-600 font-semibold"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.7₀7-9.293a1 1  0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Dislike 
                                  </span></span>';
            default:            
                return '<span class="text-gray-600 font-semibold">Unknown</span>';
        }
    }   
}
