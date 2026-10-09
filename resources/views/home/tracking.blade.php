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
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl mt-8 p-8 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
          <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome, {{ $client->name }}</h1>
            <p class="text-gray-600">Track the status of your reported issues below.</p>
          </div>
          
          <div class="grid gap-6">
          @foreach ($reports as $report)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden" id="report{{ $report->id }}">
              <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                  <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $report->issues->title }}</h3>
                    <div class="flex items-center space-x-2">
                      <span class="text-sm font-semibold text-blue-600">{{ $report->ticket_number }}</span>
                      <span class="text-xs text-gray-400">•</span>
                      <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y h:i A') }}</span>
                    </div>
                  </div>
                  <div>
                    @if ($report->status == 'Ongoing')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                          {{ $report->status }}
                      </span>
                    @elseif ($report->status == 'Done')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          {{ $report->status }}
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                          {{ $report->status }}
                      </span> 
                    @endif
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                  <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Responded By</p>
                    @if (in_array($report->status, ['Ongoing', 'Done', 'For validation']))
                      <p class="text-sm font-medium text-gray-900">{{ $report->response->name ?? 'IT Staff' }}</p>
                      @if($report->response_datetime)
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->response_datetime)->format('M d, Y h:i A') }}</p>
                      @endif
                      @if($report->notes)
                      <br>
                        <div class="mt-5 p-3 bg-blue-50/80 border border-blue-100 rounded-xl">
                          <p class="text-xs font-semibold text-blue-800 flex items-center gap-1.5 mb-1">
                            <i class="fas fa-comment-dots text-blue-600"></i>
                            <span>Response Notes:</span>
                          </p>
                          <p class="text-xs text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->notes }}</p>
                        </div>
                      @endif
                    @else
                      <p class="text-sm text-gray-400"><i class="fas fa-clock"></i> Pending</p>
                    @endif
                  </div>

                  <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Resolved By</p>
                    @if ($report->status == 'Done')
                      <p class="text-sm font-medium text-gray-900">{{ $report->resolve->user->name ?? 'IT Staff' }}</p>
                      @if($report->resolve_datetime)
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('M d, Y h:i A') }}</p>
                      @endif
                      @if($report->completion_notes)
                      <br>
                        <div class="mt-5 p-3 bg-emerald-50/80 border border-emerald-100 rounded-xl">
                          <p class="text-xs font-semibold text-emerald-800 flex items-center gap-1.5 mb-1">
                            <i class="fas fa-sticky-note text-emerald-600"></i>
                            <span>Completion Notes:</span>
                          </p>
                          <p class="text-xs text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->completion_notes }}</p>
                        </div>
                      @endif
                    @else
                      <p class="text-sm text-gray-400"><i class="fas fa-clock"></i> Pending</p>
                    @endif
                  </div>
                </div>

                @if (($report->status == 'Done') && ($report->feedback != 'Yes'))
                  <div class="pt-4 border-t border-gray-200">
                    <a href="#" data-modal-target="feedback-modal"
                      data-modal-toggle="feedback-modal" 
                      data-report-id="{{ $report->id }}"
                      data-staff-name="{{ $report->resolve?->user?->name ?? $report->response?->name ?? 'IT Staff' }}"
                      data-transacted-person-id="{{ $report->resolve?->user?->surveyEmployee?->id ?? $report->response?->surveyEmployee?->id ?? '' }}"
                      data-generated-code="{{ $report->ticket_number }}"
                      class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                      <i class="fas fa-star mr-2"></i>Rate Our Service
                    </a>
                  </div>
                @elseif ($report->status == 'Done' && $report->feedback == 'Yes')
                  <div class="pt-4 border-t border-gray-200">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>Feedback Given
                    </span>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
          </div>
        </div>
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
    <div class="relative p-4 w-full max-w-3xl mx-auto my-8">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 animate-modal-slide-in overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center w-full pr-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/itd_logo.png') }}" alt="BCDA Logo" class="h-12 w-auto rounded">
                        <div>
                            <p class="italic text-[11px] text-gray-500 font-medium">BCDA-ODMD2014-12 | May 2014</p>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">BCDA Internal Services Feedback Form</h3>
                        </div>
                    </div>
                </div>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors duration-200" data-modal-toggle="feedback-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 md:p-8 overflow-y-auto max-h-[calc(100vh-180px)]">
                <form action="{{ route('feedback.store') }}" method="POST" id="feedback-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="report_id" id="modal-report-id" value="">

                    <!-- Date & Person Transacted With -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span>Date: {{ now()->format('F d, Y') }}</span>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-2">
                            <label for="modal-transacted-person-name" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Person(s) you transacted with:</label>
                            <input type="text" id="modal-transacted-person-name" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-800 text-sm focus:outline-none" readonly value="IT Staff">
                            <input type="hidden" name="transacted-person" id="modal-transacted-person-id" value="">
                            <input type="hidden" name="generated-code" id="modal-generated-code" value="">
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                        <label class="text-sm font-medium text-gray-800 dark:text-gray-200">How do you rate their service? (Please check)</label>
                    </div>

                    {{-- Section 1: Degree of Competence & Accuracy --}}
                    <div class="mb-6 ml-0 md:ml-4">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">
                            Degree of Competence & Accuracy of Service <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3 justify-between">
                            @foreach ([
                                '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal ml-2 text-green-600"></i>',
                                '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                                '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                            ] as $value => $label)
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="accuracy_of_service" value="{{ $value }}" class="peer hidden" required>
                                    <div class="peer-checked:bg-blue-600 peer-checked:text-white text-center p-3.5 border border-gray-300 rounded-lg hover:bg-blue-50 transition h-full flex items-center justify-center text-sm font-medium">
                                        {!! $label !!}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Section 2: Degree of Responsiveness/Timeliness --}}
                    <div class="mb-6 ml-0 md:ml-4">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">
                            Degree of Responsiveness/Timeliness (Agreed Response Time) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3 justify-between">
                            @foreach ([
                                '2' => '<i class="fa-solid fa-thumbs-up mr-2 text-green-600"></i>Super Like <i class="fa-solid fa-thumbs-up fa-flip-horizontal ml-2 text-green-600"></i>',
                                '1' => '<i class="fa-regular fa-thumbs-up mr-2 text-blue-600"></i>Like',
                                '0' => '<i class="fa-regular fa-thumbs-down mr-2 text-red-600"></i>Dislike'
                            ] as $value => $label)
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="response_time" value="{{ $value }}" class="peer hidden" required>
                                    <div class="peer-checked:bg-green-600 peer-checked:text-white text-center p-3.5 border border-gray-300 rounded-lg hover:bg-green-50 transition h-full flex items-center justify-center text-sm font-medium">
                                        {!! $label !!}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Section 3: Brief Comment --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            Brief Comment <span id="comments-required-star-modal" class="text-red-500 hidden">*</span>
                        </label>
                        <textarea name="comments" id="modal-comments" rows="4" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your comments here..."></textarea>
                    </div>

                    {{-- Section 4: Name (optional) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Name (optional)</label>
                        <input type="text" name="client_name" value="{{ $client->name ?? '' }}" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Your name (optional)">
                    </div>

                    {{-- Submit Button --}}
                    <div class="mb-4">
                        <button type="submit" id="modal-btn-submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition shadow">
                            Submit Feedback
                        </button>
                    </div>

                    <div class="text-start text-[11px] text-gray-500 font-medium">
                        <p class="italic">Thank you. Your feedback will be used to further improve our service</p>
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
        const modalReportId = document.getElementById('modal-report-id');
        const modalTransactedPersonName = document.getElementById('modal-transacted-person-name');
        const modalTransactedPersonId = document.getElementById('modal-transacted-person-id');
        const modalGeneratedCode = document.getElementById('modal-generated-code');

        document.querySelectorAll('[data-modal-toggle="feedback-modal"]').forEach(el => {
          el.addEventListener('click', function () {
            const reportId = this.getAttribute('data-report-id');
            const staffName = this.getAttribute('data-staff-name');
            const transactedPersonId = this.getAttribute('data-transacted-person-id');
            const generatedCode = this.getAttribute('data-generated-code');

            if (modalReportId) {
              modalReportId.value = reportId || '';
            }
            if (modalTransactedPersonName) {
              modalTransactedPersonName.value = staffName || 'IT Staff';
            }
            if (modalTransactedPersonId) {
              modalTransactedPersonId.value = transactedPersonId || '';
            }
            if (modalGeneratedCode) {
              modalGeneratedCode.value = generatedCode || '';
            }
          });
        });

        // Dynamic requirement for comments based on Dislike rating ('0')
        const modalAccuracyRadios = document.querySelectorAll('input[name="accuracy_of_service"]');
        const modalResponseRadios = document.querySelectorAll('input[name="response_time"]');
        const modalCommentsTextarea = document.getElementById('modal-comments');
        const modalCommentsRequiredStar = document.getElementById('comments-required-star-modal');

        function updateModalCommentRequirement() {
            let hasDislike = false;
            modalAccuracyRadios.forEach(radio => {
                if (radio.checked && radio.value === '0') {
                    hasDislike = true;
                }
            });
            modalResponseRadios.forEach(radio => {
                if (radio.checked && radio.value === '0') {
                    hasDislike = true;
                }
            });

            if (hasDislike) {
                if (modalCommentsTextarea) modalCommentsTextarea.setAttribute('required', 'required');
                if (modalCommentsRequiredStar) modalCommentsRequiredStar.classList.remove('hidden');
            } else {
                if (modalCommentsTextarea) modalCommentsTextarea.removeAttribute('required');
                if (modalCommentsRequiredStar) modalCommentsRequiredStar.classList.add('hidden');
            }
        }

        modalAccuracyRadios.forEach(radio => {
            radio.addEventListener('change', updateModalCommentRequirement);
        });
        modalResponseRadios.forEach(radio => {
            radio.addEventListener('change', updateModalCommentRequirement);
        });

        // Handle modal form submission with SweetAlert validation
        const feedbackForm = document.getElementById('feedback-form');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', function(e) {
                let errors = [];

                let accuracySelected = false;
                let accuracyVal = '';
                modalAccuracyRadios.forEach(radio => {
                    if (radio.checked) {
                        accuracySelected = true;
                        accuracyVal = radio.value;
                    }
                });
                if (!accuracySelected) {
                    errors.push("Degree of Competence & Accuracy of Service rating is required.");
                }

                let timeSelected = false;
                let timeVal = '';
                modalResponseRadios.forEach(radio => {
                    if (radio.checked) {
                        timeSelected = true;
                        timeVal = radio.value;
                    }
                });
                if (!timeSelected) {
                    errors.push("Degree of Responsiveness/Timeliness rating is required.");
                }

                let hasDislike = (accuracyVal === '0' || timeVal === '0');
                if (hasDislike && modalCommentsTextarea && !modalCommentsTextarea.value.trim()) {
                    errors.push("Please provide a comment to help us improve our services.");
                }

                if (errors.length > 0) {
                    e.preventDefault();
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
                        confirmButtonColor: '#2563eb'
                    });
                }
            });
        }
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