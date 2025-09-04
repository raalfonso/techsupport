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

        <div class="flex justify-center mb-6">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200" id="qr-container">
                {!! QrCode::size(200)->generate($vCard) !!}
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <!-- Download Button -->
            <button id="downloadBtn" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                ⬇️ Download QR Code
            </button>

            <!-- Regenerate Button -->
            <a href="{{ route('vcard') }}" 
            class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-gray-600">
                🔄 Regenerate
            </a>
        </div>
    </div>

<script>
document.getElementById("downloadBtn").addEventListener("click", function () {
    let svg = document.querySelector("#qr-container svg");
    let svgData = new XMLSerializer().serializeToString(svg);
    let canvas = document.createElement("canvas");
    let ctx = canvas.getContext("2d");
    let img = new Image();
    img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);
        let pngFile = canvas.toDataURL("image/png");
        let link = document.createElement("a");
        link.download = "bcda-qr.png";
        link.href = pngFile;
        link.click();
    };
    img.src = "data:image/svg+xml;base64," + btoa(svgData);
});
</script>
</body>
</html>