<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code for Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') <!-- Assuming you're using Vite with Tailwind --> --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-4">

    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">📲 BCDA QR Generator</h1>

        <form method="POST" action="{{ route('generate.qr') }}" class="mb-6">
            @csrf
            <div class="mb-4 text-left">
                <label for="Full Name" class="block text-gray-700 font-semibold mb-2">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4 text-left">
                <label for="Designation" class="block text-gray-700 font-semibold mb-2">Designation:</label>
                <input type="text" id="designation" name="designation" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">   
            </div>

            <div class="mb-4 text-left">
                <label for="Telephone" class="block text-gray-700 font-semibold mb-2">Telephone (Office):</label>
                <input type="text" id="telephone" name="telephone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4 text-left">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" autocomplete="off">
            </div>

             <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                Generate QR Code
            </button>


        {{-- <p class="text-gray-600 mb-6 leading-relaxed">
            Scan the QR code below to participate in the <span class="font-semibold text-indigo-600">{{ $title }} Survey</span>.
            Your feedback helps us improve our services and better support your department.
        </p>

        <div class="flex justify-center mb-6">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
           @php
$vcard = "BEGIN:VCARD\n";
$vcard .= "VERSION:3.0\n";
$vcard .= "FN:Romnick Alfonso\n";                   // Full Name
$vcard .= "TITLE:Computer Programmer III\n";        // Designation
$vcard .= "ORG:Bases Conversion and Development Authority\n";                             // Company Name
$vcard .= "TEL;TYPE=cell:+639123456789\n";          // Mobile
$vcard .= "TEL;TYPE=work:+63288887777\n";           // Office
$vcard .= "EMAIL:romnick@example.com\n";            // Email
$vcard .= "URL:https://bcda.gov.ph\n";              // Website
$vcard .= "END:VCARD";
@endphp
                {!! QrCode::size(200)->generate($vcard) !!}
            </div>
        </div>

        <p class="text-sm text-gray-500">URL: <span class="text-blue-600 break-words">{{ $url }}</span></p>
        <p class="text-lg text-gray-600 font-semi mt-5">(BCDA Personnel Only)</p> --}}
    </div>

</body>
</html>