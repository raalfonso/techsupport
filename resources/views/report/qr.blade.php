<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center">
            <!-- Success Icon -->
            <div class="mb-6">
                <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-check text-green-600 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Emergency Report Created</h1>
                <p class="text-gray-600">Status: <span class="font-semibold text-orange-600">Ongoing</span></p>
            </div>
            
            <!-- QR Code -->
            <div class="mb-6">
                <p class="text-gray-700 mb-4">Scan QR code to mark as completed:</p>
                <div class="flex justify-center mb-4">
                    {!! $qrCode !!}
                </div>
                {{-- <p class="text-sm text-gray-500">Report ID: <span class="font-mono font-semibold">{{ $report_id }}</span></p> --}}
            </div>
            
            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('report.index') }}" class="w-full bg-blue-600 text-white py-3 px-6 rounded-xl hover:bg-blue-700 transition-colors font-medium inline-block">
                    Back to Reports
                </a>
                <button onclick="toggleQRCode()" class="w-full bg-gray-600 text-white py-3 px-6 rounded-xl hover:bg-gray-700 transition-colors font-medium">
                    Toggle QR Code
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleQRCode() {
            const qrContainer = document.querySelector('.flex.justify-center.mb-4');
            qrContainer.style.display = qrContainer.style.display === 'none' ? 'flex' : 'none';
        }
    </script>
</x-layout>