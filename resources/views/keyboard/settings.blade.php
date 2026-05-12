<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Key Board</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900">

    @include('keyboard._nav')
    
    <main class="flex-grow pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Key Board Settings</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage meeting types and preferences</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Meeting Types Management -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Meeting Types</h2>
                    <button onclick="openAddTypeModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i> Add Type
                    </button>
                </div>

                <div class="space-y-3">
                    @forelse($meetingTypes as $type)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-3 h-3 rounded-full {{ $type->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $type->title }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $type->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="openEditTypeModal({{ $type->id }}, '{{ $type->title }}', {{ $type->is_active ? 'true' : 'false' }})" 
                                    class="text-blue-600 hover:text-blue-700 p-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('keyboard.types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Delete this meeting type?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 p-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No meeting types defined</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Type Modal -->
    <div id="addTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Add Meeting Type</h2>
                <button onclick="closeAddTypeModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="{{ route('keyboard.types.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Type Name *</label>
                    <input type="text" name="title" required 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Add Type
                    </button>
                    <button type="button" onclick="closeAddTypeModal()" class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Type Modal -->
    <div id="editTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Meeting Type</h2>
                <button onclick="closeEditTypeModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="editTypeForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Type Name *</label>
                    <input type="text" id="editTypeTitle" name="title" required 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="editTypeActive" name="is_active" value="1" class="rounded">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Update Type
                    </button>
                    <button type="button" onclick="closeEditTypeModal()" class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddTypeModal() {
            document.getElementById('addTypeModal').classList.remove('hidden');
        }

        function closeAddTypeModal() {
            document.getElementById('addTypeModal').classList.add('hidden');
        }

        function openEditTypeModal(id, title, isActive) {
            document.getElementById('editTypeForm').action = `/keyboard/types/${id}`;
            document.getElementById('editTypeTitle').value = title;
            document.getElementById('editTypeActive').checked = isActive;
            document.getElementById('editTypeModal').classList.remove('hidden');
        }

        function closeEditTypeModal() {
            document.getElementById('editTypeModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('addTypeModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAddTypeModal();
        });

        document.getElementById('editTypeModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditTypeModal();
        });
    </script>
</body>
</html>
