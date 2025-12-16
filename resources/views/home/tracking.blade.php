<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
</head>

{{-- Added pt-16 to the body to account for the fixed navbar height --}}
<body style="background-color: #e6edfc" class="flex flex-col min-h-screen pt-16"> 
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
                BCDA IT DIVISION {{-- Changed from MyBrand to match context --}}
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-4 float-right">
                {{-- Navigation links --}}
                <p class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">{{$client->name}}</p>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Logout</a> {{-- Assuming 'Report' links to 'Contact' or another relevant section --}}
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
        <div id="mobile-menu" class="hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
            {{-- Container for mobile menu links --}}
            <div class="container mx-auto"> 
                <a href="#home-section" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="#about" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="#projects" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Project</a>
                <a href="#contact" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Report</a>
            </div>
        </div>
    </nav>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    {{-- Hero Section --}}
    <main class="flex-grow">
    {{-- Your page content here --}}
      <section id="home-section" class="p-5" >
        <div class="mx-auto bg-white rounded-lg shadow mt-5 p-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
          <h1 class="text-2xl font-bold mb-4">Welcome, {{ $client->name }}</h1>
          <p class="text-gray-600 mb-2">Here are your reported issues:</p>
          <div class="flex items-start justify-between px-6 py-4 border-b hover:bg-gray-50">
          
            {{-- Column Header --}}
              <div class="flex w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Issue Encounter {{-- column header --}}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Ticket Number {{-- column header --}}
                  </span>
                
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Responsed {{-- column header --}}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Resolved {{-- column header --}}
                  </span>
              </div>

              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Status {{-- column header --}}
                  </span>
              </div>

              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Action {{-- column header --}}
                  </span>
              </div>

          </div>

          {{-- Display a message if no reports are found --}}
          @foreach ($reports as $report)
          <div class="flex items-start justify-between px-6 py-4 border-b hover:bg-gray-50" id="report{{ $report->id }}">
              <div class="flex flex-col w-2/6">
                  <span class="text-sm font-semibold px-4 py-2 text-gray-700 flex items-start">
                      {{ $report->issues->title }}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6 px-4">
                  <span class="text-sm text-gray-700 font-medium">{{ $report->ticket_number }}</span>
                  <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y') }}</span>
                  <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->request_datetime)->format('h:i A') }}</span>
              </div>

              {{-- response Info --}}
             @if (in_array($report->status, ['Ongoing', 'Done']))
                <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium">{{ $report->response->name }}</span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->response_datetime)->format('M d, Y') }}</span>
                    <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->response_datetime)->format('h:i A') }}</span>
                </div>
                
              @else
                <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium ml-8"><i class="fa-solid fa-clock"></i></span>
                  
                </div>
              @endif
              

              {{-- resolve Info --}}
              @if ($report->status == 'Done')
                <div class="flex flex-col w-2/6">
                    <span class="text-gray-700 font-medium">{{ $report->resolve->user->name }}</span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('M d, Y') }}</span>
                    <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('h:i A') }}</span>
                </div>
              @else
               <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium ml-8"><i class="fa-solid fa-clock"></i></span>
                </div>
              @endif
             

              {{-- Right: Status --}}
              <div class="flex flex-col w-2/6">
                  <span class="text-sm font-semibold px-4 py-2 flex items-center">
                    @if ($report->status == 'Ongoing')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                          {{ $report->status }} {{-- Display the status --}}
                      </span>
                    @elseif ($report->status == 'Done')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          {{ $report->status }} {{-- Display the status --}}    
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                          {{ $report->status }} {{-- Display the status --}}
                      </span> 
                    @endif
                     
                  </span>
                  
                </div>

                {{-- Right: Status --}}
                <div class="flex flex-col w-2/6">
                  <span class="text-sm font-semibold px-4 py-2 flex items-center">
                    @if (($report->status == 'Done') && ($report->feedback != 'Yes'))
                      <a href="#" data-modal-target="feedback-modal"
                        data-modal-toggle="feedback-modal" 
                        data-report-id="{{ $report->id }}"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Rate Us!</a>
                    @elseif ($report->status == 'Done' && $report->feedback == 'Yes')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-md font-medium bg-green-100 text-green-800 text-gray-800">
                          Feedback Given {{-- Display the status --}}   
                      </span>

                    @else
                      
                    @endif
                     
                  </span>
                  
                </div>
            </div>
          @endforeach

      </section>

  
    </main>

    <footer class="bg-blue-800 text-white py-8 floating-bottom">
    
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Department - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
          {{-- <a href="#about" class="hover:underline">About</a>
          <a href="#services" class="hover:underline">Services</a>
          <a href="#projects" class="hover:underline">Projects</a>
          <a href="#contact" class="hover:underline">Contact</a> --}}
        </div>
      </div>
    </footer>

    <!-- feedback modal -->
<div id="feedback-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-screen bg-black bg-opacity-50 flex">
    <div class="relative p-4 w-full max-w-2xl mx-auto my-8">
        <!-- Modal content -->
        <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 animate-modal-slide-in">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <span class="text-blue-600">ICTD Customer Feedback</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors duration-200" data-modal-toggle="feedback-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 overflow-y-auto max-h-[calc(100vh-200px)]">
                <div class="mb-6">
                    <p class="text-gray-600 text-sm leading-relaxed">
                        We would love to hear your thoughts or feedback on how we can improve your experience!
                    </p>
                </div>

                <form action="{{ route('feedback.store') }}" method="post" class="space-y-6">
                    @csrf
                    
                    <input type="hidden" name="report_id" id="report-id">

                    <!-- Question 1 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="font-semibold text-gray-900 mb-2">1. How quickly did the support attend to you? <span class="text-red-500 text-xs">*</span></p>
                        <p class="text-sm text-gray-600 mb-4">Please rate, with 1 (Slow) being the lowest and 5 (Fast) as the highest.</p>
                        
                        <div class="space-y-3 ml-4">
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="5" name="answer1" class="rb-q1 w-4 h-4 text-blue-600" required>
                                <span class="ml-3 text-gray-800">5. Within a few minutes</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="4" name="answer1" class="rb-q1 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">4. Within a few hours</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="3" name="answer1" class="rb-q1 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">3. Within the day</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="2" name="answer1" class="rb-q1 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">2. The next day</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="1" name="answer1" class="rb-q1 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">1. After a few days</span>
                            </label>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="font-semibold text-gray-900 mb-2">2. How would you rate the support service provided? <span class="text-red-500 text-xs">*</span></p>
                        <p class="text-sm text-gray-600 mb-4">Please rate the service, with 1 (Poor) being the lowest and 5 (Excellent) as the highest.</p>
                        
                        <div class="space-y-3 ml-4">
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="5" name="answer3" class="rb-q3 w-4 h-4 text-blue-600" required>
                                <span class="ml-3 text-gray-800">5. Excellent</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="4" name="answer3" class="rb-q3 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">4. Very Satisfactory</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="3" name="answer3" class="rb-q3 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">3. Satisfactory</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="2" name="answer3" class="rb-q3 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">2. Unsatisfactory</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                <input type="radio" value="1" name="answer3" class="rb-q3 w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-800">1. Poor</span>
                            </label>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="font-semibold text-gray-900 mb-2">3. Why did you rate as you did? <span class="text-green-500 text-xs">(Optional)</span></p>
                        <p class="text-sm text-gray-600 mb-4">Provide a reason for your rating.</p>
                        <textarea name="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Question 4 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="font-semibold text-gray-900 mb-2">4. How can we improve? <span class="text-green-500 text-xs">(Optional)</span></p>
                        <p class="text-sm text-gray-600 mb-4">Suggest what we can do to improve.</p>
                        <textarea name="suggestion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
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
                    entry.target.classList.remove('opacity-0', 'translate-y-5');
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
        const modalTitle = document.getElementById('report-id');

        document.querySelectorAll('[data-modal-toggle="feedback-modal"]').forEach(el => {
          el.addEventListener('click', function () {
            const report_id = this.getAttribute('data-report-id');
            if (modalTitle) {
              modalTitle.value = report_id;
            }
          });
        });
     });


    //  this is for the click function to add rows
    // Add click event listener to each report div
     document.querySelectorAll('[id^="report"]').forEach(reportDiv => {
    reportDiv.addEventListener('click', function() {
        const reportId = this.id.replace('report', '');

        // Remove existing details if already open
        const existingDetails = document.getElementById(`details${reportId}`);
        if (existingDetails) {
            existingDetails.remove();
            return;
        }

        // Create placeholder row
        const detailsRow = document.createElement('div');
        detailsRow.id = `details${reportId}`;
        detailsRow.className = 'flex items-start justify-between px-6 py-4 border-b bg-gray-50';
        this.after(detailsRow);

        // Build URL using Laravel route helper with placeholder
        const url = "{{ route('report.loghistory', ':id') }}".replace(':id', reportId);

        // Fetch JSON history
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Build timeline list items dynamically
                let timelineItems = '';
                data.forEach(item => {
                    console.log(item);
                    timelineItems += `
                        <div class="flex items-start space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">
                            <div class="mt-1 w-3 h-3 bg-blue-500 rounded-full shadow-md"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">${item.perform_at || ''}</span>
                                    <span class="mx-2 text-gray-400">|</span>
                                    <span class="font-semibold ${item.action === 'responded' ? 'bg-orange-100 text-orange-600 px-2 py-1 rounded' : item.action === 'resolved' ? 'bg-green-100 text-green-600 px-2 py-1 rounded' : 'bg-blue-100 text-blue-600 px-2 py-1 rounded'}">${item.action}</span>                                                              <span class="text-gray-500">by</span>
                                    <span class="font-bold text-gray-800">${item.perform_by}</span>
                                    <hr class="my-2">
                                </p>
                            </div>
                        </div>                    `;
                });

                // Render details card
                detailsRow.innerHTML = `
                    <div class="w-full bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-3">
                            <h3 class="font-bold text-lg text-gray-800">Log History</h3>
                            <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="bg-white p-4 rounded-lg">
                                <ul class="text-sm">
                                    ${timelineItems}
                                </ul>
                            </div>
                        </div>
                    </div>
                `;

                // Close button handler
                detailsRow.querySelector('button').addEventListener('click', (e) => {
                    e.stopPropagation();
                    detailsRow.remove();
                });
            })
            .catch(error => {
                console.error('Error fetching report details:', error);
                detailsRow.innerHTML = `
                    <div class="w-full bg-white rounded-lg shadow-sm p-6">
                        <p class="text-red-500">Error loading report details</p>
                    </div>
                `;
            });
    });
});

         


     
    </script>
</body>
</html>