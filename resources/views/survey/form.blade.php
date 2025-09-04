<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Survey Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Assuming you're using Vite with Tailwind -->
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

    <form action="{{ route('survey.submit', $department->id) }}" method="POST" class="space-y-6">
        @csrf

        <div class="flex items-center space-x-2">
            <label for="survey_date" class="text-md font-medium">Date: {{ now()->format('F d, Y') }}</label>
           
          </div>

        <input type="text" name="department_id" value="{{ $department->id }}" hidden>

        <div class="flex items-center space-x-2">
            <label for="survey_employees_id" class="text-md font-medium">Person(s) you transacted with:</label>
            <select name="survey_employees_id"
                class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">--Select employee--</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>

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
                    '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal mr-2 text-green-600"></i>',
                    '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                    '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                ] as $value => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="radiobutton" value="{{ $value }}" class="peer hidden" required>
                        <div class="peer-checked:bg-blue-500 peer-checked:text-white text-center p-4 border rounded-lg hover:bg-blue-100 transition h-full flex items-center justify-center" onclick="document.getElementById('accuracyInput').value = '{{ $value }}'">
                            {!! $label !!}
                        </div>
                    </label>

                   
                @endforeach
                 
            </div>
            <input type="text" name="accuracy_of_service" id="accuracyInput" value="" hidden >  
        </div>

        {{-- Section 2 --}}
        <div class="mb-6 ml-5">
            <label class="block text-md font-semibold mb-2">
                Degree of Responsiveness/Timeliness (Agreed Response Time)
            </label>
             <div class="flex gap-3 justify-between">
                @foreach ([
                    '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal mr-2 text-green-600"></i>',
                    '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                    '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                ] as $value => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="radiotime" value="{{ $value }}" class="peer hidden" required>
                        <div class="peer-checked:bg-green-500 peer-checked:text-white text-center p-4 border rounded-lg hover:bg-green-100 transition h-full flex items-center justify-center" onclick="document.getElementById('responseInput').value = '{{ $value }}'">
                            {!! $label !!}
                        </div>
                    </label>
                @endforeach

            </div>
             <input type="text" name="response_time" id="responseInput" value="" hidden>  
        </div>
        {{-- Section 3 --}}
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">
                Brief Comment</label>
            <textarea name="comments" rows="4" class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your comments here..." autocomplete="off"></textarea>
        </div>

        {{-- Section 4 --}}
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">
               Name (optional)</label>
            <input type="text" name="client_name" class="w-full border border-gray-300 rounded px-2 py-1 text-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your name (optional)" autocomplete="off">
        </div>

        {{-- Section 5 --}}
        <div class="mb-6">
           <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Submit Feedback
            </button>
        

        </div>
        <div class="text-start text-[11px] text-gray-500 font-medium">
            <p class="italic">Thank you. Your feedback will be used to further improve our service</p>  
        </div>



    </form>










</div>


    

</div>
</body>
</html>