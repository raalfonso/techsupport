<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT Survey Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>

<div class="max-w-3xl mx-auto mt-5 bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-start">
        <div class="w-1/2">
            <p class="italic text-[11px] font-medium">BCDA-IT-SURVEY</p>
            <p class="italic text-[11px] font-medium">{{ now()->format('F Y') }}</p>
        </div>
        <div class="w-1/2 flex justify-end">
            <img src="{{ asset('img/company_logo.png') }}" alt="BCDA Logo" class="w-24 h-18">
        </div>
    </div>

    <div class="title text-center mb-8 mt-10">
        <h1 class="text-sm font-bold text-gray-800 sm:text-lg md:text-3xl">
            IT Services Feedback Form
        </h1>
    </div>

    <form action="{{ route('it-survey.submit') }}" method="POST" class="space-y-6">
        @csrf

        <div class="flex items-center space-x-2">
            <label for="survey_date" class="text-md font-medium">Date: {{ now()->format('F d, Y') }}</label>
        </div>

        <div class="mb-6">
            <label class="block text-md font-medium mb-2">Select Issue <span class="text-red-500">*</span></label>
            <select name="issues_id" id="issues-select" class="w-full border border-gray-300 rounded px-4 py-2 text-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select an Issue --</option>
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}" data-title="{{ $issue->title }}">{{ $issue->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6 hidden" id="other-issues-container">
            <label class="block text-md font-medium mb-2">Other Issues <span class="text-red-500">*</span></label>
            <input type="text" name="other_issues" id="other-issues-input" class="w-full border border-gray-300 rounded px-4 py-2 text-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Please specify the issue" autocomplete="off">
        </div>

        <div class="mb-6">
            <label class="block text-md font-medium mb-2">Who provided you with the support service?</label>
            <div class="relative" id="employee-search-container">
                <input 
                    type="text" 
                    id="employee-search"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                    placeholder="Search employee..."
                    autocomplete="off"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-caret-down text-gray-400 ml-5"></i>
                </div>
                <div id="suggestions-container" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
            </div>
            <div id="selected-employee" class="relative hidden p-3">
                <div class="flex justify-between items-center">
                    <div>
                        <span id="selected-name" class="font-medium"></span>
                        <span id="selected-number" class="text-gray-600 text-sm ml-2"></span>
                    </div>
                    <button type="button" id="clear-selection" class="text-blue-500 hover:text-blue-700 text-sm">
                        <i class="fas fa-times-circle ml-5"></i> Change
                    </button>
                </div>
            </div>
            <input type="hidden" name="employee_number" id="employee-number">
        </div>
        <div class="mb-6">
            <label class="block text-md font-medium mb-2">1. Was your issue or concern resolved?</label>
            <div class="space-y-2">
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_2" value="Yes" class="mr-3">
                    <span>Yes</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_2" value="No" class="mr-3">
                    <span>No</span>
                </label>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-md font-medium mb-2">2. How quickly did the support attend to you?</label>
            <p class="text-sm text-gray-600 mb-3">Please rate, with 1 (Slow) being the lowest and 5 (Fast) as the highest.</p>
            <div class="space-y-2">
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_1" value="5" class="mr-3">
                    <span>5. Within a few minutes</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_1" value="4" class="mr-3">
                    <span>4. Within a few hours</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_1" value="3" class="mr-3">
                    <span>3. Within the day</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_1" value="2" class="mr-3">
                    <span>2. The next day</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_1" value="1" class="mr-3">
                    <span>1. After a few days</span>
                </label>
            </div>
        </div>

        

        <div class="mb-6">
            <label class="block text-md font-medium mb-2">3. How would you rate the support service provided?</label>
            <p class="text-sm text-gray-600 mb-3">Please rate the service, with 1 (Poor) being the lowest and 5 (Excellent) as the highest.</p>
            <div class="space-y-2">
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_3" value="5" class="mr-3">
                    <span>5. Excellent</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_3" value="4" class="mr-3">
                    <span>4. Very Satisfactory</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_3" value="3" class="mr-3">
                    <span>3. Satisfactory</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_3" value="2" class="mr-3">
                    <span>2. Unsatisfactory</span>
                </label>
                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="answer_question_3" value="1" class="mr-3">
                    <span>1. Poor</span>
                </label>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-md font-medium mb-2">4. Why did you give this rating?</label>
            <textarea name="answer_question_4"  rows="4" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Provide a reason for your rating." autocomplete="off"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">How can we improve?</label>
            <textarea name="suggestion" rows="4" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Suggest what we can do to improve." autocomplete="off"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">Name (Optional)</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded px-4 py-2 text-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your name (optional)" autocomplete="off">
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Submit Feedback
            </button>
        </div>

        <div class="text-start text-[11px] text-gray-500 font-medium">
            <p class="italic">Thank you. Your feedback will be used to further improve our IT services</p>  
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('employee-search');
        const suggestionsContainer = document.getElementById('suggestions-container');
        const selectedEmployee = document.getElementById('selected-employee');
        const selectedName = document.getElementById('selected-name');
        const selectedNumber = document.getElementById('selected-number');
        const employeeNumber = document.getElementById('employee-number');
        const clearButton = document.getElementById('clear-selection');
        const employeeSearchContainer = document.getElementById('employee-search-container');
        
        // Handle Other Issues visibility
        const issuesSelect = document.getElementById('issues-select');
        const otherIssuesContainer = document.getElementById('other-issues-container');
        const otherIssuesInput = document.getElementById('other-issues-input');
        
        issuesSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const issueTitle = selectedOption.getAttribute('data-title');
            
            if (issueTitle && issueTitle.toLowerCase().includes('other')) {
                otherIssuesContainer.classList.remove('hidden');
                otherIssuesInput.setAttribute('required', 'required');
            } else {
                otherIssuesContainer.classList.add('hidden');
                otherIssuesInput.removeAttribute('required');
                otherIssuesInput.value = '';
            }
        });
        
        const employees = @json($employees);
        
        function fetchEmployees(query) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const results = employees.filter(employee => 
                        employee.name.toLowerCase().includes(query.toLowerCase()) ||
                        employee.employee_number.toLowerCase().includes(query.toLowerCase())
                    );
                    resolve(results);
                }, 200);
            });
        }
        
        searchInput.addEventListener('input', debounce(async function(e) {
            const query = e.target.value.trim();
            
            if (query.length < 0) {
                suggestionsContainer.classList.add('hidden');
                return;
            }
            
            const results = await fetchEmployees(query);
            displaySuggestions(results);
        }, 300));

        searchInput.addEventListener('focus', async function() {
            const results = await fetchEmployees('');
            displaySuggestions(results);
        });
        
        function displaySuggestions(employees) {
            if (employees.length === 0) {
                suggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No employees found</div>';
                suggestionsContainer.classList.remove('hidden');
                return;
            }
            
            suggestionsContainer.innerHTML = '';
            employees.forEach(employee => {
                const div = document.createElement('div');
                div.className = 'p-3 border-b border-gray-100 hover:bg-blue-50 cursor-pointer transition';
                div.innerHTML = `
                    <div class="font-medium text-gray-800 text-sm">${employee.name}</div>
                    <div class="text-gray-600 text-xs">${employee.employee_number}</div>
                `;
                div.addEventListener('click', () => {
                    selectEmployee(employee);
                });
                suggestionsContainer.appendChild(div);
            });
            
            suggestionsContainer.classList.remove('hidden');
        }
        
        function selectEmployee(employee) {
            selectedName.textContent = employee.name;
            selectedNumber.textContent = '(' + employee.employee_number + ')';
            employeeNumber.value = employee.employee_number;
            selectedEmployee.classList.remove('hidden');
            searchInput.value = '';
            suggestionsContainer.classList.add('hidden');
            employeeSearchContainer.classList.add('hidden');
        }
        
        clearButton.addEventListener('click', function() {
            selectedEmployee.classList.add('hidden');
            employeeSearchContainer.classList.remove('hidden');
            employeeNumber.value = '';
            searchInput.value = '';
            searchInput.focus();
        });
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
        
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    });
</script>

</body>
</html>
