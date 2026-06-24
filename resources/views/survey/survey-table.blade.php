{{-- this is for the pagination of the survey results in the dashboard-admin.blade.php file. It listens for a click event on the pagination links and prevents the default behavior. It then extracts the page number from the clicked link's href attribute and calls the filterResults function with that page number as an argument. This allows for dynamic loading of survey results without a full page refresh.     --}}
<div id="survey-table" class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto survey-table">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr class="bg-gray-50">
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date Submitted</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Employee's Name</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Competence & Accuracy</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Responsiveness</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Comment</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Client Name</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 survey-table-body">
                  @foreach($surveys as $survey)
                      <tr class="hover:bg-gray-50 transition duration-150">
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->created_at->format('F j, Y') }}</td>
                          <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ $survey->surveyEmployee->name }}</td>
                          <td class="py-4 px-6">
                              @if ($survey->accuracy_of_service == 2)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span>
                              @elseif ($survey->accuracy_of_service == 1)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                    </svg>
                                    Like
                                  </span>
                              @else
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    Dislike
                                  </span>
                              @endif
                          </td>
                          <td class="py-4 px-6">
                              @if ($survey->response_time == 2)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span>
                              @elseif ($survey->response_time == 1)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                    </svg>
                                    Like
                                  </span>
                              @else
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    Dislike
                                  </span>
                              @endif
                          </td>
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->comments }}</td>
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->client_name }}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-6 pagination-links">
            {{ $surveys->links('pagination::tailwind') }}
        </div>


        <script>

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let page = $(this).attr('href').split('page=')[1];

                filterResults(page);
            });

            function filterResults(page) {
                const startDate = <?php echo json_encode(request('start_date')); ?>;
                const endDate = <?php echo json_encode(request('end_date')); ?>;
                const department = <?php echo json_encode(request('department')); ?>;

                $.ajax({
                    url: "{{ route('survey.searchResults') }}",
                    type: "GET",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        department: department,
                        page: page
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        
                        $('.survey-table').html(response);

                        Swal.close();
                    }
                });
            }




        </script>