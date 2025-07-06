<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Agus Setiawan Store</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- JsBarcode & QR Code Scanner -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-white text-blue-800 min-h-screen flex flex-col items-center p-6">

    <!-- Header -->
    <header class="w-full max-w-6xl text-center mb-12">
        <h1 class="text-4xl font-bold mb-3">Agus Setiawan Store</h1>
        <p class="text-lg text-blue-600">Temukan Sepatu Terbaik untuk Setiap Langkah Anda</p>
    </header>

    <!-- Promo & Scanner Section -->
    <section class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Promo -->
        <div class="bg-white border border-blue-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Promo Sepatu Terbaru</h2>
            <img src="{{ asset('storage/sepatu/puma22.jpeg') }}" alt="Promo Sepatu" class="w-full rounded shadow">
            <p class="mt-4 text-blue-600 text-center">
                Dapatkan potongan harga menarik untuk koleksi sepatu terbaru kami!
            </p>
        </div>

        <!-- Barcode Scanner -->
        <div class="bg-white border border-blue-100 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-2xl font-semibold mb-4">Scan Produk</h3>
            <svg id="barcode" class="mx-auto mb-4"></svg>
            <div id="reader" class="mt-4 mx-auto w-full max-w-sm border p-4 rounded-lg bg-blue-50 shadow-inner"></div>
            <input id="barcodeInput" class="mt-4 border border-blue-300 p-3 rounded w-full max-w-sm text-center text-blue-700 font-medium" placeholder="Hasil scan muncul di sini" readonly>
        </div>
    </section>

    <!-- Sales Chart -->
    <section class="w-full max-w-4xl bg-white border border-blue-100 p-6 rounded-lg shadow-md mb-12">
        <h2 class="text-2xl font-semibold text-center mb-4">Statistik Penjualan Sepatu</h2>
        <canvas id="salesChart" class="w-full h-64"></canvas>
    </section>

    <!-- Login Button -->
    <div>
        <a href="{{ route('login') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg shadow-md transition-transform hover:scale-105">
            Login ke Akun Anda
        </a>
    </div>

    <!-- Script -->
    <script>
        // Barcode Generator
        JsBarcode("#barcode", "123456789012", {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 60,
            displayValue: true,
            fontSize: 16,
            margin: 10
        });

        // QR Code Scanner
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('barcodeInput').value = decodedText;
            JsBarcode("#barcode", decodedText, {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 60,
                displayValue: true,
                fontSize: 16,
                margin: 10
            });
        }

        new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        }).render(onScanSuccess);

        // Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Nike', 'Adidas', 'Puma', 'Homyped', 'Jordan'],
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: [120, 95, 80, 70, 60],
                    backgroundColor: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE', '#DBEAFE'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 20 }
                    }
                }
            }
        });
    </script>
</body>
</html>
