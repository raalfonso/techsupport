<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code for {{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') <!-- Assuming you're using Vite with Tailwind --> --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-4">

    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">📲 Department Survey QR Code</h1>

        <p class="text-gray-600 mb-6 leading-relaxed">
            Scan the QR code below to participate in the <span class="font-semibold text-indigo-600">{{ $title }} Survey</span>.
            Your feedback helps us improve our services and better support your department.
        </p>

        <div class="flex justify-center mb-6">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                {!! QrCode::size(200)->generate($url) !!}
            </div>
        </div>

        <p class="text-sm text-gray-500">URL: <span class="text-blue-600 break-words"><a href="{{ $url }}" target="_blank">{{ $url }}</a></span></p>
        <p class="text-lg text-gray-600 font-semi mt-5">(BCDA Personnel Only)</p>
    </div>

</body>
</html>