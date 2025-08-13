<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generator</title>
</head>
<body class="p-6 bg-gray-100 text-center">
    <h1 class="text-xl font-bold mb-4">QR Code for Department</h1>

    <p class="mb-2">URL: {{ $url }}</p>

    <div class="inline-block p-4 bg-white rounded shadow">
        {!! QrCode::size(200)->generate($url) !!}
    </div>
</body>
</html>
