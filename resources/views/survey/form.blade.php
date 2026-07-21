<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Survey Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Assuming you're using Vite with Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="max-w-3xl mx-auto mt-5 bg-white p-8 rounded-lg shadow-md">
   <div class="flex justify-between items-start">
        <div class="w-1/2">
            <p class="italic text-[11px] font-medium">BCDA-ODMD2014-12</p>
            <p class="italic text-[11px] font-medium">May 2014</p>
        </div>
        <div class="w-1/2 flex justify-end">
            <img src="{{ asset('img/company_logo.png') }}" alt="BCDA Logo" class="w-24 h-18">
        </div>
    </div>

    <div class="title text-center mb-8 mt-10">
        <h1 class="text-sm font-bold text-gray-800 sm:text-lg md:text-3xl">
        BCDA Internal Services Feedback Form
        </h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <form action="{{ route('survey.submit', $department->id) }}" method="POST" class="space-y-6" novalidate>
        @csrf

        <div class="flex items-center space-x-2">
            <label for="survey_date" class="text-md font-medium">Date: {{ now()->format('F d, Y') }}</label>
           
          </div>

        <input type="text" name="department_id" value="{{ $department->id }}" hidden>
       
         <div class="flex items-center space-x-2">
            <label for="employee-search" class="text-md font-medium">Person(s) you transacted with:</label>
            <div class="relative" id="employee-search-container">
                <input 
                    type="text" 
                    id="employee-search"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                    placeholder=""
                    autocomplete="off"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    {{-- <i class="fas fa-caret-down text-gray-400 ml-5"></i> --}}
                </div>
                <div id="suggestions-container" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-60 overflow-y-auto uppercase"></div>

                
            </div>
            <div id="selected-employee" class="relative hidden p-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <span id="selected-name" class=""></span>
                        </div>
                        <button type="button" id="clear-selection" class="text-blue-500 hover:text-blue-700 text-sm">
                            <i class="fas fa-times-circle ml-5"></i> Change
                        </button>
                    </div>
                    
                </div>
            <input type="hidden" name="survey_employees_id" id="employee-id">
            
            
        </div>
        <div class="flex items-center space-x-2">
            <label class="text-md font-medium">How do you rate their service?(Please check)</label>
            

        </div>
            {{-- Section 1 --}}
        <div class="mb-6 ml-5">
            <label class="block text-md font-semibold mb-2">
                Degree of Competence & Accuracy of Service
            </label>
            <div class="flex gap-3 justify-between">
                @foreach ([
                    '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal ml-2 mr-2 text-green-600"></i>',
                    '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                    '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                ] as $value => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="radiobutton" value="{{ $value }}" class="peer hidden" required>
                        <div class="peer-checked:bg-blue-500 peer-checked:text-white text-center p-4 border rounded-lg hover:bg-blue-100 transition h-full flex items-center justify-center" onclick="document.getElementById('accuracyInput').value = '{{ $value }}'; if(window.updateCommentRequirement) window.updateCommentRequirement();">
                            {!! $label !!}
                        </div>
                    </label>

                   
                @endforeach
                 
            </div>
            <input type="text" name="accuracy_of_service" id="accuracyInput" value="{{ old('accuracy_of_service') }}" hidden >  
        </div>

        {{-- Section 2 --}}
        <div class="mb-6 ml-5">
            <label class="block text-md font-semibold mb-2">
                Degree of Responsiveness/Timeliness (Agreed Response Time)
            </label>
             <div class="flex gap-3 justify-between">
                @foreach ([
                    '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal ml-2 mr-2 text-green-600"></i>',
                    '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                    '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                ] as $value => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="radiotime" value="{{ $value }}" class="peer hidden" required>
                        <div class="peer-checked:bg-green-500 peer-checked:text-white text-center p-4 border rounded-lg hover:bg-green-100 transition h-full flex items-center justify-center" onclick="document.getElementById('responseInput').value = '{{ $value }}'; if(window.updateCommentRequirement) window.updateCommentRequirement();">
                            {!! $label !!}
                        </div>
                    </label>
                @endforeach

            </div>
             <input type="text" name="response_time" id="responseInput" value="{{ old('response_time') }}" hidden>  
        </div>
        {{-- Section 3 --}}
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">
                Brief Comment <span id="comments-required-star" class="text-red-500 hidden">*</span></label>
            <textarea name="comments" id="comments" rows="4" class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your comments here..." autocomplete="off">{{ old('comments') }}</textarea>
        </div>

        {{-- Section 4 --}}
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">
               Name (optional)</label>
            <input type="text" name="client_name" value="{{ old('client_name') }}" class="w-full border border-gray-300 rounded px-2 py-1 text-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your name (optional)" autocomplete="off">
        </div>

        {{-- Section 5 --}}
        <div class="mb-6">
           <button type="submit" id="btn-submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Submit Feedback
            </button>
        

        </div>
        <div class="text-start text-[11px] text-gray-500 font-medium">
            <p class="italic">Thank you. Your feedback will be used to further improve our service</p>  
        </div>



    </form>










</div>


    

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('employee-search');
        const suggestionsContainer = document.getElementById('suggestions-container');
        const selectedEmployee = document.getElementById('selected-employee');
        const selectedName = document.getElementById('selected-name');
        const employeeId = document.getElementById('employee-id');
        const clearButton = document.getElementById('clear-selection');
        const employeeSearchContainer = document.getElementById('employee-search-container');
        
        // Mock data - replace with actual data from your server
        const employees = @json($employees);
        
        
        // Function to fetch employees (simulating AJAX call)
        function fetchEmployees(query) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const results = employees.filter(employee => 
                        employee.name.toLowerCase().includes(query.toLowerCase())
                    );
                    resolve(results);
                }, 200);
            });
        }
        
        // Event listener for input
        searchInput.addEventListener('input', debounce(async function(e) {
            const query = e.target.value.trim();
            
            if (query.length < 0) {
                suggestionsContainer.classList.add('hidden');
                return;
            }
            
            const results = await fetchEmployees(query);
            displaySuggestions(results);
        }, 300));
        // ✅ New: Show all employees when clicking the input
            searchInput.addEventListener('focus', async function() {
                const results = await fetchEmployees(''); // Empty query = show all
                displaySuggestions(results);
            });
        // Display suggestions
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
                    
                `;
                div.addEventListener('click', () => {
                    selectEmployee(employee);
                });
                suggestionsContainer.appendChild(div);
            });
            
            suggestionsContainer.classList.remove('hidden');
        }
        
        // Select an employee
        function selectEmployee(employee) {
            selectedName.textContent = employee.name;
            employeeId.value = employee.id;
            selectedEmployee.classList.remove('hidden');
            searchInput.value = '';
            suggestionsContainer.classList.add('hidden');
            employeeSearchContainer.classList.add('hidden');
        }
        
        // Clear selection
        clearButton.addEventListener('click', function() {

            selectedEmployee.classList.add('hidden');
            employeeSearchContainer.classList.remove('hidden');
            employeeId.value = '';
            searchInput.value = '';
            searchInput.focus();
        });
        
        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
        
        // Debounce function to limit API calls
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

        // Dynamic requirement for comments based on Dislike rating ('0')
        const radioButtons = document.querySelectorAll('input[name="radiobutton"]');
        const radioTimes = document.querySelectorAll('input[name="radiotime"]');
        const commentsTextarea = document.getElementById('comments');
        const commentsRequiredStar = document.getElementById('comments-required-star');

        function updateCommentRequirement() {
            let hasDislike = false;
            
            // Check radiobutton
            radioButtons.forEach(radio => {
                if (radio.checked && radio.value === '0') {
                    hasDislike = true;
                }
            });

            // Check radiotime
            radioTimes.forEach(radio => {
                if (radio.checked && radio.value === '0') {
                    hasDislike = true;
                }
            });

            if (hasDislike) {
                commentsTextarea.setAttribute('required', 'required');
                commentsRequiredStar.classList.remove('hidden');
            } else {
                commentsTextarea.removeAttribute('required');
                commentsRequiredStar.classList.add('hidden');
            }
        }

        // Expose it globally so that inline onclick attributes can trigger it
        window.updateCommentRequirement = updateCommentRequirement;

        // Attach listeners to both radio button groups
        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateCommentRequirement);
        });
        radioTimes.forEach(radio => {
            radio.addEventListener('change', updateCommentRequirement);
        });

        // Run initially to handle any pre-selected old values (e.g. from validation redirects)
        updateCommentRequirement();

        // Handle form submission with SweetAlert validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            let errors = [];

            // 1. Check person transacted with (survey_employees_id / employee-id)
            const employeeIdVal = document.getElementById('employee-id').value;
            if (!employeeIdVal) {
                errors.push("The Person(s) you transacted with cannot be empty.");
            }

            // 2. Check Degree of Competence & Accuracy rating (radiobutton)
            let accuracySelected = false;
            let accuracyVal = '';
            radioButtons.forEach(radio => {
                if (radio.checked) {
                    accuracySelected = true;
                    accuracyVal = radio.value;
                }
            });
            if (!accuracySelected) {
                errors.push("Degree of Competence & Accuracy of Service rating is required.");
            }

            // 3. Check Degree of Responsiveness/Timeliness rating (radiotime)
            let timeSelected = false;
            let timeVal = '';
            radioTimes.forEach(radio => {
                if (radio.checked) {
                    timeSelected = true;
                    timeVal = radio.value;
                }
            });
            if (!timeSelected) {
                errors.push("Degree of Responsiveness/Timeliness rating is required.");
            }

            // 4. Check comments if Dislike is selected
            let hasDislike = (accuracyVal === '0' || timeVal === '0');
            if (hasDislike && !commentsTextarea.value.trim()) {
                errors.push("Please provide a comment to help us improve our services.");
            }

            if (errors.length > 0) {
                e.preventDefault(); // Prevent default submission

                // Build specific list of error messages for SweetAlert
                let errorHtml = '<ul class="text-left list-disc list-inside space-y-1 text-sm font-medium text-red-600">';
                errors.forEach(err => {
                    errorHtml += `<li>${err}</li>`;
                });
                errorHtml += '</ul>';

                Swal.fire({
                    title: 'Form Submission Failed',
                    html: errorHtml,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2563eb' // Matches blue-600
                });
            }
        });
    });
</script>
</body>
</html>