<x-layout>
    <div class="container mx-auto w-full p-4">
        <!-- Card Container -->
        <div 
            class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-4" 
            x-data="{ showModal: false, resolveModal: false, escalateModal: false, responseModal: false, selectedId: null }">
            
            <h1 class="text-lg md:text-xl font-bold mb-4 text-gray-800">List of Requested / Reported Issues</h1>
            <input type="text" class="firstCount input" style="display: none;" value="{{$countReport}}">
            <!-- New Report Button -->
            <div class="flex justify-end mb-4">
                <button @click="showModal = true" class="btn w-32 bg-blue-500 text-white hover:bg-blue-600 rounded px-4 py-2">
                    New Request
                </button>
            </div>
            <div class="report-data"></div>
            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" x-cloak>
                <div class="bg-white w-11/12 md:w-screen lg:w-1/2 p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-700">Add New Request</h2>
                        <button @click="showModal = false" class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
                    </div>
                    <form action="{{ route('report.store') }}" method="post" class="space-y-4">
                        @csrf

                        <!-- Requestor Name -->
                        <div>
                            <label for="client_id" class="block text-sm font-medium text-gray-700">Requestor Name</label>
                            <select name="client_id" id="client_id" class="input block w-full mt-1 border-gray-300 rounded-lg">
                                <option value="">Select Name</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department_id" id="department_id" class="input block w-full mt-1 border-gray-300 rounded-lg">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Issue -->
                        <div>
                            <label for="issues_id" class="block text-sm font-medium text-gray-700">Issue</label>
                            <select name="issues_id" id="issues_id" class="input block w-full mt-1 border-gray-300 rounded-lg">
                                <option value="">Select Issue</option>
                                @foreach($issues as $issue)
                                    <option value="{{ $issue->id }}">{{ $issue->title }}</option>
                                @endforeach
                            </select>
                            @error('issues_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea rows="4" class="w-full h-32 p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
{{-- resolve modal --}}
<div x-show="resolveModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6  w-11/12 md:w-screen lg:w-1/2 rounded-lg">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold">Resolve</h3>
            <button @click="resolveModal = false" class="text-gray-500 hover:text-gray-800">X</button>
        </div>
        <form :action="'/report/resolve/' + selectedId" method="GET">
            <!-- Your form content here -->
            @csrf
            {{-- <div class="mb-4 mt-4">
                <label for="user_id">Technical Staff</label>
                <select name="user_id1" id="user_id" class="input">
                    <option value="">Select Technical staff</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="procedure">Procedure</label>
                <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}">
            </div> --}}
            <div x-data="{ items: [{ name: '', quantity: '' }] }">
                <template x-for="(item, index) in items" :key="index">
                    <div class="mb-4 mt-4">
                        <label for="user_id">Technical Staff</label>
                        <select name="user[][user_id]" id="user_id" class="input" x-model="item.name" required>
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 text-sm px-4 rounded-full mt-4" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                    </div>

                </template>
                <div class="mb-4">
                    <label for="procedure">Procedure</label>
                    <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}">

                    
                </div>
                <button type="button" class="text-sm bg-slate-800 hover:bg-slate-900 text-white py-2 px-4 rounded-full mb-4" @click="items.push({ name: '', quantity: '' })">Add Technical staff</button>
            </div>

            <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                Resolved
            </button>
        </form>
    </div>
</div>
{{-- end of resolve --}}

{{-- escalate modal --}}
<div x-show="escalateModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
<div class="bg-white p-6 rounded-lg  w-11/12 md:w-screen lg:w-1/2">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">Escalate</h3>
        <button @click="escalateModal = false" class="text-gray-500 hover:text-gray-800">X</button>
    </div>
    <form :action="'/report/escalate/' + selectedId" method="GET">
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
            @error('user_id')
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
            <label for="procedure">Procedure</label>
            <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}">
            @error('procedure')
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
            <input type="text" name="remarks" class="input @error('remarks') ring-red-500 @enderror" value="{{ old('remarks')}}">
            @error('remarks')
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
            Escalate
        </button>
    </form>
</div>
</div>
{{-- end of resolve --}}

</div>
{{-- </div> --}}
            <!-- List of Resolved Issues -->
            <div class="mt-10 card px-4">
                <h1 class="text-lg md:text-xl font-bold mb-4 text-gray-800">List of Resolved Issues</h1>

                <div class="overflow-auto max-h-[350px] pb-10">
                    <!-- Table: Visible on medium screens (md) and larger -->
                    <div class="hidden md:block">
                        <table class="w-full text-left text-xs md:text-sm border-collapse border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border border-gray-300 px-2 py-2">#</th>
                                    <th class="border border-gray-300 px-2 py-2">Ticket Number</th>
                                    <th class="border border-gray-300 px-2 py-2">Requestor Name</th>
                                    <th class="border border-gray-300 px-2 py-2">Department</th>
                                    <th class="border border-gray-300 px-2 py-2">Category</th>
                                    <th class="border border-gray-300 px-2 py-2">Issue</th>
                                    <th class="border border-gray-300 px-2 py-2">Requested Date</th>
                                    <th class="border border-gray-300 px-2 py-2">Waiting Time</th>
                                    <th class="border border-gray-300 px-2 py-2">Resolved Time</th>
                                    <th class="border border-gray-300 px-2 py-2">Resolved Date</th>
                                    <th class="border border-gray-300 px-2 py-2">Remarks</th>
                                    <th class="border border-gray-300 px-2 py-2">Technical Staff</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach($resolved as $resolve)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border border-gray-300 px-2 py-2">{{ $count++ }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->ticket_number }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->clientname->name }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->Department?->title }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->Issues?->Category?->title }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->Issues?->title }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ date('F d, Y h:i a', strtotime($resolve->request_datetime)) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @php
                                                $diffInMinutes = \Carbon\Carbon::parse($resolve->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->response_datetime));
                                            @endphp
        
                                            @if ($diffInMinutes >= 60)
                                                {{ round($diffInMinutes / 60) }} hrs
                                            @else
                                                {{ round($diffInMinutes) }} mins
                                            @endif
        
                                        </td>
                                        
                            
                                        <td class="border border-gray-300 px-2 py-2">
                                            @php
                                                $diffInMinutes = \Carbon\Carbon::parse($resolve->response_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->resolve_datetime));
                                            @endphp
        
                                            @if ($diffInMinutes >= 60)
                                                {{ round($diffInMinutes / 60) }} hrs
                                            @else
                                                {{ round($diffInMinutes) }} mins
                                            @endif
        
                                        </td>
                                    
                                        
                                        <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">{{ date('F d, Y h:i a', strtotime($resolve->resolve_datetime)) }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->remarks }}</td>
                                        <td class="border border-gray-300 px-2 py-2">{{ $resolve->user }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Card: Visible only on small screens (mobile) -->
                    <div class="block md:hidden">
                        @foreach($resolved as $resolve)
                        <div class="border p-4 rounded-lg shadow mb-2">
                            <h2 class="font-bold">{{ $resolve->client?->name }} - {{ $resolve->department?->title }}</h2>
                            <p>Ticket No: {{ $resolve->ticket_number }}</p>
                            <p>Issues: {{ $resolve->issues?->title }}</p>
                            <p class="font-bold">Technical Staff: {{ $resolve->user }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
                 {{-- {{ $resolved->links() }} --}}
            </div>
        </div>
    </div>

    <script>

        $(document).ready(()=>{
          
            const interval = setInterval(function() {
                checkTotal();
            }, 1000); // Execute every 1 second


            const checking = ()=>{
                $.ajax({
                    url: '/reports',
                    method: 'GET',
                    success:function(response){
                        $('.report-data').html(response);
                    }
                });
            }

            checking();

            const checkTotal = ()=>{
                $.ajax({
                    url: '/getstotal',
                    method: 'GET',
                    success:function(response){
                       var first = $('.firstCount').val();  
                        if (first != response) {
                            checking();
                            $('.firstCount').val(response)
                        }
                    }
                });
            }

       
        });


    </script>


</x-layout>
