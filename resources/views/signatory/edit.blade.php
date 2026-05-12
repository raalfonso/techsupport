<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-sm mt-5 card p-5 shadow-lg rounded-lg">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('signatory.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class="material-icons">arrow_back</i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Signatory</h1>
                <p class="text-gray-500 text-sm">Update the signatory details</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('signatory.update', $signatory) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                @include('signatory._form')
                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="material-icons text-sm">save</i> Update
                    </button>
                    <a href="{{ route('signatory.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg font-semibold text-sm hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>
