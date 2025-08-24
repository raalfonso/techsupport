<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css') {{-- Tailwind via Vite --}}
</head>
<body class="bg-gray-100 text-gray-800">
   <div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-6 text-center">
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2">Thank You!</h1>
        <p class="text-gray-600 mb-4">We appreciate your feedback and will use it to improve our services.</p>

        @if(session('customMessage'))
            <p class="text-blue-600 font-medium mb-4">{{ session('customMessage') }}</p>
        @endif
       
    </div>
</div>

</body>
</html>