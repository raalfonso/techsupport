<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Completed</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center">
        @if(isset($error))
            <div class="bg-yellow-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Already Completed</h1>
            <p class="text-gray-600 mb-6">{{ $error }}</p>
        @else
            <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-green-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Report Completed!</h1>
            <p class="text-gray-600 mb-6">Emergency report has been marked as completed successfully.</p>
        @endif
        
        {{-- <p class="text-sm text-gray-500 mb-6">Report ID: <span class="font-mono font-semibold">{{ $report_id }}</span></p> --}}
        
        <div class="text-center">
            <p class="text-gray-600">Thank you for using our emergency reporting system.</p>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>