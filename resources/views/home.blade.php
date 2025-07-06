<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Sepatu - Groovin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 font-sans">

    <!-- Judul Katalog -->
    <section class="text-center py-10">
        <h2 class="text-2xl font-semibold text-green-600 uppercase">Katalog</h2>
        <p class="text-gray-500 text-sm">Produk kami</p>
    </section>

    <!-- Filter Kategori -->
    <div class="flex justify-center gap-3 flex-wrap px-4 mb-8">
        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Sepatu Pria</button>
        <button class="border border-green-500 text-green-600 px-3 py-1 rounded text-sm hover:bg-green-500 hover:text-white">Sepatu Wanita</button>
        <button class="border border-green-500 text-green-600 px-3 py-1 rounded text-sm hover:bg-green-500 hover:text-white">Sandal Pria</button>
        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Sandal Wanita</button>
    </div>

    <!-- Produk List -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-6 pb-12">
        <div class="bg-gray-100 rounded shadow p-4">
            <img src="https://imgur.com/U4d0pWi.png" alt="Sepatu Pria Hijau" class="w-full h-60 object-contain">
        </div>
        <div class="bg-gray-100 rounded shadow p-4">
            <img src="https://imgur.com/FyYoXAd.png" alt="Sepatu Pria Biru" class="w-full h-60 object-contain">
        </div>
        <div class="bg-gray-100 rounded shadow p-4">
            <img src="https://imgur.com/MUcc6nH.png" alt="Sneakers Wanita" class="w-full h-60 object-contain">
        </div>
    </section>

    <!-- Tombol Scroll Top -->
    <a href="#" class="fixed bottom-5 right-5 bg-green-500 text-white p-3 rounded-full shadow hover:bg-green-600">
        ↑
    </a>

</body>
</html>
