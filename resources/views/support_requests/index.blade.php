<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Requests - {{ env('APP_NAME', 'IT Department') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');</script>
</head>
<body class="flex flex-col min-h-screen pt-16 bg-gray-50 dark:bg-slate-900 transition-colors duration-200">
@include('support_requests._nav')
<main class="flex-grow"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8"><div class="flex justify-between items-start"><div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Support Requests</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage IT personnel support requests</p>
    </div><a href="{{ route('support-requests.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg"><i class="material-icons">add</i>New Request</a></div></div>
    @if(session('success'))<div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg flex items-center gap-3 shadow-sm mb-6"><i class="material-icons text-green-500">check_circle</i><div><p class="font-semibold">Success!</p><p class="text-sm">{{ session('success') }}</p></div></div>@endif
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        @if($supportRequests->count() > 0)
        <div class="overflow-x-auto"><table class="w-full text-sm text-gray-900 dark:text-gray-100"><thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600"><tr>
            <th class="px-6 py-4 font-semibold text-left">Event Title</th><th class="px-6 py-4 font-semibold text-left">Requestor</th><th class="px-6 py-4 font-semibold text-left">Start Date/Time</th><th class="px-6 py-4 font-semibold text-left">End Date/Time</th><th class="px-6 py-4 font-semibold text-left">Assigned IT</th><th class="px-6 py-4 font-semibold text-left">Status</th><th class="px-6 py-4 font-semibold text-center">Actions</th>
        </tr></thead><tbody class="divide-y divide-gray-200 dark:divide-slate-600">
        @foreach($supportRequests as $request)
            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                <td class="px-6 py-4"><span class="font-medium">{{ $request->event_title }}</span></td>
                <td class="px-6 py-4">{{ $request->requester->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $request->start_datetime->format('M d, Y H:i') }}</td>
                <td class="px-6 py-4">{{ $request->end_datetime->format('M d, Y H:i') }}</td>
                <td class="px-6 py-4">{{ $request->assignedIt->name ?? 'Not assigned' }}</td>
                <td class="px-6 py-4">@php $statusColors=['pending'=>'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400','approved'=>'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400','rejected'=>'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400','assigned'=>'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400','in_progress'=>'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400','completed'=>'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400','cancelled'=>'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400']; @endphp <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst(str_replace('_',' ', $request->status)) }}</span></td>
                <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('support-requests.show', $request) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800" title="View"><i class="material-icons text-lg">visibility</i></a><a href="{{ route('support-requests.edit', $request) }}" class="text-orange-600 dark:text-orange-400 hover:text-orange-800" title="Edit"><i class="material-icons text-lg">edit</i></a><form action="{{ route('support-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this request?');">@csrf @method('DELETE')<button type="submit" class="text-orange-600 dark:text-orange-400 hover:text-orange-800" title="Cancel"><i class="material-icons text-lg">cancel</i></button></form></div></td>
            </tr>
        @endforeach
        </tbody></table></div><div class="px-6 py-4 border-t border-gray-200 dark:border-slate-600">{{ $supportRequests->links() }}</div>
        @else
        <div class="text-center py-12"><i class="material-icons text-6xl text-gray-300 dark:text-gray-600 mb-4">inbox</i><p class="text-gray-600 dark:text-gray-400 text-lg">No requests found. <a href="{{ route('support-requests.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Create one now</a></p></div>
        @endif
    </div>
</div></main>
<footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-6 mt-auto"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><div class="flex flex-col items-center justify-center space-y-2"><div class="flex items-center space-x-2"><span class="text-sm text-gray-600 dark:text-gray-400">Powered by</span><img src="{{ asset('images/ICTD_Logo.png') }}" alt="ICTD Logo" class="h-8 w-auto" /></div><p class="text-sm text-gray-600 dark:text-gray-400">© 2026 Support Request System • Bases Conversion and Development Authority (BCDA). All rights reserved.</p></div></div></footer>
</body></html>
