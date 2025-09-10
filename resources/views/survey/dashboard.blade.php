<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ 'ICT PORTAL' }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>

{{-- Added pt-16 to the body to account for the fixed navbar height --}}
<body> 


  <style>
  * {
    font-family:
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        Roboto,
        Helvetica,
        Arial,
        "Apple Color Emoji",
        "Segoe UI Emoji",
        "Segoe UI Symbol",
        sans-serif;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid var(--highcharts-neutral-color-10, #e6e6e6);
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: var(--highcharts-neutral-color-60, #666);
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tbody tr:nth-child(even) {
    background: var(--highcharts-neutral-color-3, #f7f7f7);
}

.highcharts-description {
    margin: 0.3rem 10px;
}

  </style>

    {{-- Include Tailwind CSS --}}
    {{-- Main Navbar --}}
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
       <div class="flex items-center justify-between container mx-auto w-full">
            {{-- Logo or Brand Name --}}
            <div class="text-lg font-bold text-gray-800 flex items-center">
                {{-- Logo image --}}
               <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
                BCDA ICT PORTAL {{-- Changed from MyBrand to match context --}}
            </div>

            {{-- Desktop Navigation --}}
                <div class="hidden md:flex space-x-4 float-right items-center">
                    {{-- Navigation links --}}
                    <a href="#home-section" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">dashboard</i>
                        Dashboard
                    </a>

                    <a href="#about" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">assignment</i>
                        Survey Result
                    </a>

                    <a href="{{ route('qrcode', ['departmentCode' => auth()->user()->department_id]) }}"
                    class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium" target="_blank">
                        <i class="material-icons align-middle">qr_code</i>
                        QR Code
                    </a>

                    <a href="#contact" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">people</i>
                        Employee Registration
                    </a>

                    @if (auth()->user()->role === 'superadmin')
                        <a href="{{ route('survey.management') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="material-icons align-middle">settings</i>
                            User Management
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <!-- Username button -->
                        <button @click="open = !open"
                            class="flex items-center text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            {{ auth()->user()->name }}
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                            <!-- Change Password -->
                            <a href="{{ route('survey.account') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                <i class="material-icons mr-2 text-gray-500">lock</i> Account
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('userSurvey.logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                    <i class="material-icons mr-2 text-gray-500">logout</i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            {{-- Mobile Menu Button (Hamburger) --}}
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation (Hidden by default) --}}
        <div id="mobile-menu" class="mt-20hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
            {{-- Container for mobile menu links --}}
            <br><br><br>
            <br><br><br><br><br>
            <div class="container mx-auto mt-10"> 
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Project</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Report</a>
                <a href="{{ route('survey.account') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Account</a>
              <!-- Logout -->
                <form method="POST" action="{{ route('userSurvey.logout') }}">
                    @csrf
                    <button type="submit"
                            class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                            Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section id="home-section" class="pb-5" style="background-color: #e6edfc">
        <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-20 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            {{-- this is for first graph --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-5">
            <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                <div>
                    <p class="text-md text-gray-600 font-semibold">Total Surveys Submitted</p>
                    <p class="text-3xl font-bold text-green-600">{{$total}}</p>
                </div>
                <div class="text-green-500">
                    <!-- Optional icon -->
                     <i class="material-icons align-middle text-[60px]">assignment</i>
                </div>
            </div>
             <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                <div>
                    <p class="text-md text-gray-600 font-semibold">Super Like</p>
                    <p class="text-3xl font-bold text-green-600">{{$percentageSuperLike}}%</p>
                </div>
                <div class="text-green-500">
                    <!-- Optional icon -->
                    <i class="material-icons align-middle text-[60px]">sentiment_very_satisfied</i>
                    
                </div>
            </div>
             <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                <div>
                    <p class="text-md text-gray-600 font-semibold">Like</p>
                    <p class="text-3xl font-bold text-green-600">{{$percentageLike}}%</p>
                </div>
                <div class="text-blue-500">
                    <!-- Optional icon -->
                    <i class="material-icons align-middle text-[60px]">sentiment_satisfied</i>
                </div>
            </div>
             <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                <div>
                    <p class="text-md text-gray-600 font-semibold">Dislike</p>
                    <p class="text-3xl font-bold text-green-600">{{$percentageDislike}}%</p>
                </div>
                <div class="text-red-500">
                  <i class="material-icons align-middle text-[60px]">sentiment_neutral</i>
                </div>
            </div>
          </div>

        </div>
    </section>

    <section id="top" class="pb-5" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-5 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            {{-- this is for first graph --}}
          
          <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg">
                 <figure class="highcharts-figure">
                  <div id="container"></div>
                </figure>
            </div>
             <!-- Survey Scorecard -->
            <div class="bg-white shadow rounded-lg">
                 <figure class="highcharts-figure">
                  <div id="container2"></div>
                </figure>
            </div>
            
          </div>

        </div>

    </section>

    <section id="about" class="py-16" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
        <h1 class="text-4xl font-bold mb-4">Surveys Result</h1>

        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-scroll mt-5">
            <thead>
              <tr class="bg-white-800 text-blue-800">
                <th class="py-3 px-6 text-left text-md font-medium">Date Submitted</th>
                <th class="py-3 px-6 text-left text-md font-medium">Employee's Name</th>
                <th class="py-3 px-6 text-left text-md font-medium">Degree of Competence & Accuracy of Service</th>
                <th class="py-3 px-6 text-left text-md font-medium">Degree of Responsiveness/Timeliness</th>
                <th class="py-3 px-6 text-left text-md font-medium">Comment</th>
                <th class="py-3 px-6 text-left text-md font-medium">Client Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $survey)
                  <tr class="border-b hover:bg-gray-50 text-gray-600 font-semibold">
                      <td class="py-4 px-6 text-sm">{{ $survey->created_at->format('F j, Y') }}</td>
                      <td class="py-4 px-6 text-sm">{{ $survey->surveyEmployee->name }}</td>
                      <td class="py-4 px-6 text-sm">
                          @if ($survey->accuracy_of_service == 2)
                              <span class="text-green-500 font-semibold">Super Like</span>
                          @elseif ($survey->accuracy_of_service == 1)
                              <span class="text-blue-500 font-semibold">Like</span>
                          @else
                              <span class="text-red-500 font-semibold">Dislike</span>
                          @endif
                      </td>
                      <td class="py-4 px-6 text-sm">
                          @if ($survey->response_time == 2)
                              <span class="text-green-500 font-semibold">Super Like</span>
                          @elseif ($survey->response_time == 1)
                              <span class="text-blue-500 font-semibold">Like</span>
                          @else
                              <span class="text-red-500 font-semibold">Dislike</span>
                          @endif
                      </td>
                      <td class="py-4 px-6 text-sm">{{ $survey->comments }}</td>
                      <td class="py-4 px-6 text-sm">{{ $survey->client_name }}</td>
                  </tr>
              @endforeach
          </tbody>
        </table>
        <div class="mt-4">
            {{ $surveys->links('pagination::tailwind') }}
        </div>
      </div>
    </section>

    {{-- this is for employee registration --}}

    <section id="contact" class="py-10" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
        <h2 class="text-3xl font-bold text-left mb-5">Register Employee</h2>
        <h3 class="text-xl font-normal text-left mb-12"></h3>
        <a href="#" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="inline-block bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">Add Employee</a>
         <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mt-5">
            <thead>
              <tr class="bg-blue-700 text-white">
                <th class="py-3 px-6 text-left text-sm font-medium">Name</th>
                <th class="py-3 px-6 text-left text-sm font-medium">Email</th>
                <th class="py-3 px-6 text-left text-sm font-medium">Department</th>
                <th class="py-3 px-6 text-left text-sm font-medium">Status</th>
                <th class="py-3 px-6 text-left text-sm font-medium">Action</th>
              </tr>
              
            </thead>
            <tbody>
              @foreach($employees as $employee)
                  <tr class="border-b hover:bg-gray-50">
                      <td class="py-4 px-6 text-sm">{{ $employee->name }}</td>
                      <td class="py-4 px-6 text-sm">{{ $employee->email }}</td>
                      <td class="py-4 px-6 text-sm">{{ $employee->department->title }}</td>
                      <td class="py-4 px-6 text-sm">
                          @if ($employee->status === 'active')
                              <span class="text-white bg-green-500 w-8 p-2 font-semibold rounded-full text-center leading-8">
                                  Active
                              </span>
                          @else
                              <span class="text-red-500 font-semibold">Inactive</span>
                          @endif
                      </td>
                      <td class="py-4 px-6 text-sm">
                          <a href="{{ route('survey.form', ['id' => $employee->id]) }}" class="text-blue-600 hover:underline">
                              Edit
                          </a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
          </table>

          {{-- Pagination Links --}}
          <div class="mt-4">
          {{ $employees->links('pagination::tailwind') }}
          </div>
        
      </div>
    </section>

    {{-- this is for modal  --}}
    <!-- Main modal -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full ">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                         <span class="text-blue-700 font-semibold">Registration Form</span>
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <form action="{{ route('survey.employee.store') }}" method="post" id="registration-form" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                      <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email address" required>
                      </div>
                      <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email address" required>
                      </div>
                      <input type="text" name="department_id" class="" value="{{ auth()->user()->department_id }}" hidden>

                      <button type="submit" id="modal-action-button" class="col-span-2 bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">
                        <span class="font-semibold">Submit</span>
                      </button>
                    </div>
                  </form>

              </div>
          </div>
      </div>
    <footer class="bg-blue-800 text-white py-8">
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
          <a href="#home-section" class="hover:underline">Home</a>
          <a href="#about" class="hover:underline">About</a>
          <a href="#services" class="hover:underline">Services</a>
          <a href="#projects" class="hover:underline">Projects</a>
          <a href="#contact" class="hover:underline">Report</a>
        </div>
      </div>
    </footer>

    <script>
        // JavaScript to toggle mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll('[data-scroll]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(entry.target); // only animate once
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });

      // this is for modal request
      document.addEventListener('DOMContentLoaded', function () {
        const modalTitle = document.getElementById('modal-project-title');
        const actionButton = document.getElementById('modal-action-button');
        const main = document.getElementById('modal-project-main');

        document.querySelectorAll('[data-modal-toggle="crud-modal"]').forEach(el => {
          el.addEventListener('click', function () {
            const title = this.getAttribute('data-project-title');
            const mainData = this.getAttribute('data-project-main');
            const projectButton = this.getAttribute('data-project-button') || 'Submit';
            if (modalTitle) {
              modalTitle.textContent = title;
              actionButton.textContent = projectButton;
              main.value = mainData;
            }
          });
        });
      });





Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Degree of Competence & Accuracy of Service'
    },
    xAxis: {
        categories: @json(collect($superData)->pluck('employee_name')),
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Responses'
        }
    },
    tooltip: {
        valueSuffix: ' responses'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Super Like',
            data: @json(collect($superData)->pluck('super_like')),
            color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
        },
        {
            name: 'Like',
            data: @json(collect($superData)->pluck('like')),
            color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
        },
        {
            name: 'Dislike',
            data: @json(collect($superData)->pluck('dislike')),
            color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
        }
    ]
});



Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Degree of Responsiveness and Timeliness'
    },
    xAxis: {
        categories: @json(collect($superDataR)->pluck('employee_name')),
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Responses'
        }
    },
    tooltip: {
        valueSuffix: ' responses'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
         {
            name: 'Super Like',
            data: @json(collect($superDataR)->pluck('super_like')),
            color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
        },
        {
            name: 'Like',
            data: @json(collect($superDataR)->pluck('like')),
            color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
        },
        {
            name: 'Dislike',
            data: @json(collect($superDataR)->pluck('dislike')),
            color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
        }
    ]
});
</script>


</body>
</html>