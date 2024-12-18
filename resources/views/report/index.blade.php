<x-layout>
    <div class="container mx-auto w-full  p-4">
        <div class="max-w-fit card w-fit" 
        {{-- x-data="{ showModal: false,resolveModal:false, responseModal:false,  selectedId: null, }"> --}}
        x-data="{ showModal: false, resolveModal: false, responseModal: false, selectedId: null }">

            <h1 class="title">Reports</h1>
            <button @click="showModal = true" class="btn w-32">
                New Report
            </button>
                <!-- Modal -->
                <div x-show="showModal"  class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center"x-cloak>
                    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-bold">Add New Record</h2>
                            <button @click="showModal = false" class="text-gray-600 hover:text-gray-800">&times;</button>
                        </div>
                            <form action="{{ route('report.store') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="requestor_name">Requestor Name</label>
                                    <input type="text" name="requestor_name" class="input @error('title') ring-red-500 @enderror" value="{{ old('title')}}">
                                    @error('requestor_name')
                                        <p class="error">{{ $message }}</p>
                                        <script>
                                            Swal.fire({
                                                icon: "error",
                                                title: "Oops...",
                                                text: "{{ $message }}",
                                                });
                                        </script>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="input">
                                        <option value="">Select department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                    <p class="error">{{ $message }}</p>
                                    <script>
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "{{ $message }}",
                                            });
                                    </script>
                                @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="issues_id">Issue</label>
                                    <select name="issues_id" id="issues_id" class="input">
                                        <option value="">Select issue</option>
                                        @foreach($issues as $issue)
                                            <option value="{{ $issue->id }}">{{ $issue->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('issues_id')
                                    <p class="error">{{ $message }}</p>
                                    <script>
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "{{ $message }}",
                                            });
                                    </script>
                                @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="remarks">Remarks</label>
                                    <textarea rows="4" class="w-full h-32 p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
                                </div>
                   

                            {{-- submit button --}}
                                <button class="btn">Create</button>
                            </form>
                                     
                    </div>
                </div>
                <div class="block w- mt-4" style="zoom: 68%">
                <table class="items-center text-center bg-transparent w-full border-collapse ">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="border border-gray-300 px-4 py-2">#</th>
                            <th class="border border-gray-300 px-4 py-2">Ticket Number</th>
                            <th class="border border-gray-300 px-4 py-2">Requestor Name</th>
                            <th class="border border-gray-300 px-4 py-2">Department</th>
                            <th class="border border-gray-300 px-4 py-2">Category</th>
                            <th class="border border-gray-300 px-4 py-2">Issue</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Waiting time</th>
                            <th class="border border-gray-300 px-4 py-2">Processing time</th>
                            <th class="border border-gray-300 px-4 py-2">Request Date Time</th>
                            <th class="border border-gray-300 px-4 py-2">Remarks</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $count = 1;
                            $now = now();

                            
                            ?>
                        @foreach($reports as $report)

                            <tr class="hover:bg-gray-100">
                                
                                <td class="border border-gray-300 px-4 py-2">{{ $count++ }}</td>
                                <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $report->ticket_number }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->requestor_name }}</td>
                                <td class="border border-gray-300 px-4 py-2 ">{{ $report->department->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->category->title }}</td>
                                <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $report->issues->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->status }}</td>
                                @if ($report->status == 'Pending')
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::now());
                                        @endphp
    
                                        @if ($diffInMinutes >= 60)
                                            {{ round($diffInMinutes / 60) }} hrs
                                        @else
                                            {{ round($diffInMinutes) }} mins
                                        @endif
    
                                    </td>
                                
                                @elseif ($report->status == 'Ongoing')
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                                        @endphp
    
                                        @if ($diffInMinutes >= 60)
                                            {{ round($diffInMinutes / 60) }} hrs
                                        @else
                                            {{ round($diffInMinutes) }} mins
                                        @endif
    
                                    </td>
                                
                                    
                                @endif
                                    <td class="border border-gray-300 px-4 py-2">
                                        @php
                                            $diffInMinutes = \Carbon\Carbon::parse($report->response_datetime)->diffInMinutes(\Carbon\Carbon::now());
                                        @endphp
    
                                        @if ($diffInMinutes >= 60)
                                            {{ round($diffInMinutes / 60) }} hrs
                                        @else
                                            {{ round($diffInMinutes) }} mins
                                        @endif
    
                                    </td>
                                
                                    
        
                                
                                <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ date('F d, Y h:i a', strtotime($report->request_datetime)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->remarks }}</td>
                                @if ($report->status == 'Pending')
                                    <td class="border border-gray-300 px-4 py-2">
                                        <button 
                                        @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Response
                                        </button>
                                    </td>
                                @else
                                    <td class="border border-gray-300 px-4 py-2">
                                        <button 
                                        @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                                        class="btn mb-2">
                                        Resolved
                                        </button>
                                        
                                        <button 
                                        @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                        Escalate
                                        </button>
                                    </td>
                                    
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $reports->links() }}
                </div>
            </div>
        
        <!-- Modal -->
            <div x-show="responseModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded-lg w-1/3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Response</h3>
                        <button @click="responseModal = false" class="text-gray-500 hover:text-gray-800">X</button>
                    </div>
                    <form :action="'/report/edit/' + selectedId" method="GET">
                        <!-- Your form content here -->
                        @csrf
                        <div class="mb-4 mt-4">
                            <label for="user_id">Technical Staff</label>
                            <select name="user_id" id="user_id" class="input">
                                <option value="">Select Technical staff</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('issues_id')
                            <p class="error">{{ $message }}</p>
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "{{ $message }}",
                                    });
                            </script>
                        @enderror
                        </div>



                        <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                            Response
                        </button>
                    </form>
                </div>
            </div>
    

        <!-- Modal -->
        <div x-show="resolveModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Resolve</h3>
                    <button @click="resolveModal = false" class="text-gray-500 hover:text-gray-800">X</button>
                </div>
                <form :action="'/report/resolve/' + selectedId" method="GET">
                    <!-- Your form content here -->
                    @csrf
                    <div class="mb-4 mt-4">
                        <label for="user_id">Technical Staff</label>
                        <select name="user_id" id="user_id" class="input">
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('issues_id')
                        <p class="error">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "{{ $message }}",
                                });
                        </script>
                    @enderror
                    </div>



                    <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                        Resolved
                    </button>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>

 </x-layout>    
 
 