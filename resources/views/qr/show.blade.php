<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCDA QR Maker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">📲 BCDA QR Maker</h1>

        @isset($qrCode)
            <div class="flex flex-col items-center">
                <div id="qrContainer" class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                    {!! $qrCode !!}
                </div>
                <p class="text-gray-600 mb-4">
                    Scan to visit: <strong>{{ $websiteUrl }}</strong>
                </p>

                <div class="flex gap-3 justify-center">
                    <button 
                        id="downloadBtn"
                         class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-700">
                        ⬇️ Download QR Code
                    </button>

                    <a href="{{ route('qr.show') }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        🔁 Regenerate
                    </a>
                </div>
            </div>
        @else
            <form action="{{ route('qr.generateshow') }}" method="POST" class="mb-6">
                @csrf
                <input 
                    type="url" 
                    name="url" 
                    placeholder="Enter website URL" 
                    value="{{ old('url', $websiteUrl ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg p-2 mb-3"
                    required>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Generate QR Code
                </button>
            </form>
        @endisset
    </div>

    <script>
        // Convert SVG to PNG and download it
        document.getElementById('downloadBtn')?.addEventListener('click', function () {
            const svgElement = document.querySelector('#qrContainer svg');
            if (!svgElement) return;

            const svgData = new XMLSerializer().serializeToString(svgElement);
            const canvas = document.createElement('canvas');
            const img = new Image();
            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                URL.revokeObjectURL(url);

                const pngUrl = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.href = pngUrl;
                downloadLink.download = 'bcda_qrcode.png';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            };

            img.src = url;
        });
    </script>

</body>
</html>
