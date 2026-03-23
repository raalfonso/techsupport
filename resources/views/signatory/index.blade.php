<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Signatories</h1>
                <p class="text-gray-500 text-sm mt-1">Manage document signatories</p>
            </div>
            <a href="{{ route('signatory.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                <i class="material-icons text-sm">add</i> Add
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Employee ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Position / Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($signatories as $signatory)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $signatory->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 text-sm font-bold">{{ substr($signatory->employee->full_name ?? '?', 0, 1) }}</span>
                                        </div>
                                        {{ $signatory->employee->full_name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-700">{{ $signatory->employee->employee_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                        {{ $signatory->position }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $signatory->department->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        <a href="{{ route('signatory.edit', $signatory) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                            <i class="material-icons text-base">edit</i>
                                        </a>
                                        <form action="{{ route('signatory.destroy', $signatory) }}" method="POST" class="inline" onsubmit="return confirm('Delete this signatory?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                                <i class="material-icons text-base">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">No signatories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $signatories->links() }}
        </div>
    </div>
</div>
</x-layout>
