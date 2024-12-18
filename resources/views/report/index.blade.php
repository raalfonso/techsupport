<x-layout>
    <div class="container mx-auto p-4">
       

        <div class="mx-auto max-w-screen-lg card" x-data="{ showModal: false }">
            <h1 class="title">Report</h1>
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
            <div class="overflow-x-auto mt-5">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="border border-gray-300 px-4 py-2">#</th>
                            <th class="border border-gray-300 px-4 py-2">Ticket Number</th>
                            <th class="border border-gray-300 px-4 py-2">Requestor Name</th>
                            <th class="border border-gray-300 px-4 py-2">Department</th>
                            <th class="border border-gray-300 px-4 py-2">Category</th>
                            <th class="border border-gray-300 px-4 py-2">Issue</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Request Date Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach($reports as $report)

                            <tr class="hover:bg-gray-100">
                                
                                <td class="border border-gray-300 px-4 py-2">{{ $count++ }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->ticket_number }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->requestor_name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->department_id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->category_id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->issues_id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->status }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $report->request_datetime }}</td>
                            
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('report.edit', $report->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('report.destroy', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
        
    </div>

 </x-layout>    
 
 